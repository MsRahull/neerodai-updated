@extends('admin.dashboard')

@section('title', 'Customer Contacts')

@php
    // Default reply text (editable in the popup). :name is replaced with the person's name.
    $replyTemplate = "Hello :name,\n\nThank you for contacting Neerodai Trust. We have received your message and will help you soon.\n\nRegards,\nNeerodai Trust\n+91 81100 79041";
@endphp

@section('content')
<div class="py-4">

    {{-- ===== Header ===== --}}
    <div class="na-page-head">
        <div class="na-page-title">
            <span class="na-page-icon"><i class="fas fa-users"></i></span>
            <div>
                <h1>Customer Contacts</h1>
                <p>{{ $counts['all'] }} message(s) · <strong>{{ $counts['pending'] }}</strong> waiting for reply</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-triangle-exclamation me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-3 p-md-4">

            {{-- ===== Filters ===== --}}
            <form method="GET" class="row g-2 align-items-end mb-3">
                <div class="col-12 col-md-6 col-lg-5">
                    <label class="form-label small text-muted mb-1" for="q">Search</label>
                    <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email, mobile or message">
                </div>
                <div class="col-7 col-md-3 col-lg-2">
                    <label class="form-label small text-muted mb-1" for="status">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All</option>
                        <option value="pending" @selected(request('status') === 'pending')>Not replied</option>
                        <option value="replied" @selected(request('status') === 'replied')>Replied</option>
                    </select>
                </div>
                <div class="col-5 col-md-3 col-lg-2 d-flex gap-2">
                    <button class="btn btn-primary flex-fill"><i class="fas fa-filter"></i><span class="d-none d-sm-inline"> Filter</span></button>
                    @if(request()->hasAny(['q', 'status']))
                        <a href="{{ route('contacts.index') }}" class="btn btn-light" title="Clear"><i class="fas fa-xmark"></i></a>
                    @endif
                </div>
            </form>

            {{-- ===== Desktop: table ===== --}}
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0 cc-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width:48px">#</th>
                            <th style="width:26%">Contact</th>
                            <th>Message</th>
                            <th style="width:120px">Received</th>
                            <th style="width:120px">Status</th>
                            <th style="width:110px" class="text-center">Social</th>
                            <th style="width:56px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $contacts->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold cc-name" title="{{ $contact->name }}">{{ $contact->name }}</div>
                                <div class="small text-muted cc-ellipsis" title="{{ $contact->email }}"><i class="far fa-envelope me-1"></i>{{ $contact->email }}</div>
                                <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $contact->mobile }}</div>
                            </td>
                            <td>
                                <div class="cc-msg">{{ $contact->message }}</div>
                                <div class="small text-muted mt-1 text-truncate cc-addr" title="{{ $contact->address }}"><i class="fas fa-location-dot me-1"></i>{{ $contact->address }}</div>
                                <button type="button" class="btn btn-link btn-sm p-0 mt-1" data-cc-view
                                        data-name="{{ $contact->name }}" data-message="{{ $contact->message }}" data-address="{{ $contact->address }}">
                                    View full message
                                </button>
                            </td>
                            <td class="small text-nowrap">{{ $contact->created_at->format('d M Y') }}<br><span class="text-muted">{{ $contact->created_at->format('h:i A') }}</span></td>
                            <td>@include('admin.partials.contact-status', ['contact' => $contact])</td>
                            <td class="text-center">@include('admin.partials.contact-social', ['contact' => $contact, 'replyTemplate' => $replyTemplate])</td>
                            <td class="text-end">
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this message?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" title="Delete" aria-label="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No contact messages found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== Mobile / tablet: cards ===== --}}
            <div class="d-lg-none vstack gap-3">
                @forelse($contacts as $contact)
                    <article class="cc-card">
                        <div class="cc-card-head">
                            <div class="cc-card-who">
                                <div class="fw-semibold cc-name">{{ $contact->name }}</div>
                                <div class="small text-muted">{{ $contact->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            @include('admin.partials.contact-status', ['contact' => $contact])
                        </div>

                        <ul class="cc-meta">
                            <li class="cc-ellipsis" title="{{ $contact->email }}"><i class="far fa-envelope"></i>{{ $contact->email }}</li>
                            <li><i class="fas fa-phone"></i>{{ $contact->mobile }}</li>
                            <li class="cc-name" title="{{ $contact->address }}"><i class="fas fa-location-dot"></i>{{ $contact->address }}</li>
                        </ul>

                        <div class="cc-msg cc-msg-card">{{ $contact->message }}</div>
                        <button type="button" class="btn btn-link btn-sm p-0" data-cc-view
                                data-name="{{ $contact->name }}" data-message="{{ $contact->message }}" data-address="{{ $contact->address }}">
                            View full message
                        </button>

                        <div class="cc-actions">
                            @include('admin.partials.contact-social', ['contact' => $contact, 'replyTemplate' => $replyTemplate, 'withLabels' => true])
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" aria-label="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="text-center text-muted py-4 mb-0">No contact messages found.</p>
                @endforelse
            </div>

            @if($contacts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ===== Full message popup ===== --}}
<div class="modal fade" id="ccViewModal" tabindex="-1" aria-labelledby="ccViewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ccViewTitle">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-2" id="ccViewAddr"></p>
                <div class="cc-full" id="ccViewBody"></div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Reply popup (shared by the Email and WhatsApp buttons) ===== --}}
<div class="modal fade" id="ccReplyModal" tabindex="-1" aria-labelledby="ccReplyTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <form method="POST" id="ccReplyForm" class="d-flex flex-column h-100">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ccReplyTitle">
                        <span data-cc-icon class="me-1"></span> <span data-cc-title>Reply</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="cc-to mb-3">
                        <span class="text-muted">To:</span> <strong data-cc-to></strong>
                    </div>
                    <div class="mb-3" data-cc-subject-wrap>
                        <label class="form-label" for="ccSubject">Subject</label>
                        <input type="text" class="form-control" id="ccSubject" name="subject" maxlength="150" value="Reply from Neerodai Trust">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ccMessage">Message</label>
                        <textarea class="form-control" id="ccMessage" name="message" rows="8" maxlength="5000" required></textarea>
                        <div class="d-flex justify-content-between form-text">
                            <span data-cc-hint></span><span id="ccCount">0 / 5000</span>
                        </div>
                    </div>
                    <details class="cc-original">
                        <summary>Their original message</summary>
                        <div class="cc-full mt-2" data-cc-original></div>
                    </details>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" data-cc-send>
                        <span data-cc-send-icon class="me-1"></span><span data-cc-send-text>Send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cc-table td { vertical-align: top; }
    .cc-msg {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        overflow-wrap: anywhere; color: #334155; line-height: 1.5;
    }
    .cc-addr { max-width: 420px; }
    .cc-full { white-space: pre-line; overflow-wrap: anywhere; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: .6rem; padding: .9rem 1rem; line-height: 1.6; }
    .cc-card { border: 1px solid #e6ebf2; border-radius: .9rem; padding: 1rem; background: #fff; box-shadow: 0 2px 10px rgba(15,40,80,.04); }
    .cc-name { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; overflow-wrap: anywhere; }
    .cc-ellipsis { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%; }
    .cc-table td:nth-child(2) { max-width: 0; }
    .cc-card-head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: .5rem; }
    .cc-card-who { flex: 1 1 170px; min-width: 0; }
    .cc-table .cc-social { flex-wrap: nowrap; }
    .cc-meta { list-style: none; padding: 0; margin: .75rem 0; display: grid; gap: .3rem; font-size: .88rem; color: #475569; }
    .cc-meta i { width: 18px; color: #94a3b8; margin-right: .35rem; }
    .cc-msg-card { -webkit-line-clamp: 3; background: #f8fafc; border-radius: .6rem; padding: .6rem .75rem; font-size: .92rem; }
    .cc-actions { display: flex; align-items: center; justify-content: space-between; gap: .5rem; margin-top: .75rem; padding-top: .75rem; border-top: 1px solid #eef2f7; }
    .cc-social { display: inline-flex; gap: .4rem; flex-wrap: wrap; }
    .btn-wa { background: #25d366; border-color: #25d366; color: #fff; }
    .btn-wa:hover, .btn-wa:focus { background: #1da851; border-color: #1da851; color: #fff; }
    .btn-wa:disabled { background: #a7d9b8; border-color: #a7d9b8; }
    .cc-badge { display: inline-flex; align-items: center; gap: .35rem; font-size: .78rem; font-weight: 600; padding: .3rem .6rem; border-radius: 50px; white-space: nowrap; border: 1px solid; }
    .cc-badge-ok { background: #ecfdf3; color: #067647; border-color: #abefc6; }
    .cc-badge-wait { background: #fffaeb; color: #b54708; border-color: #fedf89; }
    .cc-to { background: #f1f5f9; border-radius: .5rem; padding: .5rem .75rem; overflow-wrap: anywhere; }
    .cc-original summary { cursor: pointer; color: #475569; font-size: .9rem; }
    @media (max-width: 575.98px) {
        .cc-actions .btn { padding: .45rem .7rem; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    // ---- View full message ----
    var viewModal = new bootstrap.Modal(document.getElementById('ccViewModal'));
    document.querySelectorAll('[data-cc-view]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('ccViewTitle').textContent = 'Message from ' + btn.dataset.name;
            document.getElementById('ccViewAddr').textContent = btn.dataset.address;
            document.getElementById('ccViewBody').textContent = btn.dataset.message;
            viewModal.show();
        });
    });

    // ---- Reply (Email / WhatsApp) ----
    var modalEl  = document.getElementById('ccReplyModal');
    var modal    = new bootstrap.Modal(modalEl);
    var form     = document.getElementById('ccReplyForm');
    var textarea = document.getElementById('ccMessage');
    var count    = document.getElementById('ccCount');
    var sendBtn  = form.querySelector('[data-cc-send]');
    var current  = null;

    function updateCount() { count.textContent = textarea.value.length + ' / 5000'; }
    textarea.addEventListener('input', updateCount);

    document.querySelectorAll('[data-cc-reply]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            current = btn.dataset;
            var isWa = current.ccReply === 'whatsapp';

            modalEl.querySelector('[data-cc-title]').textContent = isWa ? 'Send WhatsApp message' : 'Send email';
            // Font Awesome swaps <i> for <svg>, so replace the wrapper's contents instead of editing classes
            modalEl.querySelector('[data-cc-icon]').innerHTML = isWa ? '<i class="fab fa-whatsapp text-success"></i>' : '<i class="fas fa-envelope text-primary"></i>';
            modalEl.querySelector('[data-cc-to]').textContent = current.name + ' — ' + (isWa ? '+' + current.wa : current.email);
            modalEl.querySelector('[data-cc-subject-wrap]').classList.toggle('d-none', isWa);
            document.getElementById('ccSubject').required = !isWa;
            modalEl.querySelector('[data-cc-hint]').textContent = isWa
                ? 'WhatsApp opens with this message. Press send in WhatsApp.'
                : 'The email is sent from the website mail account.';
            modalEl.querySelector('[data-cc-original]').textContent = current.message;
            sendBtn.className = 'btn ' + (isWa ? 'btn-wa' : 'btn-primary');
            sendBtn.disabled = false;
            sendBtn.querySelector('[data-cc-send-text]').textContent = isWa ? 'Open WhatsApp' : 'Send email';
            sendBtn.querySelector('[data-cc-send-icon]').innerHTML = isWa ? '<i class="fab fa-whatsapp"></i>' : '<i class="fas fa-paper-plane"></i>';
            form.action = current.emailUrl;
            textarea.value = current.template;
            updateCount();
            modal.show();
        });
    });
    modalEl.addEventListener('shown.bs.modal', function () { textarea.focus(); textarea.setSelectionRange(0, 0); });

    form.addEventListener('submit', function (e) {
        if (!current) return;
        if (!textarea.value.trim()) { e.preventDefault(); textarea.focus(); return; }

        if (current.ccReply === 'whatsapp') {
            e.preventDefault();
            // Open WhatsApp (app on phone, WhatsApp Web on computer) with the message filled in
            window.open('https://wa.me/' + current.wa + '?text=' + encodeURIComponent(textarea.value.trim()), '_blank', 'noopener');
            // Record the reply, then refresh so the status badge updates
            fetch(current.waUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
                .finally(function () { modal.hide(); window.location.reload(); });
            return;
        }

        // Email: normal form POST to the server
        sendBtn.disabled = true;
        sendBtn.querySelector('[data-cc-send-text]').textContent = 'Sending…';
    });
});
</script>
@endpush
