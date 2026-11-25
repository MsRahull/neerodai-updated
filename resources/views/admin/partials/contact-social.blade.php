{{-- WhatsApp + Email reply buttons. Params: $contact, $replyTemplate, $withLabels (bool, optional) --}}
@php
    $template = str_replace(':name', $contact->name, $replyTemplate);
    $labels   = $withLabels ?? false;
@endphp
<div class="cc-social">
    <button type="button" class="btn btn-wa btn-sm" data-cc-reply="whatsapp"
            data-name="{{ $contact->name }}" data-wa="{{ $contact->whatsapp_number }}"
            data-email="{{ $contact->email }}" data-message="{{ $contact->message }}" data-template="{{ $template }}"
            data-wa-url="{{ route('contacts.whatsapp', $contact) }}" data-email-url="{{ route('contacts.email', $contact) }}"
            @if(!$contact->whatsapp_number) disabled title="Mobile number '{{ $contact->mobile }}' is not a valid WhatsApp number"
            @else title="Send WhatsApp message to +{{ $contact->whatsapp_number }}" @endif
            aria-label="WhatsApp {{ $contact->name }}">
        <i class="fab fa-whatsapp"></i>@if($labels) WhatsApp @endif
    </button>
    <button type="button" class="btn btn-primary btn-sm" data-cc-reply="email"
            data-name="{{ $contact->name }}" data-wa="{{ $contact->whatsapp_number }}"
            data-email="{{ $contact->email }}" data-message="{{ $contact->message }}" data-template="{{ $template }}"
            data-wa-url="{{ route('contacts.whatsapp', $contact) }}" data-email-url="{{ route('contacts.email', $contact) }}"
            title="Send email to {{ $contact->email }}" aria-label="Email {{ $contact->name }}">
        <i class="fas fa-envelope"></i>@if($labels) Email @endif
    </button>
</div>
