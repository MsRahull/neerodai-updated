@extends('user')

@section('title', __('Terms & Conditions') . ' - ' . __('Neerodai Trust'))

@section('content')
@include('partials.legal-page', [
    'heading'  => __('Terms & Conditions'),
    'intro'    => __('Welcome to Neerodai Trust. By using our website or donating through our payment gateway (Razorpay), you agree to these Terms and Conditions. Please read them carefully before making a contribution.'),
    'sections' => [
        [__('Purpose'), [
            __('Neerodai is a registered charitable trust dedicated to serving food to the underprivileged at their homes. All donations are used only for charitable and social welfare activities.'),
        ]],
        [__('Donations'), [
            __('Donations made through Razorpay or any other approved payment method are voluntary and non-refundable.'),
            __('Donors must provide accurate details (name, phone number and email) so that payments can be processed and receipts issued.'),
            __('We do not store or have access to your card or banking details. All transactions are processed securely by Razorpay.'),
        ]],
        [__('Tax Exemption'), [
            __('Where applicable, we issue receipts for eligible donations under Section 80G of the Income Tax Act. Please provide complete details, including PAN, to receive them.'),
        ]],
        [__('Use of Funds'), [
            __('All donations are used only for Neerodai’s charitable activities, including food distribution, community welfare and the operating costs of these programmes.'),
        ]],
        [__('Cancellation and Refund Policy'), [
            __('A donation cannot be cancelled or refunded once made, except for duplicate transactions or technical errors. Refund requests must be emailed to us within 7 working days with the transaction details.'),
        ]],
        [__('Limitation of Liability'), [
            __('We are not liable for any loss arising from failed transactions caused by internet problems, payment gateway errors or incorrect donor information.'),
        ]],
        [__('Changes to Terms'), [
            __('Neerodai may change these Terms and Conditions at any time. Updates will be posted on this website.'),
        ]],
        [__('Contact Information'), [
            __('For questions about these Terms, donations or refunds, please contact us at Neerodai Trust, South Street, Thatchamozhi, Sathankulam, Tamil Nadu 628704.'),
        ]],
    ],
])
@endsection
