@include('partials.header')

<style>
/* ── Category Page (cp-) ── */
.cp-page-wrapper { max-width:1280px; width:100%; margin:0 auto; overflow:hidden; box-sizing:border-box; }
.cp-breadcrumb { display:flex; align-items:center; gap:6px; font-size:12.5px; padding:14px 24px 0; color:#888; }
.cp-breadcrumb a { display:flex; align-items:center; gap:4px; color:#888; text-decoration:none; transition:color 0.2s; }
.cp-breadcrumb a:hover { color:#333; }
.cp-bc-sep { color:#bbb; font-size:14px; }
.cp-bc-current { color:#333; font-weight:500; }
.cp-page-title { text-align:center; font-size:26px; font-weight:700; color:#111; padding:14px 24px 0; letter-spacing:0.2px; }
.cp-toolbar { display:flex; align-items:center; justify-content:space-between; padding:14px 24px 10px; margin-bottom:6px; }
.cp-filter-toggle-btn { display:flex; align-items:center; gap:8px; background:#faf9f7; border:1.5px solid #e0e0e0; border-radius:10px; font-family:'Outfit',sans-serif; font-size:14px; font-weight:500; color:#222; cursor:pointer; padding:9px 16px; transition:border-color 0.2s,box-shadow 0.2s,background 0.2s; letter-spacing:0.1px; }
.cp-filter-toggle-btn:hover { border-color:#bbb; background:#f5f4f1; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
/* Sort dropdown */
.cp-sort-wrap { display:flex; align-items:center; gap:6px; position:relative; }
.cp-sort-btn { display:flex; align-items:center; gap:6px; padding:8px 14px; border:1.5px solid #ddd; border-radius:8px; background:#fff; font-family:'Outfit',sans-serif; font-size:14px; font-weight:500; color:#222; cursor:pointer; transition:border-color 0.2s,box-shadow 0.2s; white-space:nowrap; }
.cp-sort-btn:hover { border-color:#bbb; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.cp-sort-btn svg { transition:transform 0.22s; color:#555; }
.cp-sort-btn.cp-sort-open svg { transform:rotate(180deg); }
.cp-sort-menu { display:none; position:absolute; top:calc(100% + 6px); right:0; min-width:200px; background:#fff; border-radius:10px; box-shadow:0 8px 28px rgba(0,0,0,0.13); list-style:none; padding:6px 0; z-index:500; border:1px solid #f0f0f0; }
.cp-sort-menu.cp-sort-menu--open { display:block; }
.cp-sort-item { padding:10px 18px; font-size:14px; color:#222; cursor:pointer; transition:background 0.15s; }
.cp-sort-item:hover { background:#f7f7f7; }
.cp-sort-item--active { font-weight:600; color:#111; }
/* Active filters */
.cp-active-filters { display:flex; align-items:center; flex-wrap:wrap; gap:8px; padding:10px 24px 12px; border-bottom:1px solid #ebebeb; }
.cp-af-tags { display:flex; flex-wrap:wrap; gap:8px; }
.cp-af-tag { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border:1.5px solid #f06292; border-radius:8px; font-size:13px; font-family:'Outfit',sans-serif; color:#222; background:#fff; white-space:nowrap; }
.cp-af-tag-x { background:none; border:none; cursor:pointer; color:#888; font-size:14px; line-height:1; padding:0; display:flex; align-items:center; transition:color 0.15s; }
.cp-af-tag-x:hover { color:#f06292; }
.cp-af-remove-all { background:none; border:none; font-family:'Outfit',sans-serif; font-size:13px; color:#555; cursor:pointer; text-decoration:underline; text-underline-offset:3px; white-space:nowrap; transition:color 0.2s; padding:0; }
.cp-af-remove-all:hover { color:#f06292; }
/* Filter Drawer (cpd-) */
.cpd-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.38); z-index:1100; backdrop-filter:blur(1px); }
.cpd-overlay--show { display:block; }
.cpd-drawer { position:fixed; top:0; left:-340px; width:300px; height:100dvh; background:#fff; z-index:1200; display:flex; flex-direction:column; box-shadow:4px 0 28px rgba(0,0,0,0.14); transition:left 0.32s cubic-bezier(0.4,0,0.2,1); }
.cpd-drawer--open { left:0; }
.cpd-header { display:flex; align-items:center; justify-content:space-between; padding:18px 20px 16px; border-bottom:1.5px solid #f0f0f0; flex-shrink:0; }
.cpd-title { font-size:16px; font-weight:700; color:#111; letter-spacing:0.2px; }
.cpd-close { width:30px; height:30px; border:none; background:none; font-size:18px; color:#444; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:50%; transition:background 0.2s,color 0.2s; line-height:1; }
.cpd-close:hover { background:#f5f5f5; color:#111; }
.cpd-body { overflow-y:auto; flex:1; padding-bottom:24px; }
.cpd-section { border-bottom:1px solid #f0f0f0; }
.cpd-acc-btn { width:100%; display:flex; align-items:center; justify-content:space-between; padding:15px 20px; background:none; border:none; font-family:'Outfit',sans-serif; font-size:14.5px; font-weight:600; color:#111; cursor:pointer; text-align:left; transition:color 0.2s; }
.cpd-chevron { color:#666; flex-shrink:0; transition:transform 0.28s ease; }
.cpd-acc-panel { display:none; padding:4px 20px 18px; }
.cpd-acc-panel.cpd-acc-open { display:block; }
.cpd-cb-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px 8px; }
.cpd-cb-item { display:flex; align-items:center; gap:8px; cursor:pointer; }
.cpd-cb { width:15px; height:15px; accent-color:#f06292; cursor:pointer; flex-shrink:0; margin:0; }
.cpd-cb-label { font-size:13px; color:#111; line-height:1.3; }
.cpd-cb-label em { font-style:normal; color:#888; font-size:12px; }
/* Price range slider */
.cpd-dual-slider { position:relative; height:36px; margin:8px 0 20px; }
.cpd-dual-slider::before { content:''; position:absolute; top:50%; left:0; right:0; height:3px; background:#e0e0e0; border-radius:4px; transform:translateY(-50%); z-index:0; }
.cpd-slider-track { position:absolute; top:50%; height:3px; background:#111; border-radius:4px; transform:translateY(-50%); z-index:1; pointer-events:none; }
.cpd-range-input { -webkit-appearance:none; appearance:none; position:absolute; width:100%; height:20px; background:transparent; border-radius:4px; outline:none; pointer-events:auto; top:50%; transform:translateY(-50%); z-index:2; margin:0; }
.cpd-range-input::-webkit-slider-thumb { -webkit-appearance:none; width:18px; height:18px; border-radius:50%; background:#fff; border:2px solid #111; box-shadow:0 0 0 2px #fff,0 0 0 4px #111; cursor:pointer; pointer-events:all; }
.cpd-range-input::-moz-range-thumb { width:18px; height:18px; border-radius:50%; background:#fff; border:2px solid #111; cursor:pointer; pointer-events:all; }
.cpd-price-row { display:flex; align-items:center; gap:10px; margin-top:4px; }
.cpd-price-box { display:flex; align-items:center; gap:6px; border:1.5px solid #ddd; border-radius:8px; padding:6px 10px; flex:1; background:#fff; transition:border-color 0.2s; }
.cpd-price-box:focus-within { border-color:#aaa; }
.cpd-rs-label { font-size:13px; color:#888; font-weight:500; flex-shrink:0; }
.cpd-price-input { width:100%; border:none; outline:none; font-size:14px; font-family:'Outfit',sans-serif; font-weight:600; color:#111; background:transparent; min-width:0; }
.cpd-price-input::-webkit-outer-spin-button,.cpd-price-input::-webkit-inner-spin-button { -webkit-appearance:none; }
.cpd-price-input[type=number] { -moz-appearance:textfield; }
.cpd-price-dash { color:#bbb; font-size:16px; flex-shrink:0; }
.cpd-avail-wrap { display:flex; gap:10px; flex-wrap:wrap; }
.cpd-avail-btn { flex:1; padding:8px 6px; border:1.5px solid #ddd; border-radius:8px; font-family:'Outfit',sans-serif; font-size:13px; color:#111; background:#fff; cursor:pointer; transition:border-color 0.2s,background 0.2s,color 0.2s; text-align:center; white-space:nowrap; }
.cpd-avail-btn em { font-style:normal; color:#888; }
.cpd-avail-btn:hover { border-color:#f06292; color:#f06292; }
.cpd-avail-btn--active { border-color:#111; background:#111; color:#fff !important; }
.cpd-avail-btn--active em { color:#ccc !important; }
/* Grid */
.cp-grid-wrap { padding:16px 24px 60px; }
.cp-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; }
.cp-card { display:block; text-decoration:none; background:#fff; transition:opacity 0.2s; padding-bottom:20px; }
.cp-card:hover { opacity:0.88; }
.cp-card-img { position:relative; background:#f0f0f0; overflow:hidden; aspect-ratio:3/4; }
.cp-card-img img { width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.45s ease; }
.cp-card:hover .cp-card-img img { transform:scale(1.04); }
.cp-badge-new { position:absolute; top:18px; left:-24px; width:90px; background:#f06292; color:#fff; font-size:11px; font-weight:700; text-align:center; padding:5px 0; transform:rotate(-45deg); z-index:2; letter-spacing:0.5px; }
.cp-badge-stock { position:absolute; left:10px; bottom:10px; background:rgba(17,17,17,0.9); color:#fff; font-size:11px; font-weight:700; padding:6px 9px; border-radius:6px; z-index:2; letter-spacing:0.2px; }
.cp-card-info { padding:10px 4px 0; }
.cp-card-name { font-size:13.5px; font-weight:500; color:#111; margin-bottom:5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.cp-card-price { display:flex; align-items:center; gap:8px; }
.cp-old { font-size:12.5px; color:#aaa; text-decoration:line-through; }
.cp-new { font-size:13.5px; font-weight:700; color:#111; }
/* Pagination */
.cp-pagination { display:flex; justify-content:center; gap:8px; margin-top:40px; margin-bottom: 60px; }
.cp-page-btn { padding:8px 16px; border:1.5px solid #ddd; border-radius:6px; background:#fff; font-family:'Outfit',sans-serif; font-size:14px; color:#555; cursor:pointer; transition:border-color 0.2s,background 0.2s,color 0.2s; }
.cp-page-btn:hover { border-color:#f06292; color:#f06292; }
.cp-page-btn--active { background:#f06292; border-color:#f06292; color:#fff; font-weight:700; }
.cp-page-next { padding:8px 20px; }
/* Responsive */
@media (max-width:900px) { .cp-grid { grid-template-columns:repeat(3,1fr); } }
@media (max-width:600px) { .cp-grid { grid-template-columns:repeat(2,1fr); gap:16px; } .cp-grid-wrap { padding:14px 16px 40px; } .cp-toolbar { padding:12px 16px 10px; } .cp-page-title { font-size:20px; padding:12px 16px 0; } .cp-breadcrumb { padding:12px 16px 0; } .cp-card-info { padding:10px 8px 0; } .cp-card { border-radius: 12px; overflow: hidden; border: 1px solid #f0f0f0; box-shadow: 0 2px 10px rgba(0,0,0,0.04); } }
</style>


    <!-- ════════════════════════════════
         Category Page
    ════════════════════════════════ -->
    <div class="cp-page-wrapper">

    <!-- Breadcrumb -->
    <nav class="cp-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Home
        </a>
        <span class="cp-bc-sep">›</span>
        <a href="{{ route('categories.index') }}">Categories</a>
        @isset($categorySlug)
            <span class="cp-bc-sep">›</span>
            <span class="cp-bc-current">{{ $categoryName ?? ucfirst(str_replace('-', ' ', $categorySlug)) }}</span>
        @endisset
    </nav>

    <!-- Page Title -->
    <h1 class="cp-page-title">
        @isset($categorySlug)
            {{ $categoryName ?? ucfirst(str_replace('-', ' ', $categorySlug)) }}
        @else
            All Categories
        @endisset
    </h1>

    <!-- Toolbar -->
    <div class="cp-toolbar">
        <button class="cp-filter-toggle-btn" id="cp-filter-toggle-btn">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" y1="6" x2="20" y2="6"/>
                <line x1="4" y1="12" x2="20" y2="12"/>
                <line x1="4" y1="18" x2="20" y2="18"/>
                <circle cx="9" cy="6" r="2" fill="currentColor" stroke="none"/>
                <circle cx="15" cy="12" r="2" fill="currentColor" stroke="none"/>
                <circle cx="9" cy="18" r="2" fill="currentColor" stroke="none"/>
            </svg>
            Filters
        </button>
        <!-- Custom Sort Dropdown -->
        <div class="cp-sort-wrap" id="cp-sort-wrap">
            <button class="cp-sort-btn" id="cp-sort-btn">
                Sort
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <ul class="cp-sort-menu" id="cp-sort-menu">
                <li class="cp-sort-item cp-sort-item--active" data-value="featured">Featured</li>
                <li class="cp-sort-item" data-value="best-selling">Best selling</li>
                <li class="cp-sort-item" data-value="alpha-asc">Alphabetically, A-Z</li>
                <li class="cp-sort-item" data-value="alpha-desc">Alphabetically, Z-A</li>
                <li class="cp-sort-item" data-value="price-asc">Price, low to high</li>
                <li class="cp-sort-item" data-value="price-desc">Price, high to low</li>
                <li class="cp-sort-item" data-value="date-old">Date, old to new</li>
                <li class="cp-sort-item" data-value="date-new">Date, new to old</li>
            </ul>
        </div>
    </div>

    <!-- Active Filters Bar -->
    <div class="cp-active-filters" id="cp-active-filters" style="display:none;">
        <div class="cp-af-tags" id="cp-af-tags"></div>
        <button class="cp-af-remove-all" id="cp-af-remove-all">Remove all</button>
    </div>

    <!-- ══════════════════════════════════════════
         Filter Side Drawer (Left Side)
    ══════════════════════════════════════════ -->

    <!-- Overlay -->
    <div class="cpd-overlay" id="cpd-overlay"></div>

    <!-- Drawer -->
    <div class="cpd-drawer" id="cpd-drawer">

        <!-- Header -->
        <div class="cpd-header">
            <span class="cpd-title">Filters</span>
            <button class="cpd-close" id="cpd-close" aria-label="Close filters">&#x2715;</button>
        </div>

        <!-- Scrollable Body -->
        <div class="cpd-body">

            <!-- ── Size ── -->
            <div class="cpd-section">
                <button class="cpd-acc-btn" id="cpd-acc-size">
                    <span>Size</span>
                    <svg class="cpd-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                 <div class="cpd-acc-panel" id="cpd-panel-size">
                    <div class="cpd-cb-grid">
                        @forelse(($ageGroups ?? collect()) as $ageGroup)
                            <label class="cpd-cb-item"><input type="checkbox" class="cpd-cb" {{ (isset($activeSize) && strtolower($activeSize) === strtolower($ageGroup)) ? 'checked' : '' }}><span class="cpd-cb-label">{{ $ageGroup }}</span></label>
                        @empty
                            <span class="cpd-cb-label">No sizes available</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ── Product Type ── -->
            <div class="cpd-section">
                <button class="cpd-acc-btn" id="cpd-acc-type">
                    <span>Product Type</span>
                    <svg class="cpd-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="cpd-acc-panel" id="cpd-panel-type">
                    <div class="cpd-cb-grid">
                        @forelse(($productTypes ?? collect()) as $productType)
                            <label class="cpd-cb-item">
                                <input type="checkbox" class="cpd-cb" value="{{ strtolower($productType) }}" {{ isset($activeProductType) && strtolower($activeProductType) == strtolower($productType) ? 'checked' : '' }}>
                                <span class="cpd-cb-label">{{ $productType }}</span>
                            </label>
                        @empty
                            <span class="cpd-cb-label">No product types yet</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ── Price ── -->
            <div class="cpd-section">
                <button class="cpd-acc-btn" id="cpd-acc-price">
                    <span>Price</span>
                    <svg class="cpd-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="cpd-acc-panel" id="cpd-panel-price">
                    <!-- Dual Range Slider -->
                    <div class="cpd-dual-slider">
                        <div class="cpd-slider-track" id="cpd-slider-track"></div>
                        <input type="range" class="cpd-range-input" id="cpd-range-min"
                               min="0" max="10000" value="{{ $minPrice ?? 0 }}" step="100">
                        <input type="range" class="cpd-range-input" id="cpd-range-max"
                               min="0" max="10000" value="{{ $maxPrice ?? 10000 }}" step="100">
                    </div>
                    <!-- Price Inputs -->
                    <div class="cpd-price-row">
                        <div class="cpd-price-box">
                            <span class="cpd-rs-label">Rs</span>
                            <input type="number" class="cpd-price-input" id="cpd-price-min" value="{{ $minPrice ?? 0 }}">
                        </div>
                        <span class="cpd-price-dash">—</span>
                        <div class="cpd-price-box">
                            <span class="cpd-rs-label">Rs</span>
                            <input type="number" class="cpd-price-input" id="cpd-price-max" value="{{ $maxPrice ?? 10000 }}">
                        </div>
                    </div>
                    <!-- Apply Button -->
                    <button id="cpd-apply-price" style="width: 100%; margin-top: 12px; padding: 10px; background: #f06292; color: white; border: none; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                        Apply Price Filter
                    </button>
                </div>
            </div>


            <!-- ── Availability ── -->
            @php
                $inStockCount = isset($products) ? $products->where('stock_quantity', '>', 0)->count() : 0;
                $outStockCount = isset($products) ? $products->where('stock_quantity', '<=', 0)->count() : 0;
            @endphp
            <div class="cpd-section">
                <button class="cpd-acc-btn" id="cpd-acc-avail">
                    <span>Availability</span>
                    <svg class="cpd-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="cpd-acc-panel" id="cpd-panel-avail">
                    <div class="cpd-avail-wrap">
                        <button class="cpd-avail-btn" id="cpd-avail-in">In Stock <em>({{ $inStockCount }})</em></button>
                        <button class="cpd-avail-btn" id="cpd-avail-out">Out of Stock <em>({{ $outStockCount }})</em></button>
                    </div>
                </div>
            </div>

            <!-- ── Gender ── -->
            <div class="cpd-section">
                <button class="cpd-acc-btn" id="cpd-acc-gender">
                    <span>Gender</span>
                    <svg class="cpd-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="cpd-acc-panel" id="cpd-panel-gender">
                    <div class="cpd-cb-grid">
                        <label class="cpd-cb-item"><input type="checkbox" class="cpd-cb"><span class="cpd-cb-label">Boys</span></label>
                        <label class="cpd-cb-item"><input type="checkbox" class="cpd-cb"><span class="cpd-cb-label">Girls</span></label>
                        <label class="cpd-cb-item"><input type="checkbox" class="cpd-cb"><span class="cpd-cb-label">Unisex</span></label>
                    </div>
                </div>
            </div>

        </div><!-- /.cpd-body -->

    </div><!-- /.cpd-drawer -->

    <!-- Product Grid -->
    <div class="cp-grid-wrap">
        <div class="cp-grid" id="cp-grid">


            @isset($products)
                @forelse($products as $product)
                    @php
                        $productCategory = strtolower($product->category ?? '');
                        $productGender = 'other';

                        if (strpos($productCategory, 'boys') !== false || $productCategory === 'boys') {
                            $productGender = 'boys';
                        } elseif (strpos($productCategory, 'girls') !== false || $productCategory === 'girls') {
                            $productGender = 'girls';
                        } elseif (strpos($productCategory, 'baby') !== false || $productCategory === 'baby-wear') {
                            $productGender = 'unisex';
                        }
                    @endphp
                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="cp-card"
                       data-name="{{ strtolower($product->name) }}"
                       data-price="{{ $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price }}"
                       data-created="{{ strtotime($product->created_at) }}"
                       data-age-group="{{ strtolower($product->age_group ?? '') }}"
                       data-size="{{ strtolower(($product->age_group ?? '') . ' ' . ($product->size ?? '')) }}"
                       data-type="{{ strtolower($product->category ?? '') }}"
                       data-product-type="{{ strtolower($product->product_type ?? '') }}"
                       data-stock="{{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}"
                       data-gender="{{ $productGender }}">
                        <div class="cp-card-img">
                            @if($product->display_sections && in_array('new_arrivals', $product->display_sections))
                                <span class="cp-badge-new">New</span>
                            @endif
                            @if($product->stock_quantity <= 0)
                                <span class="cp-badge-stock">Out of Stock</span>
                            @endif
                            <img src="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $product->name }}">
                        </div>
                        <div class="cp-card-info">
                            <p class="cp-card-name">{{ $product->name }}</p>
                            <div class="cp-card-price">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="cp-old">Rs. {{ number_format($product->price, 0) }}</span>
                                    <span class="cp-new">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                @else
                                    <span class="cp-new">Rs. {{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #999;">
                        <p style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No products found</p>
                        <p style="font-size: 14px; color: #aaa;">No products available in this category yet.</p>
                    </div>
                @endforelse
            @else
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="cp-card">
                        <div class="cp-card-img">
                            <img src="{{ asset($category->image ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $category->name }}">
                        </div>
                        <div class="cp-card-info">
                            <p class="cp-card-name">{{ $category->name }}</p>
                            <div class="cp-card-price">
                                <span class="cp-new">{{ $category->products->count() }} Products</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #999;">
                        <p style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No categories found</p>
                    </div>
                @endforelse
            @endisset

        </div>
        </div>

        <!-- Pagination -->
        <div class="cp-pagination" id="cp-pagination">
            <button class="cp-page-btn cp-page-btn--active" id="cp-pg-1">1</button>
            <button class="cp-page-btn" id="cp-pg-2">2</button>
            <button class="cp-page-btn" id="cp-pg-3">3</button>
            <button class="cp-page-btn cp-page-next" id="cp-pg-next">Next ›</button>
        </div>
    </div>

    <!-- ════════════════════════════════
         Scripts
    ════════════════════════════════ -->
    <script>
        // ── Filter Drawer open/close ──
        var filterBtn  = document.getElementById('cp-filter-toggle-btn');
        var drawer     = document.getElementById('cpd-drawer');
        var overlay    = document.getElementById('cpd-overlay');
        var closeBtn   = document.getElementById('cpd-close');

        function openDrawer()  { drawer.classList.add('cpd-drawer--open');  overlay.classList.add('cpd-overlay--show'); }
        function closeDrawer() { drawer.classList.remove('cpd-drawer--open'); overlay.classList.remove('cpd-overlay--show'); }

        filterBtn.addEventListener('click', openDrawer);
        closeBtn.addEventListener('click', closeDrawer);
        overlay.addEventListener('click', closeDrawer);

        // ── Custom Sort Dropdown ──
        var sortBtn  = document.getElementById('cp-sort-btn');
        var sortMenu = document.getElementById('cp-sort-menu');

        sortBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = sortMenu.classList.contains('cp-sort-menu--open');
            sortMenu.classList.toggle('cp-sort-menu--open', !isOpen);
            sortBtn.classList.toggle('cp-sort-open', !isOpen);
        });

        document.querySelectorAll('.cp-sort-item').forEach(function (item) {
            item.addEventListener('click', function () {
                document.querySelectorAll('.cp-sort-item').forEach(function (i) { i.classList.remove('cp-sort-item--active'); });
                item.classList.add('cp-sort-item--active');
                // Update button text safely (keep chevron svg)
                var chevronSvg = sortBtn.querySelector('svg') ? sortBtn.querySelector('svg').outerHTML : '';
                sortBtn.innerHTML = item.textContent + ' ' + chevronSvg;
                sortMenu.classList.remove('cp-sort-menu--open');
                sortBtn.classList.remove('cp-sort-open');
                
                // Trigger the sorting and filtering engine
                if (typeof applyFiltersAndSort === 'function') {
                    applyFiltersAndSort();
                }
            });
        });

        document.addEventListener('click', function () {
            sortMenu.classList.remove('cp-sort-menu--open');
            sortBtn.classList.remove('cp-sort-open');
        });

        // ── Accordion sections ──
        document.querySelectorAll('.cpd-acc-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var panelId = btn.id.replace('cpd-acc-', 'cpd-panel-');
                var panel   = document.getElementById(panelId);
                var chevron = btn.querySelector('.cpd-chevron');
                var isOpen  = panel.classList.contains('cpd-acc-open');
                panel.classList.toggle('cpd-acc-open', !isOpen);
                chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });

        // Init: chevrons for already-open panels
        document.querySelectorAll('.cpd-acc-panel.cpd-acc-open').forEach(function (panel) {
            var btnId   = panel.id.replace('cpd-panel-', 'cpd-acc-');
            var chevron = document.getElementById(btnId) && document.getElementById(btnId).querySelector('.cpd-chevron');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        });

        // ── Client-side Filter, Sort, and Pagination Engine Setup ──
        var productsPerPage = 8;
        var grid = document.getElementById('cp-grid');
        var originalCards = grid ? Array.from(grid.querySelectorAll('.cp-card')) : [];
        var productCards = originalCards.filter(function(c) {
            return c.hasAttribute('data-price');
        });
        
        // Dynamically compute maximum product price on page load
        var maxProductPrice = 10000;
        productCards.forEach(function(card) {
            var p = parseFloat(card.getAttribute('data-price')) || 0;
            if (p > maxProductPrice) {
                maxProductPrice = Math.ceil(p / 1000) * 1000; // round up to nearest 1000
            }
        });

        // ── Dual Range Slider — Price ──
        var rangeMin  = document.getElementById('cpd-range-min');
        var rangeMax  = document.getElementById('cpd-range-max');
        var inputMin  = document.getElementById('cpd-price-min');
        var inputMax  = document.getElementById('cpd-price-max');
        var track     = document.getElementById('cpd-slider-track');

        function updateSlider() {
            var min    = parseInt(rangeMin.min);
            var max    = parseInt(rangeMin.max);
            var valMin = parseInt(rangeMin.value);
            var valMax = parseInt(rangeMax.value);
            var pctMin = ((valMin - min) / (max - min)) * 100;
            var pctMax = ((valMax - min) / (max - min)) * 100;
            track.style.left  = pctMin + '%';
            track.style.width = (pctMax - pctMin) + '%';
            inputMin.value = valMin;
            inputMax.value = valMax;
        }

        if (rangeMin && rangeMax && track) {
            // Apply dynamic limits based on actual products loaded
            rangeMin.max = maxProductPrice;
            rangeMax.max = maxProductPrice;
            rangeMax.value = maxProductPrice;
            if (inputMax) inputMax.value = maxProductPrice;

            rangeMin.addEventListener('input', function () {
                rangeMin.style.zIndex = '3';
                rangeMax.style.zIndex = '2';
                if (parseInt(rangeMin.value) >= parseInt(rangeMax.value))
                    rangeMin.value = parseInt(rangeMax.value) - 100;
                updateSlider();
                if (typeof applyFiltersAndSort === 'function') applyFiltersAndSort();
            });
            rangeMax.addEventListener('input', function () {
                rangeMax.style.zIndex = '3';
                rangeMin.style.zIndex = '2';
                if (parseInt(rangeMax.value) <= parseInt(rangeMin.value))
                    rangeMax.value = parseInt(rangeMin.value) + 100;
                updateSlider();
                if (typeof applyFiltersAndSort === 'function') applyFiltersAndSort();
            });
            inputMin.addEventListener('input', function () {
                rangeMin.value = inputMin.value; 
                updateSlider();
                if (typeof applyFiltersAndSort === 'function') applyFiltersAndSort();
            });
            inputMax.addEventListener('input', function () {
                rangeMax.value = inputMax.value; 
                updateSlider();
                if (typeof applyFiltersAndSort === 'function') applyFiltersAndSort();
            });
            updateSlider(); // init
        }

        // ── Client-side Filter, Sort, and Pagination Engine Setup ──
        var paginationContainer = document.getElementById('cp-pagination');
        var currentPage = 1;

        function normalizeFilterValue(value) {
            return (value || '').toString().trim().toLowerCase().replace(/\s+/g, ' ');
        }

        function matchSizeRange(sizeStr, filterRange) {
            sizeStr = normalizeFilterValue(sizeStr);
            
            // Define all standard age group sizes
            var allAgeGroups = ['new born', '0-2', '2-5', '5-8', '8-14'];
            
            // If the sizeStr explicitly contains another standard age group, reject it immediately
            for (var i = 0; i < allAgeGroups.length; i++) {
                var group = allAgeGroups[i];
                if (group !== filterRange && sizeStr.indexOf(group) !== -1) {
                    return false;
                }
            }
            
            // Direct exact match (e.g. if sizeStr contains "0-2" or "2-5" directly)
            if (sizeStr.indexOf(filterRange) !== -1) return true;
            
            if (filterRange === 'new born') {
                return sizeStr.indexOf('newborn') !== -1 || sizeStr.indexOf('new born') !== -1 || sizeStr.indexOf('nb') !== -1 || sizeStr.indexOf('0-3m') !== -1 || sizeStr.indexOf('3-6m') !== -1 || sizeStr.indexOf('6-12m') !== -1;
            }
            if (filterRange === '0-2') {
                if (sizeStr.indexOf('newborn') !== -1 || sizeStr.indexOf('new born') !== -1 || sizeStr.indexOf('nb') !== -1) return true;
                if (sizeStr.indexOf('m') !== -1) return true; // Months are under 2 years
                var years = sizeStr.match(/\d+/g);
                if (years) {
                    var minYear = Math.min.apply(null, years.map(Number));
                    return minYear <= 2;
                }
                return false;
            }
            if (filterRange === '2-5') {
                var years = sizeStr.match(/\d+/g);
                if (years) {
                    var yearNums = years.map(Number);
                    return yearNums.some(function(y) {
                        return y >= 2 && y <= 5;
                    });
                }
                return sizeStr.indexOf('2-4y') !== -1 || sizeStr.indexOf('4-6y') !== -1;
            }
            if (filterRange === '5-8') {
                var years = sizeStr.match(/\d+/g);
                if (years) {
                    var yearNums = years.map(Number);
                    return yearNums.some(function(y) {
                        return y >= 5 && y <= 8;
                    });
                }
                return sizeStr.indexOf('4-6y') !== -1 || sizeStr.indexOf('6-8y') !== -1;
            }
            if (filterRange === '8-14') {
                var years = sizeStr.match(/\d+/g);
                if (years) {
                    var yearNums = years.map(Number);
                    return yearNums.some(function(y) {
                        return y >= 8 && y <= 14;
                    });
                }
                return sizeStr.indexOf('8-10y') !== -1 || sizeStr.indexOf('10-12y') !== -1 || sizeStr.indexOf('12-14y') !== -1;
            }
            return false;
        }

        function applyFiltersAndSort() {
            if (productCards.length === 0) return;

            // 1. Gather active filters
            
            // Genders
            var activeGenders = [];
            document.querySelectorAll('.cpd-section').forEach(function(sec) {
                var secNameBtn = sec.querySelector('.cpd-acc-btn span');
                var secName = secNameBtn ? secNameBtn.textContent.trim().toLowerCase() : '';
                if (secName.indexOf('gender') !== -1) {
                    sec.querySelectorAll('.cpd-cb:checked').forEach(function(cb) {
                        var labelSpan = cb.closest('.cpd-cb-item').querySelector('.cpd-cb-label');
                        var labelText = normalizeFilterValue(labelSpan.textContent.replace(/\s*\(.*\)\s*/g, ''));
                        activeGenders.push(labelText);
                    });
                }
            });
            
            // Sizes
            var activeSizes = [];
            document.querySelectorAll('.cpd-section').forEach(function(sec) {
                var secNameBtn = sec.querySelector('.cpd-acc-btn span');
                var secName = secNameBtn ? secNameBtn.textContent.trim().toLowerCase() : '';
                if (secName.indexOf('size') !== -1) {
                    sec.querySelectorAll('.cpd-cb:checked').forEach(function(cb) {
                        var labelSpan = cb.closest('.cpd-cb-item').querySelector('.cpd-cb-label');
                        var labelText = normalizeFilterValue(labelSpan.textContent.replace(/\s*\(.*\)\s*/g, ''));
                        activeSizes.push(labelText);
                    });
                }
            });

            // Product Types
            var activeTypes = [];
            document.querySelectorAll('.cpd-section').forEach(function(sec) {
                var secNameBtn = sec.querySelector('.cpd-acc-btn span');
                var secName = secNameBtn ? secNameBtn.textContent.trim().toLowerCase() : '';
                if (secName.indexOf('type') !== -1) {
                    sec.querySelectorAll('.cpd-cb:checked').forEach(function(cb) {
                        var labelSpan = cb.closest('.cpd-cb-item').querySelector('.cpd-cb-label');
                        var labelText = normalizeFilterValue(cb.value || labelSpan.textContent.replace(/\s*\(.*\)\s*/g, ''));
                        activeTypes.push(labelText);
                    });
                }
            });

            // Stock Availability — only filter if user explicitly clicked a button
            var stockVal = null; // null = no stock filter active
            var activeStockBtn = document.querySelector('.cpd-avail-btn--active');
            if (activeStockBtn) {
                var text = activeStockBtn.textContent.trim().toLowerCase();
                stockVal = text.indexOf('out') !== -1 ? 'out-of-stock' : 'in-stock';
            }

            // Price range values
            var minPrice = parseFloat(document.getElementById('cpd-price-min').value) || 0;
            var maxPrice = parseFloat(document.getElementById('cpd-price-max').value) || maxProductPrice;

            // Sort state
            var activeSortItem = document.querySelector('.cp-sort-item--active');
            var sortVal = activeSortItem ? activeSortItem.getAttribute('data-value') : 'featured';

            // Search filter query
            var globalSearch = document.getElementById('global-search-input');
            var searchQuery = globalSearch ? globalSearch.value.trim().toLowerCase() : '';

            // 2. Filter products list
            var matchingCards = productCards.filter(function(card) {
                var price = parseFloat(card.getAttribute('data-price')) || 0;
                var ageGroup = normalizeFilterValue(card.getAttribute('data-age-group'));
                var sizeStr = normalizeFilterValue(card.getAttribute('data-size'));
                var nameStr = card.getAttribute('data-name') || '';
                var typeStr = card.getAttribute('data-type') || '';
                var productTypeAttr = normalizeFilterValue(card.getAttribute('data-product-type'));
                var stock = card.getAttribute('data-stock') || 'in-stock';
                var gender = card.getAttribute('data-gender') || 'unisex';

                // Price validation
                if (price < minPrice || price > maxPrice) return false;

                // Stock validation — only if explicitly selected
                if (stockVal !== null && stock !== stockVal) return false;

                // Search query validation (Strict word-by-word Product Name matching)
                if (searchQuery) {
                    var searchWords = searchQuery.split(/\s+/).filter(Boolean);
                    var matchAll = searchWords.every(function(word) {
                        return nameStr.indexOf(word) !== -1;
                    });
                    if (!matchAll) return false;
                }

                // Gender validation
                if (activeGenders.length > 0) {
                    var match = activeGenders.some(function(g) {
                        return gender === g;
                    });
                    if (!match) return false;
                }

                // Size / Age-Group validation
                if (activeSizes.length > 0) {
                    // If this product has NO age_group set, skip size filter (show for all)
                    if (ageGroup === '' && sizeStr === '') return true;
                    var match = activeSizes.some(function(s) {
                        // First try: exact match against age_group from DB
                        var filterNorm = normalizeFilterValue(s);
                        if (ageGroup !== '' && ageGroup === filterNorm) return true;
                        // Second try: fuzzy match against full size string
                        return matchSizeRange(sizeStr, filterNorm);
                    });
                    if (!match) return false;
                }

                // Product type validation
                if (activeTypes.length > 0) {
                    var match = activeTypes.some(function(t) {
                        return productTypeAttr !== '' && productTypeAttr === normalizeFilterValue(t);
                    });
                    if (!match) return false;
                }

                return true;
            });

            // 3. Sort matching products
            if (sortVal === 'price-asc') {
                matchingCards.sort(function(a, b) {
                    return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
                });
            } else if (sortVal === 'price-desc') {
                matchingCards.sort(function(a, b) {
                    return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
                });
            } else if (sortVal === 'alpha-asc') {
                matchingCards.sort(function(a, b) {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                });
            } else if (sortVal === 'alpha-desc') {
                matchingCards.sort(function(a, b) {
                    return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                });
            } else if (sortVal === 'date-new') {
                matchingCards.sort(function(a, b) {
                    return parseInt(b.getAttribute('data-created')) - parseInt(a.getAttribute('data-created'));
                });
            } else if (sortVal === 'date-old') {
                matchingCards.sort(function(a, b) {
                    return parseInt(a.getAttribute('data-created')) - parseInt(b.getAttribute('data-created'));
                });
            } else {
                // Featured / Best selling -> original database query order
                var originalSortOrder = {};
                productCards.forEach(function(c, i) {
                    originalSortOrder[c.getAttribute('data-name')] = i;
                });
                matchingCards.sort(function(a, b) {
                    return originalSortOrder[a.getAttribute('data-name')] - originalSortOrder[b.getAttribute('data-name')];
                });
            }

            // 4. Update elements in grid
            // Hide all products first
            productCards.forEach(function(c) {
                c.style.display = 'none';
            });

            // Re-append sorted matches
            matchingCards.forEach(function(card) {
                grid.appendChild(card);
            });

            // Handle "No products match" banner
            var noProductsMsg = document.getElementById('cp-no-products-msg');
            if (matchingCards.length === 0) {
                if (!noProductsMsg) {
                    noProductsMsg = document.createElement('div');
                    noProductsMsg.id = 'cp-no-products-msg';
                    noProductsMsg.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #999;';
                    noProductsMsg.innerHTML = '<p style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No products match your filters</p><p style="font-size: 14px; color: #aaa;">Try adjusting your selected filters or prices.</p>';
                    grid.appendChild(noProductsMsg);
                } else {
                    noProductsMsg.style.display = 'block';
                }
            } else {
                if (noProductsMsg) noProductsMsg.style.display = 'none';
            }

            // 5. Update pagination for matching subset
            updatePaginationForCards(matchingCards);
        }

        function updatePaginationForCards(cardsList) {
            var totalItems = cardsList.length;
            
            if (totalItems <= productsPerPage) {
                if (paginationContainer) paginationContainer.style.display = 'none';
                cardsList.forEach(function(card) {
                    card.style.display = 'block';
                });
                return;
            }
            
            if (paginationContainer) paginationContainer.style.display = 'flex';
            var totalPages = Math.ceil(totalItems / productsPerPage);
            
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            
            function showPage(page) {
                currentPage = page;
                var start = (page - 1) * productsPerPage;
                var end = start + productsPerPage;
                
                cardsList.forEach(function(card, index) {
                    if (index >= start && index < end) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                renderPagination(totalPages, cardsList);
            }
            
            function renderPagination(totalPagesCount, activeCards) {
                if (!paginationContainer) return;
                paginationContainer.innerHTML = '';
                
                // Prev button
                var prevBtn = document.createElement('button');
                prevBtn.className = 'cp-page-btn';
                prevBtn.innerHTML = '‹ Prev';
                if (currentPage === 1) {
                    prevBtn.disabled = true;
                    prevBtn.style.opacity = '0.5';
                    prevBtn.style.cursor = 'not-allowed';
                } else {
                    prevBtn.addEventListener('click', function() {
                        showPage(currentPage - 1);
                        var gridRect = grid.getBoundingClientRect();
                        window.scrollTo({
                            top: gridRect.top + window.pageYOffset - 80,
                            behavior: 'smooth'
                        });
                    });
                }
                paginationContainer.appendChild(prevBtn);
                
                // Page numbers
                for (var i = 1; i <= totalPagesCount; i++) {
                    (function(pageIndex) {
                        var pageBtn = document.createElement('button');
                        pageBtn.className = 'cp-page-btn' + (pageIndex === currentPage ? ' cp-page-btn--active' : '');
                        pageBtn.textContent = pageIndex;
                        pageBtn.addEventListener('click', function() {
                            showPage(pageIndex);
                            var gridRect = grid.getBoundingClientRect();
                            window.scrollTo({
                                top: gridRect.top + window.pageYOffset - 80,
                                behavior: 'smooth'
                            });
                        });
                        paginationContainer.appendChild(pageBtn);
                    })(i);
                }
                
                // Next button
                var nextBtn = document.createElement('button');
                nextBtn.className = 'cp-page-btn cp-page-next';
                nextBtn.innerHTML = 'Next ›';
                if (currentPage === totalPagesCount) {
                    nextBtn.disabled = true;
                    nextBtn.style.opacity = '0.5';
                    nextBtn.style.cursor = 'not-allowed';
                } else {
                    nextBtn.addEventListener('click', function() {
                        showPage(currentPage + 1);
                        var gridRect = grid.getBoundingClientRect();
                        window.scrollTo({
                            top: gridRect.top + window.pageYOffset - 80,
                            behavior: 'smooth'
                        });
                    });
                }
                paginationContainer.appendChild(nextBtn);
            }
            
            showPage(currentPage);
        }

        // ── Availability toggle ──
        var availBtns = document.querySelectorAll('.cpd-avail-btn');
        availBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var wasActive = btn.classList.contains('cpd-avail-btn--active');
                availBtns.forEach(function (b) { b.classList.remove('cpd-avail-btn--active'); });
                if (!wasActive) {
                    btn.classList.add('cpd-avail-btn--active');
                }
                applyFiltersAndSort();
            });
        });

        // ── Active Filter Tags ──
        var afBar      = document.getElementById('cp-active-filters');
        var afTags     = document.getElementById('cp-af-tags');
        var afRemoveAll = document.getElementById('cp-af-remove-all');

        function updateAfBar() {
            afBar.style.display = afTags.children.length > 0 ? 'flex' : 'none';
        }

        function addTag(label, key, cb) {
            if (document.getElementById('af-tag-' + key)) return;
            var tag = document.createElement('span');
            tag.className = 'cp-af-tag';
            tag.id = 'af-tag-' + key;
            tag.innerHTML = label + ' <button class="cp-af-tag-x" aria-label="Remove">&#x2715;</button>';
            tag.querySelector('.cp-af-tag-x').addEventListener('click', function () {
                if (cb) { 
                    cb.checked = false; 
                    // Trigger checkbox change event to trigger re-filtering
                    var event = new Event('change');
                    cb.dispatchEvent(event);
                } else {
                    tag.remove();
                    updateAfBar();
                    applyFiltersAndSort();
                }
            });
            afTags.appendChild(tag);
            updateAfBar();
        }

        function removeTag(key) {
            var t = document.getElementById('af-tag-' + key);
            if (t) t.remove();
            updateAfBar();
        }

        // Attach to all checkboxes
        document.querySelectorAll('.cpd-cb').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var label = cb.closest('.cpd-cb-item').querySelector('.cpd-cb-label').textContent.trim();
                var key   = label.replace(/\s+/g, '-').replace(/[()]/g, '');
                var section = cb.closest('.cpd-section');
                var sectionName = section ? section.querySelector('.cpd-acc-btn span').textContent.trim() : '';
                var fullLabel   = sectionName + ': ' + label;
                if (cb.checked) {
                    addTag(fullLabel, key, cb);
                } else {
                    removeTag(key);
                }
                applyFiltersAndSort();
            });
        });

        // Remove all
        afRemoveAll.addEventListener('click', function () {
            document.querySelectorAll('.cpd-cb').forEach(function (cb) { cb.checked = false; });
            availBtns.forEach(function (b) { b.classList.remove('cpd-avail-btn--active'); });
            afTags.innerHTML = '';
            updateAfBar();
            applyFiltersAndSort();
        });

        // ── Pre-select filters from URL ──
        // Size filter functionality
        var isFilteringInProgress = false;
        
        document.querySelectorAll('#cpd-panel-size .cpd-cb').forEach(function(checkbox) {
            checkbox.addEventListener('change', function(e) {
                // Prevent infinite loop
                if (isFilteringInProgress) {
                    return;
                }
                
                isFilteringInProgress = true;
                
                var sizeLabel = this.closest('.cpd-cb-item').querySelector('.cpd-cb-label').textContent.trim();
                var currentUrl = new URL(window.location.href);
                
                if (this.checked) {
                    // Uncheck other size checkboxes (single selection)
                    document.querySelectorAll('#cpd-panel-size .cpd-cb').forEach(function(cb) {
                        if (cb !== checkbox) {
                            cb.checked = false;
                        }
                    });
                    
                    // Add size parameter to URL
                    currentUrl.searchParams.set('size', sizeLabel);
                    
                    // Reload page with new URL
                    window.location.href = currentUrl.toString();
                } else {
                    // Remove size parameter from URL
                    currentUrl.searchParams.delete('size');
                    
                    // Reload page with new URL
                    window.location.href = currentUrl.toString();
                }
            });
        });

        // Price filter functionality
        var applyPriceBtn = document.getElementById('cpd-apply-price');
        if (applyPriceBtn) {
            applyPriceBtn.addEventListener('click', function() {
                var minPrice = document.getElementById('cpd-price-min').value;
                var maxPrice = document.getElementById('cpd-price-max').value;
                var currentUrl = new URL(window.location.href);
                
                // Add price parameters to URL
                currentUrl.searchParams.set('min_price', minPrice);
                currentUrl.searchParams.set('max_price', maxPrice);
                
                // Reload page with new URL
                window.location.href = currentUrl.toString();
            });
        }
    </script>

    </div><!-- /.cp-page-wrapper -->

@include('partials.footer')
