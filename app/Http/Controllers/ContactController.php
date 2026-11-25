<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Admin: list contact messages (search + replied filter)
    public function index(Request $request)
    {
        $request->validate(['status' => 'nullable|in:replied,pending']);

        $contacts = Contact::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('mobile', 'like', $term)
                    ->orWhere('message', 'like', $term));
            })
            ->when($request->status === 'replied', fn ($q) => $q->whereNotNull('replied_at'))
            ->when($request->status === 'pending', fn ($q) => $q->whereNull('replied_at'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'all'     => Contact::count(),
            'pending' => Contact::whereNull('replied_at')->count(),
        ];

        return view('admin.admincustomers', compact('contacts', 'counts'));
    }

    // Admin: send an email reply to the person who wrote to us
    public function sendEmail(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:5000',
        ]);

        try {
            Mail::to($contact->email, $contact->name)
                ->send(new ContactReplyMail($contact, $data['subject'], $data['message']));
        } catch (\Throwable $e) {
            Log::error('Contact reply email failed', ['contact_id' => $contact->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'Email could not be sent. Please check the mail settings (MAIL_* in .env) and try again.');
        }

        $this->markReplied($contact, 'email');

        return back()->with('success', "Email sent to {$contact->email}.");
    }

    // Admin: WhatsApp opens in the admin's browser; this only records that a reply was made.
    public function markWhatsapp(Contact $contact)
    {
        if (!$contact->whatsapp_number) {
            return response()->json(['status' => 'error', 'message' => 'No valid WhatsApp number.'], 422);
        }

        $this->markReplied($contact, 'whatsapp');

        return response()->json(['status' => 'ok', 'replied_at' => $contact->replied_at->format('d M Y, h:i A')]);
    }

    // Admin: delete a contact message
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }

    // Public: contact form
    public function submit(Request $request)
    {
        // Honeypot: a hidden field real visitors never fill in. Bots do.
        if (filled($request->input('website'))) {
            return redirect()->back()->with('success', __('Thank you! We will contact you soon.'));
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'mobile'  => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'address' => 'required|string|max:500',
            'message' => 'required|string|max:3000',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', __('Thank you! We will contact you soon.'));
    }

    private function markReplied(Contact $contact, string $via): void
    {
        $contact->forceFill([
            'replied_at'  => now(),
            'replied_via' => $via,
            'reply_count' => $contact->reply_count + 1,
        ])->save();
    }
}
