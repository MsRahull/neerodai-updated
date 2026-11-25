@extends('user')

@section('title', __('Privacy Policy') . ' - ' . __('Neerodai Trust'))
@section('meta_description', __('How Neerodai Trust collects, uses and protects your personal information when you visit our website or donate.'))

@section('content')
@include('partials.legal-page', [
    'heading'  => __('Privacy Policy'),
    'intro'    => null,
    'sections' => [
        [__('Information We Collect'), [
            __('When you make a donation or contact us, we may collect your name, email address and phone number, and the messages you send to us.'),
            __('Payment details are processed securely by Razorpay. We do not store card or banking information.'),
        ]],
        [__('How We Use Your Information'), [
            __('We use your data to process donations and issue receipts, to share updates about our work or events (if you opt in), and to meet legal and financial reporting requirements.'),
        ]],
        [__('Data Sharing'), [
            __('We do not sell, trade or rent donors’ personal information.'),
            __('Information may be shared with Razorpay or legal authorities only when required for payment processing, audit or compliance.'),
        ]],
        [__('Data Security'), [
            __('We follow reasonable security practices, and all payment data is encrypted through Razorpay’s secure gateway.'),
        ]],
        [__('Cookies'), [
            __('Our website uses cookies to remember your language and improve your browsing experience. You can disable cookies in your browser settings.'),
        ]],
        [__('Your Consent'), [
            __('By using our website and donating through Razorpay, you consent to the collection and use of your information as described in this Privacy Policy.'),
        ]],
        [__('Updates to Privacy Policy'), [
            __('We may update this Privacy Policy from time to time. Changes will be posted on this page.'),
        ]],
        [__('Contact Us'), [
            __('For privacy-related questions, please contact us:'),
        ]],
    ],
])
@endsection
