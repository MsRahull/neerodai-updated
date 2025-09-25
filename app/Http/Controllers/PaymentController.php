<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Donation; // ⬅️ add this at the top with other imports
use App\Mail\DonationSuccessMail;
use Illuminate\Support\Facades\Mail;


class PaymentController extends Controller
{
    //  public function index()
    // {
    //     $donations = Donation::latest()->paginate(3);
        
    //     return view('admin.adminpayments', compact('donations'));
    // }

    public function index(Request $request)
{
    $query = Donation::query();

    if ($request->filled('name')) {
        $query->where('name', 'like', '%'.$request->name.'%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%'.$request->email.'%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59'
        ]);
    }

    $donations = $query->latest()->paginate(1)->appends($request->query());

    return view('admin.adminpayments', compact('donations'));
}
    public function pay() {
        return view('pay', [
            'razorpayKey' => env('RAZORPAY_KEY')
        ]);
    }


public function createOrder(Request $request)
{
    try {
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'pincode' => 'required|numeric|digits:6', // ✅ Added this
            'address' => 'nullable|string'
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        

        $order = $api->order->create([
            'receipt' => 'rcptid_' . time(),
            'amount' => (int) $validated['amount'] * 100, // paise
            'currency' => 'INR',
        ]);

        Log::info('Donation order created', [
            'order_id' => $order['id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'pincode' => $validated['pincode'],
            'address' => $request->input('address', ''), // optional
            'amount' => $validated['amount']
        ]);

        return response()->json(['orderId' => $order['id'], 'currency' => 'INR']);

    } catch (ValidationException $e) {
        // Return validation errors as JSON
        return response()->json([
            'status' => 'error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('CreateOrder Failed: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create order: ' . $e->getMessage()
        ], 500);
    }
}



// public function paymentSuccess(Request $request)
// {
//     $data = $request->all();
//     $attributes = [
//         'razorpay_order_id' => $data['razorpay_order_id'] ?? null,
//         'razorpay_payment_id' => $data['razorpay_payment_id'] ?? null,
//         'razorpay_signature' => $data['razorpay_signature'] ?? null,
//     ];
//     if (! $attributes['razorpay_order_id'] || ! $attributes['razorpay_payment_id'] || ! $attributes['razorpay_signature']) {
//         return response()->json(['status' => 'error', 'message' => 'Missing payment fields'], 400);
//     }
//     try {
//         $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
//         $api->utility->verifyPaymentSignature($attributes);

//         // Save donor details and payment info
//         Log::info('Donation payment verified', [
//             'order_id' => $attributes['razorpay_order_id'],
//             'payment_id' => $attributes['razorpay_payment_id'],
//             'name' => $data['name'] ?? '',
//             'email' => $data['email'] ?? '',
//             'phone' => $data['phone'] ?? '',
//             'address' => $data['address'] ?? '',
//             'amount' => $data['amount'] ?? 0
//         ]);
//         // Optionally insert into database

//         return response()->json(['status' => 'success', 'message' => 'Payment Successful!']);
//     } catch (\Exception $e) {
//         Log::error('Razorpay verification failed: '.$e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Payment verification failed'], 400);
//     }
// }

public function paymentSuccess(Request $request)
{
    $data = $request->all();

    $attributes = [
        'razorpay_order_id' => $data['razorpay_order_id'] ?? null,
        'razorpay_payment_id' => $data['razorpay_payment_id'] ?? null,
        'razorpay_signature' => $data['razorpay_signature'] ?? null,
    ];

    if (! $attributes['razorpay_order_id'] || ! $attributes['razorpay_payment_id'] || ! $attributes['razorpay_signature']) {
        return response()->json(['status' => 'error', 'message' => 'Missing payment fields'], 400);
    }

    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $api->utility->verifyPaymentSignature($attributes);

        // ✅ Save donor + payment details to DB
        $donation = Donation::create([
            'name'       => $data['name'] ?? '',
            'email'      => $data['email'] ?? '',
            'phone'      => $data['phone'] ?? '',
            'address'    => $data['address'] ?? '',
            'pincode'    => $data['pincode'] ?? '',
            'amount'     => $data['amount'] ?? 0,
            'order_id'   => $attributes['razorpay_order_id'],
            'payment_id' => $attributes['razorpay_payment_id'],
            'signature'  => $attributes['razorpay_signature'],
            'status'     => 'success',
            'response'   => json_encode($data) // store full raw response
        ]);
        Mail::to($donation->email)->send(new DonationSuccessMail($donation));

        Log::info('Donation payment verified and saved', $donation->toArray());

        return response()->json(['status' => 'success', 'message' => 'Payment Successful!']);
    } catch (\Exception $e) {
        Log::error('Razorpay verification failed: '.$e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Payment verification failed'], 400);
    }
}


}
