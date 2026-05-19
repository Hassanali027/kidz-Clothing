    <!-- ════════════════════════════════
         Footer
    ════════════════════════════════ -->
    <footer class="ftr-footer">
        <div class="ftr-top">

            <!-- Col 1: Brand -->
            <div class="ftr-brand">
                <a href="/" class="ftr-logo-link">
                    <img src="{{ asset('images/img-home/logo.svg') }}" alt="Kidz Wear Logo" class="ftr-logo">
                </a>
                <p class="ftr-brand-desc">We have clothes that suits your style and which you're proud to wear. From girl to boy.</p>
                <div class="ftr-social">
                    <a href="#" class="ftr-social-link" id="ftr-twitter" title="Twitter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                    </a>
                    <a href="#" class="ftr-social-link" id="ftr-facebook" title="Facebook">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="ftr-social-link" id="ftr-instagram" title="Instagram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="ftr-social-link" id="ftr-github" title="GitHub">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Company -->
            <div class="ftr-col">
                <h4 class="ftr-col-heading">Company</h4>
                <ul class="ftr-links">
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('exchange.policy') }}">Exchange Policy</a></li>
                    <li><a href="{{ route('refund.policy') }}">Refund Policy</a></li>
                    <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('faqs') }}">FAQS</a></li>
                </ul>
            </div>

            <!-- Col 3: Get in Touch -->
            <div class="ftr-col">
                <h4 class="ftr-col-heading">Get in Touch</h4>
                <ul class="ftr-links">
                    <li><a href="#">Store Address</a></li>
                    <li><a href="#">Email Address</a></li>
                    <li><a href="#">Contact Number</a></li>
                    <li><a href="#">Store Timmings</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter -->
            <div class="ftr-col ftr-newsletter">
                <h4 class="ftr-col-heading">Stay in the Loop</h4>
                <p class="ftr-nl-desc">Sign up for 10% off your first order &amp; updates on new arrivals.</p>
                <div class="ftr-nl-form">
                    <input type="email" class="ftr-nl-input" id="ftr-email-input" placeholder="Enter your email">
                    <button class="ftr-nl-btn" id="ftr-subscribe-btn">Subscribe</button>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="ftr-bottom">
            <p class="ftr-copy">Kidz Wear &copy; 2026, All Rights Reserved</p>
            <div class="ftr-payments">
                <img src="{{ asset('images/img-home/payments.png') }}" alt="Payment Methods" class="ftr-pay-img">
            </div>
        </div>

    </footer>

    <!-- Mobile Drawer Script -->
    <script>
        (function () {
            var drawer    = document.getElementById('mob-drawer');
            var overlay   = document.getElementById('mob-overlay');
            var hamburger = document.querySelector('.hamburger');
            var closeBtn  = document.getElementById('mob-close');

            function openDrawer() {
                drawer.classList.add('mob-open');
                overlay.classList.add('mob-open');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                drawer.classList.remove('mob-open');
                overlay.classList.remove('mob-open');
                document.body.style.overflow = '';
            }

            if (hamburger) hamburger.addEventListener('click', openDrawer);
            if (closeBtn)  closeBtn.addEventListener('click', closeDrawer);
            if (overlay)   overlay.addEventListener('click', closeDrawer);

            // Expandable submenus
            document.querySelectorAll('.mob-toggle').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var subId = btn.id.replace('-toggle', '-sub');
                    var sub   = document.getElementById(subId);
                    if (!sub) return;
                    var isOpen = sub.classList.contains('mob-sub-open');
                    document.querySelectorAll('.mob-submenu').forEach(function(s) { s.classList.remove('mob-sub-open'); });
                    document.querySelectorAll('.mob-toggle').forEach(function(b) { b.classList.remove('mob-sub-open'); });
                    if (!isOpen) {
                        sub.classList.add('mob-sub-open');
                        btn.classList.add('mob-sub-open');
                    }
                });
            });
        })();
    </script>

</body>
</html>
