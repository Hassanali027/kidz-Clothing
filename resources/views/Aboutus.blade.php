@include('partials.header')

<style>
/* ── About Us Page (au-) ── */
.aboutus-container { width:100%; overflow-x:hidden; }
.au-banner { position:relative; width:100vw; height:460px; overflow:hidden; margin:0; padding:0; left:0; }
.au-banner img { width:100%; height:100%; object-fit:cover; object-position:center center; display:block; }
.au-banner-overlay { position:absolute; top:0; left:0; right:0; bottom:0; background:linear-gradient(to bottom,rgba(0,0,0,0.25) 0%,transparent 50%); display:flex; align-items:flex-start; padding:18px 28px; }
.au-breadcrumb { display:flex; align-items:center; gap:8px; font-size:14px; color:#fff; }
.au-breadcrumb a { display:flex; align-items:center; gap:5px; color:#fff; text-decoration:none; opacity:0.9; transition:opacity 0.2s; }
.au-breadcrumb a:hover { opacity:1; }
.au-breadcrumb span { opacity:0.85; }
.au-page { max-width:1100px; margin:0 auto; padding:0 24px 80px; }
.au-section { padding:60px 0; border-bottom:1px solid #f0f0f0; }
.au-section-inner { display:flex; gap:70px; align-items:center; }
.au-text { flex:1; }
.au-story-label { font-size:13px; font-weight:600; color:#888; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:14px; }
.au-story-heading { font-size:30px; font-weight:800; color:#111; line-height:1.3; margin-bottom:22px; }
.au-story-body { font-size:14.5px; color:#222; line-height:1.85; text-align:justify; }
.au-section-title { font-size:26px; font-weight:700; color:#111; margin-bottom:18px; }
.au-centered { text-align:center; margin-bottom:32px; }
.au-image-box { flex:0 0 420px; border-radius:16px; overflow:hidden; }
.au-image-box img { width:100%; height:420px; object-fit:cover; display:block; }
.au-img-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding:40px 0; border-bottom:1px solid #f0f0f0; }
.au-img-card { border-radius:14px; overflow:hidden; position:relative; cursor:pointer; }
.au-img-card img { width:100%; height:200px; object-fit:cover; display:block; transition:transform 0.35s ease; }
.au-img-card:hover img { transform:scale(1.06); }
.au-img-card span { position:absolute; bottom:0; left:0; right:0; padding:10px 12px; background:linear-gradient(transparent,rgba(0,0,0,0.55)); color:#fff; font-size:13.5px; font-weight:600; letter-spacing:0.2px; }
.au-values { padding:50px 0; border-bottom:1px solid #f0f0f0; }
.au-values-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; }
.au-value-card { background:#faf9f7; border-radius:14px; padding:28px 20px; text-align:center; border:1px solid #f0f0f0; transition:box-shadow 0.2s,transform 0.2s; }
.au-value-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.08); transform:translateY(-3px); }
.au-value-icon { font-size:32px; margin-bottom:14px; }
.au-value-card h3 { font-size:15px; font-weight:700; color:#111; margin-bottom:10px; }
.au-value-card p { font-size:13.5px; color:#666; line-height:1.6; }
.au-cta { text-align:center; padding:60px 20px; background:linear-gradient(135deg,#fce4ec 0%,#e3f2fd 100%); border-radius:20px; margin-top:40px; }
.au-cta h2 { font-size:28px; font-weight:800; color:#111; margin-bottom:10px; }
.au-cta p { font-size:15px; color:#555; margin-bottom:24px; }
.au-cta-btn { display:inline-block; padding:13px 36px; background:#f06292; color:#fff; font-size:15px; font-weight:600; border-radius:30px; text-decoration:none; transition:background 0.2s,transform 0.2s; }
.au-cta-btn:hover { background:#e91e63; transform:scale(1.04); }
/* Gallery */
.au-gallery { padding:60px 0 50px; border-bottom:1px solid #f0f0f0; }
.au-gallery-header { text-align:center; margin-bottom:36px; }
.au-gallery-label { font-size:13px; font-weight:600; color:#f06292; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:8px; }
.au-gallery-title { font-size:26px; font-weight:800; color:#111; line-height:1.3; }
.au-gallery-row { display:flex; align-items:flex-end; gap:20px; justify-content:center; }
.au-gallery-item { position:relative; overflow:hidden; border-radius:14px; cursor:pointer; flex:0 0 auto; box-shadow:0 8px 28px rgba(0,0,0,0.10); transition:transform 0.35s ease,box-shadow 0.35s ease; }
.au-gallery-item:hover { transform:translateY(-6px); box-shadow:0 18px 48px rgba(0,0,0,0.16); }
.au-gallery-item--left { width:220px; height:290px; }
.au-gallery-item--center { width:260px; height:350px; z-index:2; border:3px solid #fff; box-shadow:0 12px 40px rgba(0,0,0,0.15); }
.au-gallery-item--right { width:220px; height:290px; }
.au-gallery-item img { width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.45s ease; }
.au-gallery-item:hover img { transform:scale(1.07); }
.au-gallery-tag { position:absolute; bottom:16px; left:50%; transform:translateX(-50%); background:rgba(255,255,255,0.92); backdrop-filter:blur(6px); color:#111; font-size:12px; font-weight:700; padding:6px 16px; border-radius:20px; white-space:nowrap; letter-spacing:0.3px; box-shadow:0 2px 8px rgba(0,0,0,0.12); transition:background 0.2s; }
.au-gallery-item:hover .au-gallery-tag { background:rgba(240,98,146,0.92); color:#fff; }
/* Why Parents */
.au-why { padding:60px 0; border-bottom:1px solid #f0f0f0; text-align:center; }
.au-why-title { font-size:26px; font-weight:800; color:#111; margin-bottom:44px; }
.au-why-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:24px; }
.au-why-card { display:flex; flex-direction:column; align-items:center; text-align:center; padding:10px 16px; }
.au-why-icon { width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
.au-why-icon--blue { background:#e8f4fd; color:#5aacdc; }
.au-why-icon--green { background:#e6f7f1; color:#3eb87d; }
.au-why-icon--pink { background:#fce8ef; color:#e9708a; }
.au-why-icon--purple { background:#f0ecfb; color:#9b7ee8; }
.au-why-name { font-size:15px; font-weight:700; color:#111; margin-bottom:8px; }
.au-why-desc { font-size:13.5px; color:#666; line-height:1.6; max-width:160px; margin:0 auto; }
/* Responsive */
@media (max-width:900px) { .au-img-row { grid-template-columns:repeat(2,1fr); } .au-values-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:768px) { .au-section-inner { flex-direction:column; } .au-image-box { flex:none; width:100%; } .au-banner { height:220px; } .au-banner img { height:100%; object-position: right center; } .au-banner-overlay { padding: 30px 20px; } .au-why-grid { grid-template-columns:repeat(2,1fr); } .au-gallery-row { gap:10px; } .au-gallery-item--left,.au-gallery-item--right { width:28vw; height:220px; } .au-gallery-item--center { width:36vw; height:280px; } .au-gallery-title { font-size:20px; } }
@media (max-width:480px) { .au-img-row { grid-template-columns:1fr 1fr; } .au-values-grid { grid-template-columns:1fr; } .au-gallery-row { flex-direction:column; align-items:center; gap:14px; } .au-gallery-item--left,.au-gallery-item--center,.au-gallery-item--right { width:90%; height:220px; } .au-gallery-item--center { height:240px; } }
</style>


    <!-- Full-Width Hero Banner — container سے باہر -->
    <div class="au-banner">
        <img src="{{ asset('images/img-about/about-hero.jpg') }}" alt="Kids Collection Banner">
        <div class="au-banner-overlay">
            <nav class="au-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Home
                </a>
                <span>›</span>
                <span>About Us</span>
            </nav>
        </div>
    </div>

    <!-- ════════════════════════════════
         About Us Page — Main Container
    ════════════════════════════════ -->
    <div class="aboutus-container">

        <!-- Inner Content -->
        <div class="au-page">

            <!-- Our Story -->
            <section class="au-section">
                <div class="au-section-inner">
                    <div class="au-image-box">
                        <img src="{{ asset('images/img-about/trendy-designed-dress-for-kids.jpg') }}" alt="Kids wearing Kidz Wear clothing">
                    </div>
                    <div class="au-text">
                        <p class="au-story-label">Our Story</p>
                        <h2 class="au-story-heading">Thoughtfully made for little ones</h2>
                        <p class="au-story-body">We create playful and comfortable fashion for kids who love to explore, laugh, and shine every single day. Our designs are inspired by the joy, curiosity, and energy of childhood, making sure every outfit supports their little adventures whether they are running, playing, learning, or simply enjoying their world. Our goal is to bring parents trendy, modern styles combined with soft, high-quality fabrics that kids not only look great in but also genuinely enjoy wearing all day long, ensuring comfort, durability, and freedom in every moment.</p>
                    </div>
                </div>
            </section>

            <!-- Designed for Every Little Moment -->
            <section class="au-section">
                <div class="au-section-inner">
                    <div class="au-text">
                        <h2 class="au-story-heading">Designed for Every Little Moment</h2>
                        <p class="au-story-body">From playtime adventures to special family moments, our collections are thoughtfully designed to keep kids comfortable, confident, and full of joy wherever they go. We believe children should feel free to move, explore, laugh, and express themselves without ever compromising on comfort or style. That's why every piece is created using soft, high-quality fabrics, playful designs, and carefully crafted details that support everyday fun while making every little moment feel extra special for both kids and parents.</p>
                    </div>
                    <div class="au-image-box">
                        <img src="{{ asset('images/img-about/dresses-with-comfort.jpg') }}" alt="Designed for every little moment">
                    </div>
                </div>
            </section>



            <!-- Why Parents Love Us -->
            <section class="au-why">
                <h2 class="au-why-title">Why Parents Love Us</h2>
                <div class="au-why-grid">
                    <div class="au-why-card">
                        <div class="au-why-icon au-why-icon--blue">
                            <!-- Cloud / Soft icon -->
                           <img src="{{asset('images/img-about/cloud.svg')}}" alt="Cloud">
                        </div>
                        <h3 class="au-why-name">Soft &amp; Safe</h3>
                        <p class="au-why-desc">Gentle fabric that are perfect for delicate skin</p>
                    </div>
                    <div class="au-why-card">
                        <div class="au-why-icon au-why-icon--green">
                            <!-- Quality / Medal icon -->
                           <img src="{{asset('images/img-about/quality.svg')}}" alt="Quality">
                        </div>
                        <h3 class="au-why-name">Premium Quality</h3>
                        <p class="au-why-desc">Durable stitching and ong lasting comfort</p>
                    </div>
                    <div class="au-why-card">
                        <div class="au-why-icon au-why-icon--pink">
                            <!-- Heart icon -->
                           <img src="{{asset('images/img-about/heart.svg')}}" alt="Heart">
                        </div>
                        <h3 class="au-why-name">Made with Love</h3>
                        <p class="au-why-desc">Thoughtfully designed for little smiles</p>
                    </div>
                    <div class="au-why-card">
                        <div class="au-why-icon au-why-icon--purple">
                            <!-- Trusted / Shield icon -->
                            <img src="{{asset('images/img-about/trust-by-parents.svg')}}" alt="Shield">
                        </div>
                        <h3 class="au-why-name">Trusted by Parents</h3>
                        <p class="au-why-desc">Loved by thousands of happy families</p>
                    </div>
                </div>
            </section>
            
            <!-- ── Collection Highlights Photo Row ── -->
            <section class="au-gallery">
                <div class="au-gallery-header">
                    <p class="au-gallery-label">Our Collection</p>
                    <h2 class="au-gallery-title">Styles Kids Love, Quality Parents Trust</h2>
                </div>
                <div class="au-gallery-row">
                    <div class="au-gallery-item au-gallery-item--left">
                        <img src="{{ asset('images/img-about/clothes-for-babies.jpg') }}" alt="Clothes for babies">
                        <div class="au-gallery-tag">Newborn &amp; Baby</div>
                    </div>
                    <div class="au-gallery-item au-gallery-item--center">
                        <img src="{{ asset('images/img-about/casual-children-dress.jpg') }}" alt="Casual children dress">
                        <div class="au-gallery-tag">Casual Collection</div>
                    </div>
                    <div class="au-gallery-item au-gallery-item--right">
                        <img src="{{ asset('images/img-about/fancy-children-dress.jpg') }}" alt="Fancy children dress">
                        <div class="au-gallery-tag">Fancy &amp; Festive</div>
                    </div>
                </div>
            </section>

        

        </div><!-- /.au-page -->

    </div><!-- /.aboutus-container -->

@include('partials.footer')
