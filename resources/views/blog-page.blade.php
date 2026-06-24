@include('partials.header')

<style>
/* ── Blog Page (bl-) ── */
.bl-page {
    background: #f7f7f5;
    min-height: calc(100vh - 120px);
    padding: 36px 40px 80px;
}
.bl-breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:#666; margin-bottom:28px; }
.bl-breadcrumb a { color:#444; text-decoration:none; display:flex; align-items:center; gap:4px; transition:color 0.2s; }
.bl-breadcrumb a:hover { color:#f06292; }
.bl-breadcrumb span { color:#888; }
.bl-header { text-align:center; margin-bottom:40px; }
.bl-main-title { font-size:36px; font-weight:800; color:#111; margin-bottom:8px; }
.bl-main-sub { font-size:15px; color:#000; }

/* Featured */
.bl-featured {
    display:grid; grid-template-columns:58% 42%; gap:0;
    background:#fff; border-radius:4px; overflow:hidden;
    max-width:1242px; margin:0 auto 56px;
    transition:box-shadow 0.3s;
}
.bl-featured:hover { box-shadow:0 6px 28px rgba(41,182,246,0.18); }
.bl-featured-img { position:relative; overflow:hidden; height:460px; }
.bl-featured-img img { width:100%; height:100%; object-fit:cover; object-position:center 15%; display:block; transition:transform 0.5s ease; }
.bl-featured:hover .bl-featured-img img { transform:scale(1.05); }
.bl-badge { position:absolute; top:16px; left:16px; background:#f06292; color:#fff; font-size:11px; font-weight:700; padding:5px 12px; border-radius:20px; letter-spacing:0.5px; text-transform:uppercase; }
.bl-featured-body { padding:40px 36px; display:flex; flex-direction:column; justify-content:center; gap:14px; }
.bl-cat-tag { display:inline-block; font-size:11px; font-weight:700; color:#f06292; text-transform:uppercase; letter-spacing:1px; background:#fce8ef; padding:4px 12px; border-radius:20px; width:fit-content; }
.bl-featured-title { font-size:22px; font-weight:800; color:#000; line-height:1.35; }
.bl-featured-desc { font-size:14px; color:#222; line-height:1.75; }
.bl-featured-meta { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; margin-top:4px; }
.bl-author { color:#f06292; font-weight:600; text-decoration:none; }
.bl-author:hover { text-decoration:underline; }
.bl-meta-sep { color:#bbb; }
.bl-meta-date { color:#888; }

/* Section heading */
.bl-section-head { display:flex; align-items:center; gap:16px; margin-bottom:28px; }
.bl-section-title { font-size:20px; font-weight:800; color:#111; white-space:nowrap; }
.bl-section-line { flex:1; height:1.5px; background:#e0e0e0; }

/* Cards Grid */
.bl-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; margin-bottom:48px; padding:0 60px; }
.bl-card { border-radius:14px; overflow:hidden; transition:box-shadow 0.25s, transform 0.25s; cursor:pointer; }
.bl-card-img { position:relative; height:240px; overflow:hidden; }
.bl-card-img img { width:100%; height:100%; object-fit:cover; object-position:center 20%; display:block; transition:transform 0.4s ease; }
.bl-card:hover .bl-card-img img { transform:scale(1.06); }
.bl-card-body { padding:18px 20px 22px; display:flex; flex-direction:column; gap:10px; }
.bl-card-title { font-size:15px; font-weight:700; color:#000; line-height:1.45; }
.bl-card-desc { font-size:13px; color:#444; line-height:1.65; }
.bl-card-meta { display:flex; align-items:center; gap:8px; font-size:13px; color:#888; margin-top:4px; }
.bl-card-author { color:#29b6f6; font-weight:600; text-decoration:none; }
.bl-card-author:hover { text-decoration:underline; }
.bl-card-sep { color:#ccc; }
.bl-card-date { color:#888; }

/* Pagination */
.bl-pagination { display:flex; align-items:center; justify-content:center; gap:8px; padding:24px 0 48px; }

/* Responsive */
@media (max-width:900px) {
    .bl-featured { grid-template-columns:1fr; }
    .bl-featured-img { min-height:240px; }
    .bl-grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:768px) {
    .bl-page { padding:24px 18px 60px; }
    .bl-main-title { font-size:26px; }
    .bl-featured-body { padding:24px 20px; }
    .bl-featured-title { font-size:18px; }
}
@media (max-width:480px) {
    .bl-grid { grid-template-columns:1fr; padding: 0; }
    
}
</style>


    <!-- ════════════════════════════════
         Blog Page
    ════════════════════════════════ -->
    <div class="bl-page">

        <!-- Breadcrumb -->
        <nav class="bl-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </a>
            <span>›</span>
            <span>Blog</span>
        </nav>

        <!-- Page Header -->
        <div class="bl-header">
            <h1 class="bl-main-title">Our Blog</h1>
            <p class="bl-main-sub">Tips, trends &amp; stories for modern parents</p>
        </div>

        @php
            $featured = $blogs->first();
            $others = $blogs->skip(1);
        @endphp

        @if($featured)
        <!-- Featured Post -->
        <a href="{{ route('blog.post', $featured->slug) }}" class="bl-featured" style="text-decoration:none;">
            <div class="bl-featured-img">
                @if($featured->thumbnail)
                    <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="{{ $featured->title }}">
                @else
                    <img src="{{ asset('images/img-about/trendy-designed-dress-for-kids.jpg') }}" alt="{{ $featured->title }}">
                @endif
            </div>
            <div class="bl-featured-body">
                <h2 class="bl-featured-title">{{ $featured->title }}</h2>
                <p class="bl-featured-desc">{{ Str::limit(strip_tags($featured->description), 200) }}</p>
                <div class="bl-featured-meta">
                    <span class="bl-author">{{ $featured->author }}</span>
                    <span class="bl-meta-sep">|</span>
                    <span class="bl-meta-date">{{ $featured->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </a>
        @endif

        <div class="bl-grid">
            @forelse($others as $blog)
            <!-- Card -->
            <a href="{{ route('blog.post', $blog->slug) }}" class="bl-card" style="text-decoration:none;display:block;">
                <div class="bl-card-img">
                    @if($blog->thumbnail)
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}">
                    @else
                        <img src="{{ asset('images/img-about/casual-children-dress.jpg') }}" alt="{{ $blog->title }}">
                    @endif
                </div>
                <div class="bl-card-body">
                    <h3 class="bl-card-title">{{ $blog->title }}</h3>
                    <p class="bl-card-desc">{{ Str::limit(strip_tags($blog->description), 100) }}</p>
                    <div class="bl-card-meta">
                        <span class="bl-card-author">{{ $blog->author }}</span>
                        <span class="bl-card-sep">|</span>
                        <span class="bl-card-date">{{ $blog->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </a>
            @empty
                @if(!$featured)
                    <div style="grid-column: 1 / -1; text-align: center; padding: 100px; color: #999;">
                        <h2>No blog posts found.</h2>
                    </div>
                @endif
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 50px; display: flex; justify-content: center;">
            {{ $blogs->links() }}
        </div>

    </div><!-- /.bl-page -->

@include('partials.footer')
