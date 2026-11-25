{{-- resources/views/admin/adminlayout/sidebar.blade.php --}}
<nav class="sb-sidenav accordion na-sidebar" id="sidenavAccordion">

    {{-- Brand --}}
    <a class="na-brand" href="{{ url('admin/dashboard') }}">
        @include('admin.adminlayout.logo', ['size' => 46])
        <span>Neerodai<br>Admin</span>
    </a>

    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table-cells-large"></i></div>
                Dashboard
            </a>

            @php $pagesOpen = request()->is('admin/gallery*') || request()->is('admin/videos*') || request()->is('admin/blog*'); @endphp
            <a class="nav-link {{ $pagesOpen ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse"
               data-bs-target="#collapseLayouts" aria-expanded="{{ $pagesOpen ? 'true' : 'false' }}" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
            </a>
            <div class="collapse {{ $pagesOpen ? 'show' : '' }}" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->is('admin/gallery*') ? 'active' : '' }}" href="{{ url('admin/gallery') }}">Gallery</a>
                    <a class="nav-link {{ request()->is('admin/videos*') ? 'active' : '' }}" href="{{ url('admin/videos') }}">Videos</a>
                    <a class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}" href="{{ url('admin/blog') }}">Blog</a>
                </nav>
            </div>

            <a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ url('admin/payments') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                Payments
            </a>

            <a class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}" href="{{ url('admin/customers') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Customers
            </a>
        </div>

        {{-- Logged-in user --}}
        
    </div>

    {{-- Bottom illustration --}}
    <div class="na-side-art">
        <svg width="96" height="84" viewBox="0 0 96 84" fill="none" aria-hidden="true">
            <path d="M48 42c-1.6-1.4-17-11.5-17-23A9.6 9.6 0 0 1 48 13a9.6 9.6 0 0 1 17 6c0 11.5-15.4 21.6-17 23z" fill="#5b7cfa"/>
            <path d="M8 28c4 13 9 27 19 36 6 5 12 7 17 7V53c0-4-3-8-7-10l-9-6" stroke="#4aa3ff" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M88 28c-4 13-9 27-19 36-6 5-12 7-17 7V53c0-4 3-8 7-10l9-6" stroke="#4aa3ff" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p>Together<br>for a Better<br>Tomorrow</p>
    </div>
</nav>