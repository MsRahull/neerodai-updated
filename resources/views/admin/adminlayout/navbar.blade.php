{{-- resources/views/admin/adminlayout/navbar.blade.php --}}
<nav class="sb-topnav navbar navbar-expand na-topbar">
    <button class="na-icon-btn" id="sidebarToggle" type="button" aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
    </button>

    <div class="na-navbar-title">
        <strong>Admin For Neerodai</strong>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">

        {{-- Notifications: contact messages not replied to yet --}}
        @php $pendingContacts = \App\Models\Contact::whereNull('replied_at')->count(); @endphp
        <a href="{{ route('contacts.index', ['status' => 'pending']) }}" class="na-icon-btn na-bell"
           title="{{ $pendingContacts }} message(s) waiting for reply"
           aria-label="{{ $pendingContacts }} contact message(s) waiting for reply">
            <i class="far fa-bell"></i>
            @if($pendingContacts > 0)
                <span class="na-bell-badge">{{ $pendingContacts > 99 ? '99+' : $pendingContacts }}</span>
            @endif
        </a>

        <form method="POST" action="{{ url('admin/logout') }}" class="m-0">
            @csrf
            <button type="submit" class="na-logout">
                <i class="fas fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>
