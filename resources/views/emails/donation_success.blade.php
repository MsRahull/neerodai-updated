<x-mail::message>
<!-- # Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} -->

@component('mail::message')
# Thank You, {{ $donation->name }}! 🎉

We have received your donation successfully.

**Donation Details:**
- Amount: ₹{{ number_format($donation->amount, 2) }}
- Payment ID: {{ $donation->payment_id }}
- Order ID: {{ $donation->order_id }}
- Date: {{ $donation->created_at->format('d M Y, h:i A') }}

We appreciate your support. 💖

Thanks,<br>
{{ config('app.name') }}
@endcomponent

</x-mail::message>
