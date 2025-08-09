<footer class="site-footer py-4">
    <div class="custom-container">
        <div class="row align-items-center g-0">
            <!-- Logo Section -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="footer-logo">
                    <a href="{{ url('/') }}" class="text-decoration-none">
                        <img src="{{ asset('assets/images/logo/logo-site.png') }}" alt="CheapLaosTrain" height="50">
                    </a>

                </div>
            </div>

            <!-- Social and Attribution Section -->
            <div class="col-md-6 text-md-end">
                @if (count($socialLinks) > 0)
                    <div class="social-links mb-3">
                        @foreach ($socialLinks as $social)
                            <a href="{{ $social->url }}" class="social-icon me-2"
                                aria-label="{{ __('social.aria_label', ['name' => $social->name]) }}" target="_blank"
                                rel="noopener">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="social-links mb-3">
                        <a href="#" class="social-icon me-2" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon me-2" aria-label="Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="social-icon me-2" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-icon me-2" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                @endif

            </div>
        </div>

        <div class="copyright text-center text-muted fs-7 py-3">

        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
@stack('scripts')

<script>
    // Initialize all popovers
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    });
</script>
</body>

</html>
