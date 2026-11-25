<?php

namespace App\Http\Controllers;

use App\Mail\DonationSuccessMail;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private const GST_RATE = 0.18;

    // =========================================================================
    // Razorpay helpers (values come from config/services.php)
    // =========================================================================
    private function razorpay(): Api
    {
        $key    = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            throw new \RuntimeException('Payment gateway is not configured.');
        }

        return new Api($key, $secret);
    }

    private function mode(): string
    {
        return (string) config('services.razorpay.mode', 'test');
    }

    /** Server-side amount calculation — the browser's numbers are never trusted. */
    private function amounts(float $base, bool $wantsGst): array
    {
        $base = round($base, 2);
        $gst  = $wantsGst ? round($base * self::GST_RATE) : 0.0;

        return [
            'base_amount'  => $base,
            'gst_amount'   => $gst,
            'amount'       => $base + $gst,
            'eighty_g_amt' => round($base * 0.5), // 80G = 50% of base only, not GST
        ];
    }

    // =========================================================================
    // ADMIN — donation list with filters
    // =========================================================================
    public function index(Request $request)
    {
        $donations = $this->filteredDonations($request)->paginate(15)->withQueryString();

        return view('admin.adminpayments', compact('donations'));
    }

    // ADMIN — download the filtered list as CSV (opens in Excel)
    public function export(Request $request)
    {
        $query = $this->filteredDonations($request);

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel shows Tamil / ₹ correctly
            fputcsv($out, ['ID', 'Date', 'Name', 'Email', 'Phone', 'Address', 'Pincode', 'PAN',
                'Donation', 'GST', 'Total', '80G amount', 'GSTIN', 'Company', 'Order ID', 'Payment ID', 'Status', 'Mode']);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $d) {
                    fputcsv($out, array_map(fn ($v) => $this->csvSafe($v), [
                        $d->id, $d->created_at?->format('Y-m-d H:i'), $d->name, $d->email, $d->phone,
                        $d->address, $d->pincode, $d->pan, $d->base_amount, $d->gst_amount, $d->amount,
                        $d->eighty_g_amt, $d->gst_number, $d->company_name, $d->order_id, $d->payment_id,
                        $d->status, $d->mode,
                    ]));
                }
            });
            fclose($out);
        }, 'donations-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Stops spreadsheet formula injection (a cell starting with = + - @). */
    private function csvSafe($value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@\t\r]/', $value) ? "'" . $value : $value;
    }

    private function filteredDonations(Request $request)
    {
        $request->validate([
            'status'    => 'nullable|in:pending,success,failed',
            'from_date' => 'nullable|date',
            'to_date'   => 'nullable|date',
        ]);

        $query = Donation::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        }

        return $query->latest();
    }

    // =========================================================================
    // GET /pay — donate page
    // =========================================================================
    public function pay()
    {
        return view('pay', [
            'razorpayKey' => (string) config('services.razorpay.key'),
        ]);
    }

    // =========================================================================
    // POST /create-order
    // Creates the Razorpay order AND a "pending" donation row holding the
    // server-calculated amount. Verification later trusts only this row.
    // =========================================================================
    public function createOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount'       => 'nullable|numeric|min:1|max:500000',
                'base_amount'  => 'required_without:amount|nullable|numeric|min:1|max:500000',
                'wants_gst'    => 'nullable|boolean',
                'gst_number'   => 'nullable|required_if:wants_gst,true,1|string|max:20',
                'company_name' => 'nullable|required_if:wants_gst,true,1|string|max:100',
                'name'         => 'required|string|max:100',
                'email'        => 'required|email|max:150',
                'phone'        => 'required|digits:10',
                'pincode'      => 'required|digits:6',
                'address'      => 'nullable|string|max:255',
                'pan'          => ['nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/i'],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        }

        $wantsGst = (bool) ($validated['wants_gst'] ?? false);
        $amounts  = $this->amounts((float) ($validated['base_amount'] ?? $validated['amount']), $wantsGst);

        try {
            $order = $this->razorpay()->order->create([
                'receipt'         => 'NROD-' . strtoupper(substr(uniqid(), -8)),
                'amount'          => (int) round($amounts['amount'] * 100),
                'currency'        => 'INR',
                'payment_capture' => 1,
                'notes'           => [
                    'donor_name'  => $validated['name'],
                    'donor_email' => $validated['email'],
                    'mode'        => $this->mode(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('createOrder failed: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Could not create order. Please try again.',
            ], 500);
        }

        Donation::create($amounts + [
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'address'      => $validated['address'] ?? '',
            'pincode'      => $validated['pincode'],
            'pan'          => isset($validated['pan']) ? strtoupper($validated['pan']) : null,
            'wants_gst'    => $wantsGst,
            'gst_number'   => $wantsGst ? strtoupper(preg_replace('/\s+/', '', $validated['gst_number'] ?? '')) : null,
            'company_name' => $wantsGst ? ($validated['company_name'] ?? null) : null,
            'order_id'     => $order['id'],
            'status'       => 'pending',
            'mode'         => $this->mode(),
        ]);

        return response()->json([
            'orderId'  => $order['id'],
            'currency' => 'INR',
            'mode'     => $this->mode(),
        ]);
    }

    // =========================================================================
    // POST /verify-payment — verify signature, confirm, mark paid, email receipt
    // =========================================================================
    public function paymentSuccess(Request $request)
    {
        try {
            $validated = $request->validate([
                'razorpay_order_id'   => 'required|string|max:64',
                'razorpay_payment_id' => 'required|string|max:64',
                'razorpay_signature'  => 'required|string|max:128',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        }

        $orderId   = $validated['razorpay_order_id'];
        $paymentId = $validated['razorpay_payment_id'];

        // ── 1. Signature (timing-safe). Proves Razorpay processed THIS order. ──
        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, (string) config('services.razorpay.secret'));

        if (!hash_equals($expected, $validated['razorpay_signature'])) {
            Log::warning('Razorpay signature mismatch', ['payment_id' => $paymentId, 'ip' => $request->ip()]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Payment verification failed. Please contact support.',
            ], 422);
        }

        $donation = Donation::where('order_id', $orderId)->first();

        if (!$donation) {
            Log::error('Verified payment for unknown order', ['order_id' => $orderId, 'payment_id' => $paymentId]);

            return response()->json([
                'status'  => 'error',
                'message' => 'We received your payment but could not find the order. Please contact support with your Payment ID.',
            ], 404);
        }

        // ── 2. Already processed? (double click / page refresh) ──
        if ($donation->status === 'success') {
            return response()->json(['status' => 'success', 'message' => 'Payment already processed.']);
        }

        // ── 3. Cross-check the payment with Razorpay (amount + status). ──
        try {
            $payment = $this->razorpay()->payment->fetch($paymentId);

            $expectedPaise = (int) round($donation->amount * 100);
            $okStatus      = in_array($payment->status, ['captured', 'authorized'], true);

            if ((int) $payment->amount !== $expectedPaise || $payment->order_id !== $orderId || !$okStatus) {
                Log::error('Razorpay payment does not match order', [
                    'donation_id' => $donation->id,
                    'expected'    => $expectedPaise,
                    'received'    => $payment->amount,
                    'status'      => $payment->status,
                ]);
                $donation->update(['status' => 'failed', 'payment_id' => $paymentId]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Payment could not be confirmed. Please contact support.',
                ], 422);
            }
        } catch (\Throwable $e) {
            // The signature already proves the payment belongs to this order, and the
            // order amount was set by the server — so it is safe to continue.
            Log::warning('Razorpay payment fetch failed, relying on signature: ' . $e->getMessage());
        }

        // ── 4. Mark as paid (row lock prevents two parallel requests double-processing). ──
        $updated = DB::transaction(function () use ($donation, $paymentId, $validated, $request) {
            $row = Donation::whereKey($donation->id)->lockForUpdate()->first();
            if ($row->status === 'success') {
                return false;
            }
            $row->update([
                'payment_id' => $paymentId,
                'signature'  => $validated['razorpay_signature'],
                'status'     => 'success',
                'response'   => json_encode($request->only(['razorpay_order_id', 'razorpay_payment_id'])),
            ]);

            return true;
        });

        if ($updated) {
            try {
                Mail::to($donation->email)->send(new DonationSuccessMail($donation->fresh()));
            } catch (\Throwable $e) {
                Log::error('DonationSuccessMail failed', ['donation_id' => $donation->id, 'error' => $e->getMessage()]);
            }

            Log::info('Donation verified', ['donation_id' => $donation->id, 'payment_id' => $paymentId]);
        }

        return response()->json([
            'status'       => 'success',
            'message'      => 'Payment successful! 🎉 Your 80G receipt will be emailed shortly.',
            'payment_id'   => $paymentId,
            'total_amount' => (float) $donation->amount,
            'gst_invoice'  => (bool) $donation->wants_gst,
        ]);
    }
}
