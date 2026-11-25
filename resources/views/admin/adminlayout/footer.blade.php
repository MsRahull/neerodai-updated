{{-- resources/views/admin/adminlayout/footer.blade.php --}}
<footer class="na-footer mt-auto">
    <div class="container-fluid px-3 px-md-4">
        <div class="na-footer-inner">
            <div class="na-footer-brand">
                @include('admin.adminlayout.logo', ['size' => 36])
                <div>
                    <strong>Neerodai Trust</strong>
                    <div class="na-footer-copy">&copy; {{ date('Y') }} All rights reserved.</div>
                </div>
            </div>

            <nav class="na-footer-links" aria-label="Footer">
                <a href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fas fa-arrow-up-right-from-square"></i> View website</a>
                <a href="{{ url('/privacy') }}" target="_blank" rel="noopener">Privacy Policy</a>
                <a href="{{ url('/terms') }}" target="_blank" rel="noopener">Terms &amp; Conditions</a>
            </nav>

            <div class="na-footer-social">
                <a href="https://www.youtube.com/@NithiyamTv" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="https://wa.me/918110079041" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="mailto:neerodaitrust@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </div>
</footer>
