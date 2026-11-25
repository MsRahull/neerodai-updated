<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Admin's reply to a message sent through the website contact form. */
class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Contact $contact,
        public string $replySubject,
        public string $replyBody,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
            replyTo: [new Address(config('mail.from.address'), config('mail.from.name'))],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.contact_reply');
    }
}
