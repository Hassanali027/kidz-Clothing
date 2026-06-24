    <!-- ════════════════════════════════
         Footer
    ════════════════════════════════ -->
    <footer class="ftr-footer">
        <div class="ftr-top">

            <!-- Col 1: Brand -->
            <div class="ftr-brand">
                <a href="/" class="ftr-logo-link">
                    <img src="{{ asset('images/img-home/logo.png') }}" alt="Kidz Wear Logo" class="ftr-logo">
                </a>
                <p class="ftr-brand-desc">We have clothes that suits your style and which you're proud to wear. From girl to boy.</p>
                <div class="ftr-social">
                    @php
                        $socialTwitter = \App\Models\SiteSetting::get('social_twitter', '#');
                        $socialFacebook = \App\Models\SiteSetting::get('social_facebook', '#');
                        $socialInstagram = \App\Models\SiteSetting::get('social_instagram', '#');
                        $socialTiktok = \App\Models\SiteSetting::get('social_tiktok', '#');
                    @endphp
                    <a href="{{ $socialTwitter }}" class="ftr-social-link" id="ftr-twitter" title="Twitter" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                    </a>
                    <a href="{{ $socialFacebook }}" class="ftr-social-link" id="ftr-facebook" title="Facebook" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="{{ $socialInstagram }}" class="ftr-social-link" id="ftr-instagram" title="Instagram" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="{{ $socialTiktok }}" class="ftr-social-link" id="ftr-tiktok" title="TikTok" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 448 512" fill="currentColor"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
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
                    <li><a href="/contact-us">Store Address</a></li>
                    <li><a href="/contact-us">Email Address</a></li>
                    <li><a href="/contact-us">Contact Number</a></li>
                    <li><a href="/contact-us">Store Timings</a></li>
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
            <p class="ftr-copy">Kids Wear &copy; 2026, All Rights Reserved</p>
            <!-- <div class="ftr-payments">
                <img src="{{ asset('images/img-home/payments.png') }}" alt="Payment Methods" class="ftr-pay-img">
            </div> -->
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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/923034280347" target="_blank" class="whatsapp-float" aria-label="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="#ffffff">
            <path d="M12.031 0C5.405 0 .025 5.378.025 12.005c0 2.115.551 4.181 1.599 6.002L.031 24l6.155-1.614c1.745.955 3.708 1.458 5.845 1.458 6.626 0 12.006-5.378 12.006-12.005S18.657 0 12.031 0zm0 21.84c-1.788 0-3.539-.481-5.074-1.39l-.364-.216-3.771.99.999-3.678-.237-.376A9.972 9.972 0 0 1 2.03 12.005c0-5.513 4.485-9.997 10.001-9.997s10.001 4.484 10.001 9.997-4.485 9.997-10.001 9.997zM17.525 14.51c-.301-.151-1.785-.882-2.062-.982-.276-.1-.478-.151-.678.151-.201.301-.779.982-.955 1.182-.176.201-.352.226-.653.075-.301-.151-1.274-.47-2.428-1.5-.898-.802-1.503-1.792-1.679-2.093-.176-.301-.019-.464.132-.614.135-.135.301-.351.452-.527.151-.176.201-.301.301-.502.101-.201.05-.376-.025-.527-.075-.151-.678-1.631-.93-2.234-.244-.585-.494-.506-.678-.515-.176-.009-.377-.009-.578-.009-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.481 1.079 2.912 1.23 3.112.151.201 2.122 3.238 5.14 4.54 1.554.67 2.124.717 2.812.602.639-.107 1.785-.729 2.036-1.433.251-.703.251-1.305.176-1.433-.075-.126-.276-.201-.577-.352z"/>
        </svg>
    </a>
    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            left: 30px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            box-shadow: 2px 2px 15px rgba(0,0,0,0.25);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            background-color: #1ebe57;
        }
        
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                left: 20px;
            }
            .whatsapp-float svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>

</body>
</html>
