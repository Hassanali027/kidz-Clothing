@include('partials.header')

<style>
/* ── Contact Us Page (cu-) ── */
.cu-page { background:#f5f5f5; min-height:calc(100vh - 120px); padding:36px 40px 0; }
.cu-breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:#666; margin-bottom:36px; }
.cu-breadcrumb a { color:#444; text-decoration:none; display:flex; align-items:center; gap:4px; transition:color 0.2s; }
.cu-breadcrumb a:hover { color:#f06292; }
.cu-breadcrumb span { color:#888; }
.cu-layout { display:grid; grid-template-columns:1fr 1.5fr; gap:40px; max-width:960px; margin:0 auto; align-items:start; }
.cu-info-title { font-size:28px; font-weight:800; color:#111; margin-bottom:32px; }
.cu-info-item { display:flex; align-items:flex-start; gap:16px; margin-bottom:28px; }
.cu-info-icon { flex-shrink:0; width:48px; height:48px; border-radius:50%; background:#f06292; display:flex; align-items:center; justify-content:center; color:#fff; }
.cu-info-text h3 { font-size:15px; font-weight:700; color:#111; margin-bottom:4px; }
.cu-info-text p { font-size:13.5px; color:#000; line-height:1.7; }
.cu-form-card { background:#fff; border-radius:12px; padding:36px 32px; box-shadow:0 2px 16px rgba(0,0,0,0.07); }
.cu-form-title { font-size:20px; font-weight:700; color:#111; margin-bottom:24px; }
.cu-field { display:flex; flex-direction:column; gap:6px; margin-bottom:18px; }
.cu-field label { font-size:14px; font-weight:600; color:#222; }
.cu-field input,.cu-field textarea { padding:10px 14px; border:1.5px solid #d0d0d0; border-radius:6px; font-family:'Outfit',sans-serif; font-size:14px; color:#222; outline:none; background:#fff; transition:border-color 0.2s,box-shadow 0.2s; resize:none; }
.cu-field input:focus,.cu-field textarea:focus { border-color:#29b6f6; box-shadow:0 0 0 3px rgba(41,182,246,0.12); }
.cu-submit-btn { display:block; width:100%; padding:13px; background:#29b6f6; color:#fff; font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; border:none; border-radius:6px; cursor:pointer; transition:background 0.2s,transform 0.15s; margin-top:6px; }
.cu-submit-btn:hover { background:#0288d1; transform:translateY(-1px); }
.cu-feedback { margin-top:14px; padding:12px 16px; border-radius:8px; font-size:14px; font-weight:500; }
.cu-feedback--success { background:#e6f7f1; color:#2e7d5e; border:1px solid #b2dfdb; }
.cu-map-section { width:100%; margin:36px 0 0; height:480px; border-radius:0; overflow:hidden; border-top:1px solid #ddd; border-bottom:1px solid #ddd; box-shadow:0 4px 20px rgba(0,0,0,0.10); }
.cu-map-section iframe { width:100%; height:100%; display:block; }
@media (max-width:768px) {
    .cu-page { padding:24px 18px 60px; }
    .cu-layout { grid-template-columns:1fr; gap:28px; }
    .cu-form-card { padding:24px 18px; }
    .cu-info-title { font-size:22px; margin-bottom:22px; }
    .cu-map-section { height:280px; margin-top:20px; }
}
</style>


    <!-- ════════════════════════════════
         Contact Us Page
    ════════════════════════════════ -->
    <div class="cu-page">

        <!-- Breadcrumb -->
        <nav class="cu-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </a>
            <span>›</span>
            <span>Contact Us</span>
        </nav>

        <!-- Two-column layout -->
        <div class="cu-layout">

            <!-- LEFT: Info -->
            <div class="cu-info">
                <h1 class="cu-info-title">Contact Us</h1>

                <!-- Email -->
                <div class="cu-info-item">
                    <div class="cu-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div class="cu-info-text">
                        <h3>Email Us</h3>
                        <p>hello@kidzwear.pk</p>
                        <p>support@kidzwear.pk</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="cu-info-item">
                    <div class="cu-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.59 3.47 2 2 0 0 1 3.56 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 5.55 5.55l.9-.9a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
                    </div>
                    <div class="cu-info-text">
                        <h3>Contact</h3>
                        <p>+92 300 1234567</p>
                        <p>+92 321 7654321</p>
                    </div>
                </div>

                <!-- Store -->
                <div class="cu-info-item">
                    <div class="cu-info-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="cu-info-text">
                        <h3>Store</h3>
                        <p>Monday to Friday: 9am – 6pm</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form Card -->
            <div class="cu-form-card">
                <h2 class="cu-form-title">Send A Message</h2>

                <form class="cu-form" id="cu-contact-form" novalidate>
                    @csrf

                    <div class="cu-field">
                        <label for="cu-name">Name</label>
                        <input type="text" id="cu-name" name="name" placeholder="" required>
                    </div>

                    <div class="cu-field">
                        <label for="cu-email">Email</label>
                        <input type="email" id="cu-email" name="email" placeholder="" required>
                    </div>

                    <div class="cu-field">
                        <label for="cu-message">Message</label>
                        <textarea id="cu-message" name="message" rows="6" placeholder="" required></textarea>
                    </div>

                    <button type="submit" class="cu-submit-btn" id="cu-submit-btn">Submit</button>

                    <div class="cu-feedback" id="cu-feedback" style="display:none;"></div>
                </form>
            </div>

        </div><!-- /.cu-layout -->

        <!-- ── Google Map ── -->
        <div class="cu-map-section">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3321.6!2d73.1166!3d33.6007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfed5b70e4b4b1%3A0x5b5c5e5c5e5c5e5c!2sSohan%2C%20Islamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1715517600000!5m2!1sen!2s"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Kidz Wear Store Location — Islamabad">
            </iframe>
        </div>

    </div><!-- /.cu-page -->

    <script>
        document.getElementById('cu-contact-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const fb = document.getElementById('cu-feedback');
            fb.style.display = 'block';
            fb.className = 'cu-feedback cu-feedback--success';
            fb.textContent = '✅ Thank you! Your message has been sent. We\'ll get back to you soon.';
            this.reset();
            setTimeout(() => { fb.style.display = 'none'; }, 5000);
        });
    </script>

@include('partials.footer')
