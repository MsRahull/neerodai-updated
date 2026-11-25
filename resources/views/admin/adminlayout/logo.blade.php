{{-- Neerodai logo mark: two hands holding a heart. Usage: @include('admin.adminlayout.logo', ['size' => 44]) --}}
<svg class="na-logo-mark" width="{{ $size ?? 44 }}" height="{{ $size ?? 44 }}" viewBox="0 0 64 64" fill="none" aria-hidden="true">
    <defs>
        <linearGradient id="naHandL" x1="6" y1="20" x2="30" y2="58" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#2ec5d3"/><stop offset="1" stop-color="#1e88e5"/>
        </linearGradient>
        <linearGradient id="naHandR" x1="58" y1="20" x2="34" y2="58" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#7ed957"/><stop offset="1" stop-color="#22b573"/>
        </linearGradient>
    </defs>
    <path d="M32 33c-1-.9-11-7.6-11-15.2A6.3 6.3 0 0 1 32 14a6.3 6.3 0 0 1 11 3.8C43 25.4 33 32.1 32 33z" stroke="#f9b233" stroke-width="3.2" stroke-linejoin="round"/>
    <path d="M7 22c3 9 6 19 13 25 4 3.5 8 5 11 5V40c0-3-2-5.5-5-7l-6-4" stroke="url(#naHandL)" stroke-width="4.2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M57 22c-3 9-6 19-13 25-4 3.5-8 5-11 5V40c0-3 2-5.5 5-7l6-4" stroke="url(#naHandR)" stroke-width="4.2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>