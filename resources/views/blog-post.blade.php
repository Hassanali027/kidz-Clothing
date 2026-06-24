@include('partials.header')

<style>
/* ── Blog Post Page ── */
.bp-page {
    background: #f5f5f5;
    min-height: calc(100vh - 120px);
    padding: 36px 60px 80px;
}

/* ── Article & Sidebar ── */
.bp-top-part {
    margin-bottom: 25px;
}
.bp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #000;
    margin-bottom: 20px;
}
.bp-breadcrumb a { color: #000; text-decoration: none; }
.bp-breadcrumb a:hover { color: #f06292; }
.bp-breadcrumb span { color: #000; }

.bp-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 36px;
    max-width: 1100px;
    margin: 40px auto;
    align-items: flex-start;
}
.bp-content-col {
    background: #fff;
    border-radius: 6px;
    padding: 40px 44px 48px;
}

/* Title */
.bp-title {
    font-size: 26px;
    font-weight: 800;
    color: #111;
    line-height: 1.35;
    margin-bottom: 12px;
}

/* Meta row */
.bp-meta {
    display: flex;
    align-items: center;
    gap: 18px;
    font-size: 13px;
    color: #000;
    margin-bottom: 28px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f0;
    flex-wrap: wrap;
}
.bp-meta-author {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #000;
    font-weight: 500;
}
.bp-meta-author svg { color: #f06292; }
.bp-meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
}
.bp-meta-dot { color: #ddd; }

/* Article content typography */
.bp-content {
    font-size: 14.5px;
    color: #000;
    line-height: 1.85;
}
.bp-content p { margin-bottom: 18px; }
.bp-content h2 {
    font-size: 20px;
    font-weight: 800;
    color: #000;
    margin: 34px 0 12px;
}
.bp-content h3 {
    font-size: 17px;
    font-weight: 700;
    color: #000;
    margin: 26px 0 10px;
}
.bp-content ul, .bp-content ol {
    padding-left: 22px;
    margin-bottom: 18px;
}
.bp-content li { margin-bottom: 7px; }

/* Inline image */
.bp-content .bp-inline-img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    object-position: center top;
    border-radius: 6px;
    display: block;
    margin: 24px 0;
}

/* Hero banner — below meta, above content */
.bp-hero-banner {
    width: 100%;
    height: 340px;
    object-fit: cover;
    object-position: center top;
    border-radius: 8px;
    display: block;
    margin-bottom: 28px;
}

/* Share row */
.bp-share {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 32px;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
}
.bp-share-label {
    font-size: 13px;
    font-weight: 600;
    color: #000;
}
.bp-share-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    background: #d9d9d9;
    color: #000;
    transition: transform 0.2s, background 0.2s;
}
.bp-share-btn:hover { 
    transform: scale(1.1); 
    background: #ccc;
}

/* ── Sidebar ── */
.bp-sidebar { display: flex; flex-direction: column; gap: 24px; }

.bp-widget {
    background: #fff;
    border-radius: 6px;
    padding: 22px 20px;
}
.bp-widget-title {
    font-size: 14px;
    font-weight: 800;
    color: #000;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

/* Table of Contents */
.bp-toc-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.bp-toc-list li a {
    display: block;
    font-size: 13px;
    color: #000;
    text-decoration: none;
    padding: 8px 0;
    border-bottom: 1px solid #f7f7f7;
    transition: color 0.2s;
    line-height: 1.4;
}
.bp-toc-list li a:hover { color: #f06292; }
.bp-toc-list li:last-child a { border-bottom: none; }
.bp-toc-show-all {
    display: inline-block;
    margin-top: 10px;
    font-size: 12px;
    color: #29b6f6;
    text-decoration: none;
}
.bp-toc-show-all:hover { text-decoration: underline; }

/* Popular Blogs */
.bp-popular-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.bp-popular-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #f7f7f7;
    text-decoration: none;
}
.bp-popular-item:last-child { border-bottom: none; }
.bp-popular-img {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    object-fit: cover;
    object-position: center top;
    flex-shrink: 0;
}
.bp-popular-info { flex: 1; }
.bp-popular-title {
    font-size: 12.5px;
    font-weight: 600;
    color: #000;
    line-height: 1.4;
    margin-bottom: 4px;
    transition: color 0.2s;
}
.bp-popular-item:hover .bp-popular-title { color: #f06292; }
.bp-popular-date {
    font-size: 11.5px;
    color: #aaa;
}

/* Author Section */
.bp-author-sec {
    display: flex;
    align-items: center;
    gap: 30px;
    margin-top: 60px;
    padding-top: 40px;
}
.bp-author-img {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.bp-author-info {
    flex: 1;
}
.bp-author-name {
    font-size: 24px;
    font-weight: 800;
    color: #000;
    margin-bottom: 10px;
}
.bp-author-bio {
    font-size: 14.5px;
    color: #000;
    line-height: 1.6;
    margin: 0;
}

/* Related Posts Section */
.bp-related-sec {
    max-width: 1100px;
    margin: 60px auto 0;
    padding: 0;
}
.bp-related-head {
    font-size: 24px;
    font-weight: 800;
    color: #000;
    margin-bottom: 30px;
}
.bp-related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}
.bp-rel-card {
    text-decoration: none;
    display: block;
}
.bp-rel-img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 15px;
}
.bp-rel-title {
    font-size: 16px;
    font-weight: 800;
    color: #000;
    line-height: 1.4;
    margin-bottom: 10px;
}
.bp-rel-desc {
    font-size: 13.5px;
    color: #000;
    line-height: 1.6;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.bp-rel-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #000;
}
.bp-rel-author {
    color: #29b6f6;
    font-weight: 500;
}
.bp-rel-sep {
    color: #ddd;
}
/* Responsive */
@media (max-width: 1000px) {
    .bp-layout { grid-template-columns: 1fr; gap: 40px; }
    .bp-related-grid { grid-template-columns: repeat(2, 1fr); }
    .bp-page { padding: 24px 30px 60px; }
}

@media (max-width: 768px) {
    .bp-page { padding: 20px 16px 50px; }
    .bp-content-col { padding: 24px 20px 32px; }
    .bp-hero-banner { height: 260px; }
    .bp-author-sec { flex-direction: column; text-align: center; gap: 20px; margin-top: 40px; padding-top: 30px; }
    .bp-author-img { width: 100px; height: 100px; }
    .bp-related-grid { grid-template-columns: 1fr; gap: 24px; }
    .bp-title { font-size: 22px; }
    .bp-author-name { font-size: 20px; }
    .bp-related-head { font-size: 20px; margin-bottom: 20px; }
}

@media (max-width: 480px) {
    .bp-meta { gap: 10px; }
    .bp-meta-dot { display: none; }
    .bp-meta-item, .bp-meta-author { width: 100%; margin-bottom: 4px; }
    .bp-hero-banner { height: 200px; }
    .bp-content .bp-inline-img { height: 220px; }
    .bp-share { flex-wrap: wrap; justify-content: center; }
}

/* Mobile TOC toggle */
.bp-mobile-toc { display: none; margin: 20px 0; }
.bp-toc-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 12px 20px;
    background: #fff;
    border: 1.5px solid #e0e0e0;
    border-radius: 30px;
    font-family: 'Outfit', sans-serif;
    font-size: 14.5px;
    font-weight: 600;
    color: #222;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.bp-toc-toggle:hover { border-color: #bbb; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
.bp-toc-toggle svg { flex-shrink: 0; color: #555; }
.bp-toc-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.25s ease;
    background: #fff;
   
    border-top: none;
    border-radius: 0 0 14px 14px;
    padding: 0 20px;
}
.bp-toc-collapse.bp-toc-open {
    max-height: 400px;
    padding: 10px 20px 16px;
}

/* Floating Sticky TOC (mobile only) */
.bp-sticky-toc {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 900;
    padding: 10px 16px;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(6px);
    box-shadow: 0 -2px 16px rgba(0,0,0,0.10);
    transform: translateY(100%);
    transition: transform 0.3s ease;
}
.bp-sticky-toc.bp-sticky-toc--visible {
    transform: translateY(0);
}
.bp-sticky-toc-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 12px 20px;
    background: #fff;
    border: 1.5px solid #e0e0e0;
    border-radius: 30px;
    font-family: 'Outfit', sans-serif;
    font-size: 14.5px;
    font-weight: 600;
    color: #222;
    cursor: pointer;
    transition: border-color 0.2s;
}
.bp-sticky-toc-btn:hover { border-color: #bbb; }
.bp-sticky-toc-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.25s ease;
    background: #fff;
    padding: 0 20px;
}
.bp-sticky-toc-collapse.bp-stoc-open {
    max-height: 300px;
    padding: 10px 20px 16px;
}
@media (max-width: 1000px) {
    .bp-mobile-toc { display: block; }
    .bp-sidebar-toc { display: none; }
    .bp-sticky-toc { display: block; }
}
</style>

<!-- ════════════════════════════════
     Blog Post Detail Page
════════════════════════════════ -->
<div class="bp-page">
    
    <div class="bp-layout">

        <!-- ── Content Column ── -->
        <div class="bp-content-col">
            
            <!-- Top Part (Moved inside to match width) -->
            <div class="bp-top-part">
                <!-- Breadcrumb -->
                <nav class="bp-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Home
                    </a>
                    <span>›</span>
                    <a href="{{ route('blog') }}">Blog</a>
                    <span>›</span>
                    <span>{{ $blog->title }}</span>
                </nav>

                <!-- Title -->
                <h1 class="bp-title">{{ $blog->title }}</h1>
                <p style="font-size:14.5px; color:#000; margin-bottom:15px; line-height:1.6;">In March, Vogue published an article titled "Do Seoul's Toddlers Have the World's Most Stylish Hair?" that featured nine street style photographs of the three-feet.</p>

                <!-- Meta -->
                <div class="bp-meta">
                    <div class="bp-meta-author">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ $blog->author }}
                    </div>
                    <span class="bp-meta-dot">•</span>
                    <div class="bp-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $blog->created_at->format('M d, Y') }}
                    </div>
                    <span class="bp-meta-dot">•</span>
                    <div class="bp-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        4 min read
                    </div>
                </div>

                <!-- Hero Image -->
                <img class="bp-hero-banner"
                     src="{{ asset('images/img-home/baby-wear.jpg') }}"
                     alt="Fashion for Kids">

                <!-- Mobile Table of Contents -->
                <div class="bp-mobile-toc" id="bp-mobile-toc">
                    <button class="bp-toc-toggle" id="bp-toc-toggle">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        Table of contents
                    </button>
                    <div class="bp-toc-collapse" id="bp-toc-collapse">
                        <ul class="bp-toc-list">
                            <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                            <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                            <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="bp-content">
                {!! $blog->description !!}
            </div>

            <!-- Share -->
            <div class="bp-share" id="bp-share-section">
                <span class="bp-share-label">Share</span>
                <a href="#" class="bp-share-btn" aria-label="Facebook">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" class="bp-share-btn" aria-label="Twitter">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
                </a>
                <a href="#" class="bp-share-btn" aria-label="Instagram">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
                <a href="#" class="bp-share-btn" aria-label="YouTube">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2C5.12 19.5 12 19.5 12 19.5s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 2.9 2.9 0 0 0-.46-5.33zM9.75 15.02V8.48L15.5 11.75l-5.75 3.27z"/></svg>
                </a>
            </div>

            <!-- Author Section -->
            <div class="bp-author-sec">
                <img class="bp-author-img" src="{{ asset('images/img-about/casual-children-dress.jpg') }}" alt="Sarah Khan">
                <div class="bp-author-info">
                    <h3 class="bp-author-name">Sarah Khan</h3>
                    <p class="bp-author-bio">Written by Sarah Khan, a kids fashion enthusiast passionate about creating comfortable and stylish looks for little ones. She shares simple parenting and style inspiration to help families dress kids with confidence and comfort.</p>
                </div>
            </div>
        </div>

        <!-- ── Sidebar ── -->
        <aside class="bp-sidebar">

            <!-- Table of Contents -->
            <div class="bp-widget bp-sidebar-toc">
                <h3 class="bp-widget-title">Table of Contents</h3>
                <ul class="bp-toc-list">
                    <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                    <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                    <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                </ul>
                <a href="#" class="bp-toc-show-all">Show all contents</a>
            </div>

            <!-- Popular Blogs -->
            <div class="bp-widget">
                <h3 class="bp-widget-title">Popular Blogs</h3>
                <div class="bp-popular-list">
                    <a href="{{ route('blog.post', 'fashion-for-kids') }}" class="bp-popular-item">
                        <img class="bp-popular-img" src="{{ asset('images/img-home/baby-wear.jpg') }}" alt="Post">
                        <div class="bp-popular-info">
                            <p class="bp-popular-title">Fashion for Kids: How Soon Is Too Soon?</p>
                            <span class="bp-popular-date">Feb 25, 2026</span>
                        </div>
                    </a>
                    <a href="{{ route('blog.post', 'casual-outfit-guide') }}" class="bp-popular-item">
                        <img class="bp-popular-img" src="{{ asset('images/img-about/casual-children-dress.jpg') }}" alt="Post">
                        <div class="bp-popular-info">
                            <p class="bp-popular-title">Fashion for Kids: How Soon Is Too Soon?</p>
                            <span class="bp-popular-date">Feb 25, 2026</span>
                        </div>
                    </a>
                    <a href="{{ route('blog.post', 'dress-for-every-occasion') }}" class="bp-popular-item">
                        <img class="bp-popular-img" src="{{ asset('images/img-about/fancy-children-dress.jpg') }}" alt="Post">
                        <div class="bp-popular-info">
                            <p class="bp-popular-title">Fashion for Kids: How Soon Is Too Soon?</p>
                            <span class="bp-popular-date">Feb 25, 2026</span>
                        </div>
                    </a>
                    <a href="{{ route('blog.post', 'party-wear-guide') }}" class="bp-popular-item">
                        <img class="bp-popular-img" src="{{ asset('images/img-home/partywear.jpg') }}" alt="Post">
                        <div class="bp-popular-info">
                            <p class="bp-popular-title">Fashion for Kids: How Soon Is Too Soon?</p>
                            <span class="bp-popular-date">Feb 25, 2026</span>
                        </div>
                    </a>
                </div>
            </div>

        </aside>

    </div>

    <!-- Related Posts Section -->
    <section class="bp-related-sec">
        <h2 class="bp-related-head">Related Posts</h2>
        <div class="bp-related-grid">
            
            <!-- Related 1 -->
            <a href="{{ route('blog.post', 'fashion-for-kids-how-soon-is-too-soon') }}" class="bp-rel-card">
                <img src="{{ asset('images/img-home/baby-wear.jpg') }}" alt="Related" class="bp-rel-img">
                <h3 class="bp-rel-title">Fashion for Kids: How Soon Is Too Soon?</h3>
                <p class="bp-rel-desc">In March, Vogue published an article titled "Do Seoul's Toddlers Have the World's Most Stylish Hair?" that featured nine street style photographs of the three-feet.</p>
                <div class="bp-rel-footer">
                    <span class="bp-rel-author">Admin</span>
                    <span class="bp-rel-sep">|</span>
                    <span class="bp-rel-date">Feb 25, 2026</span>
                </div>
            </a>

            <!-- Related 2 -->
            <a href="{{ route('blog.post', 'casual-outfit-guide') }}" class="bp-rel-card">
                <img src="{{ asset('images/img-about/casual-children-dress.jpg') }}" alt="Related" class="bp-rel-img">
                <h3 class="bp-rel-title">Fashion for Kids: How Soon Is Too Soon?</h3>
                <p class="bp-rel-desc">In March, Vogue published an article titled "Do Seoul's Toddlers Have the World's Most Stylish Hair?" that featured nine street style photographs of the three-feet.</p>
                <div class="bp-rel-footer">
                    <span class="bp-rel-author">Admin</span>
                    <span class="bp-rel-sep">|</span>
                    <span class="bp-rel-date">Feb 25, 2026</span>
                </div>
            </a>

            <!-- Related 3 -->
            <a href="{{ route('blog.post', 'dress-for-every-occasion') }}" class="bp-rel-card">
                <img src="{{ asset('images/img-about/fancy-children-dress.jpg') }}" alt="Related" class="bp-rel-img">
                <h3 class="bp-rel-title">Fashion for Kids: How Soon Is Too Soon?</h3>
                <p class="bp-rel-desc">In March, Vogue published an article titled "Do Seoul's Toddlers Have the World's Most Stylish Hair?" that featured nine street style photographs of the three-feet.</p>
                <div class="bp-rel-footer">
                    <span class="bp-rel-author">Admin</span>
                    <span class="bp-rel-sep">|</span>
                    <span class="bp-rel-date">Feb 25, 2026</span>
                </div>
            </a>

        </div>
    </section>

    <!-- Floating Sticky TOC (Mobile) -->
    <div class="bp-sticky-toc" id="bp-sticky-toc">
        <button class="bp-sticky-toc-btn" id="bp-sticky-toc-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            Table of contents
        </button>
        <div class="bp-sticky-toc-collapse" id="bp-sticky-toc-collapse">
            <ul class="bp-toc-list">
                <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                <li><a href="#">Beginner's Guide Blog Post Template</a></li>
                <li><a href="#">Beginner's Guide Blog Post Template</a></li>
            </ul>
        </div>
    </div>

</div>

<script>
    // ── Inline Mobile TOC Toggle ──
    var tocToggle = document.getElementById('bp-toc-toggle');
    var tocCollapse = document.getElementById('bp-toc-collapse');
    if (tocToggle && tocCollapse) {
        tocToggle.addEventListener('click', function () {
            var isOpen = tocCollapse.classList.contains('bp-toc-open');
            tocCollapse.classList.toggle('bp-toc-open', !isOpen);
            tocToggle.style.borderRadius = isOpen ? '30px' : '14px 14px 0 0';
        });
    }

    // ── Sticky TOC Toggle ──
    var stickyToc     = document.getElementById('bp-sticky-toc');
    var stickyBtn     = document.getElementById('bp-sticky-toc-btn');
    var stickyCollapse = document.getElementById('bp-sticky-toc-collapse');
    if (stickyBtn && stickyCollapse) {
        stickyBtn.addEventListener('click', function () {
            var isOpen = stickyCollapse.classList.contains('bp-stoc-open');
            stickyCollapse.classList.toggle('bp-stoc-open', !isOpen);
            stickyBtn.style.borderRadius = isOpen ? '30px' : '14px 14px 0 0';
        });
    }

    // ── Show sticky TOC after scrolling past inline TOC, hide at share section ──
    if (stickyToc) {
        var inlineToc  = document.getElementById('bp-mobile-toc');
        var shareSection = document.getElementById('bp-share-section');

        // Show when inline TOC scrolls out of view
        if (inlineToc) {
            var tocObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) {
                        stickyToc.classList.add('bp-sticky-toc--visible');
                    } else {
                        stickyToc.classList.remove('bp-sticky-toc--visible');
                        // Also close the collapse when hiding
                        if (stickyCollapse) stickyCollapse.classList.remove('bp-stoc-open');
                        if (stickyBtn) stickyBtn.style.borderRadius = '30px';
                    }
                });
            }, { threshold: 0.1 });
            tocObserver.observe(inlineToc);
        }

        // Hide when share section comes into view
        if (shareSection) {
            var shareObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        stickyToc.classList.remove('bp-sticky-toc--visible');
                        if (stickyCollapse) stickyCollapse.classList.remove('bp-stoc-open');
                        if (stickyBtn) stickyBtn.style.borderRadius = '30px';
                    }
                });
            }, { threshold: 0.2 });
            shareObserver.observe(shareSection);
        }
    }
</script>

@include('partials.footer')
