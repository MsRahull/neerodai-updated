<x-mail::message>
# Thank You, {{ $donation->name }}! 🎉

We have received your donation successfully. Your support brings food, care and dignity to the elderly.

<x-mail::table>
| Donation details | |
|:--------------------|------------------:|
| Donation amount | ₹{{ number_format((float) $donation->base_amount, 2) }} |
@if($donation->wants_gst)
| GST (18%) | ₹{{ number_format((float) $donation->gst_amount, 2) }} |
@endif
| **Total paid** | **₹{{ number_format((float) $donation->amount, 2) }}** |
| Eligible for 80G deduction | ₹{{ number_format((float) $donation->eighty_g_amt, 2) }} |
@if($donation->pan)
| PAN | {{ $donation->pan }} |
@endif
| Payment ID | {{ $donation->payment_id }} |
| Order ID | {{ $donation->order_id }} |
| Date | {{ $donation->updated_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }} |
</x-mail::table>

@if($donation->wants_gst && $donation->gst_number)
A GST invoice will be issued to **{{ $donation->company_name }}** (GSTIN {{ $donation->gst_number }}).
@endif

Please keep this email for your records.

With gratitude,<br>
{{ config('app.name') }}
</x-mail::message>
