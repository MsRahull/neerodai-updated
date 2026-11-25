@if($contact->replied_at)
    <span class="cc-badge cc-badge-ok" title="Last reply {{ $contact->replied_at->format('d M Y, h:i A') }} ({{ $contact->reply_count }} total)">
        <i class="{{ $contact->replied_via === 'whatsapp' ? 'fab fa-whatsapp' : 'fas fa-envelope' }}"></i> Replied
    </span>
    <div class="small text-muted mt-1 text-nowrap">{{ $contact->replied_at->format('d M, h:i A') }}</div>
@else
    <span class="cc-badge cc-badge-wait"><i class="fas fa-clock"></i> Not replied</span>
@endif
