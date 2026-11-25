<x-mail::message>
{!! nl2br(e($replyBody)) !!}

<x-mail::panel>
**Your message to us ({{ $contact->created_at?->format('d M Y') }}):**

{!! nl2br(e(\Illuminate\Support\Str::limit($contact->message, 1000))) !!}
</x-mail::panel>

{{ config('app.name') }} Trust
</x-mail::message>
