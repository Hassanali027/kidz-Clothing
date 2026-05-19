@include('partials.header')

<style>
/* ── Product Detail Page (pd-) ── */
.pd-breadcrumb { display:flex; align-items:center; gap:6px; padding:12px 40px; font-size:12.5px; color:#888; background:#fafafa; border-bottom:1px solid #eee; }
.pd-breadcrumb a { color:#555; text-decoration:none; transition:color 0.2s; }
.pd-breadcrumb a:hover { color:#f06292; }
.pd-bc-sep { color:#bbb; }
.pd-bc-current { color:#222; font-weight:500; }
.pd-section { background:#fff; padding:36px 40px 60px; }
.pd-inner { display:flex; gap:48px; max-width:1100px; margin:0 auto; align-items:flex-start; }
.pd-gallery { display:flex; gap:12px; flex:0 0 420px; }
.pd-thumbs { display:flex; flex-direction:column; gap:8px; }
.pd-thumb { width:72px; height:72px; border:2px solid #eee; border-radius:6px; overflow:hidden; padding:0; cursor:pointer; background:none; transition:border-color 0.2s; }
.pd-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.pd-thumb--active,.pd-thumb:hover { border-color:#29b6f6; }
.pd-main-img-wrap { position:relative; flex:1; border-radius:10px; overflow:hidden; border:1px solid #eee; line-height:0; }
.pd-main-img { width:100%; height:auto; object-fit:cover; object-position:top center; display:block; transition:transform 0.4s ease; }
.pd-main-img-wrap:hover .pd-main-img { transform:scale(1.04); }
.pd-zoom-btn { position:absolute; bottom:12px; right:12px; width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.9); border:1px solid #ddd; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#444; transition:background 0.2s; }
.pd-zoom-btn:hover { background:#fff; color:#29b6f6; }
.pd-info { flex:1; display:flex; flex-direction:column; gap:16px; }
.pd-title-row { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
.pd-title { font-size:22px; font-weight:700; color:#111; line-height:1.3; }
.pd-stock { font-size:13px; font-weight:600; color:#43a047; white-space:nowrap; padding:4px 10px; border-radius:20px; background:#e8f5e9; }
.pd-rating { display:flex; align-items:center; gap:6px; }
.pd-stars { display:flex; gap:2px; }
.pd-star { font-size:16px; color:#ddd; }
.pd-star--filled { color:#fdd835; }
.pd-star--half { color:#fdd835; opacity:0.6; }
.pd-rating-val { font-size:13px; font-weight:600; color:#333; }
.pd-rating-count { font-size:12px; color:#888; }
.pd-price-row { display:flex; align-items:center; gap:10px; }
.pd-price-new { font-size:22px; font-weight:700; color:#f06292; }
.pd-price-old { font-size:15px; color:#aaa; text-decoration:line-through; }
.pd-divider { height:1px; background:#eee; }
.pd-option-group { display:flex; flex-direction:column; gap:10px; }
.pd-option-label { font-size:14px; color:#333; }
.pd-option-label strong { color:#111; }
.pd-colors { display:flex; gap:8px; }
.pd-color-swatch { width:28px; height:28px; border-radius:50%; border:2px solid transparent; cursor:pointer; transition:border-color 0.2s,transform 0.2s; }
.pd-color-swatch:hover { transform:scale(1.15); }
.pd-color-swatch--active { border-color:#333; box-shadow:0 0 0 2px #fff,0 0 0 4px #333; }
.pd-size-header { display:flex; align-items:center; justify-content:space-between; }
.pd-size-guide { font-size:12px; color:#29b6f6; text-decoration:none; }
.pd-size-guide:hover { text-decoration:underline; }
.pd-sizes { display:flex; gap:8px; flex-wrap:wrap; }
.pd-size-btn { padding:6px 14px; border:1.5px solid #ddd; border-radius:6px; background:#fff; font-family:'Outfit',sans-serif; font-size:13px; font-weight:500; color:#444; cursor:pointer; transition:border-color 0.2s,background 0.2s,color 0.2s; }
.pd-size-btn:hover { border-color:#f06292; color:#f06292; }
.pd-size-btn--active { border-color:#f06292; background:#fff0f5; color:#f06292; font-weight:700; }
.pd-qty-wrap { display:flex; align-items:center; gap:0; border:1.5px solid #ddd; border-radius:8px; overflow:hidden; width:fit-content; }
.pd-qty-btn { width:38px; height:38px; border:none; background:#f5f5f5; font-size:18px; font-weight:600; color:#444; cursor:pointer; transition:background 0.2s; display:flex; align-items:center; justify-content:center; }
.pd-qty-btn:hover { background:#ebebeb; }
.pd-qty-input { width:48px; height:38px; border:none; text-align:center; font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#111; background:#fff; outline:none; }
.pd-cta-btns { display:flex; flex-direction:column; gap:10px; }
.pd-btn-cart { width:100%; padding:14px; background:#29b6f6; color:#fff; border:none; border-radius:8px; font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; cursor:pointer; transition:background 0.25s; }
.pd-btn-cart:hover { background:#0288d1; }
.pd-btn-buy { width:100%; padding:13px; background:#fff; color:#111; border:1.5px solid #ccc; border-radius:8px; font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; cursor:pointer; transition:border-color 0.2s,color 0.2s; }
.pd-btn-buy:hover { border-color:#111; }
.pd-accordion { border-top:1px solid #eee; }
.pd-acc-item { border-bottom:1px solid #eee; }
.pd-acc-toggle { display:flex; align-items:center; justify-content:space-between; width:100%; padding:13px 0; background:none; border:none; font-family:'Outfit',sans-serif; font-size:14px; font-weight:500; color:#222; cursor:pointer; text-align:left; }
.pd-acc-icon { font-size:18px; color:#888; transition:transform 0.25s; display:inline-block; }
.pd-acc-body { display:none; padding:0 0 14px; font-size:13.5px; color:#000; line-height:1.65; }
.pd-acc-body.pd-acc-open { display:block; }
/* ── Color + Size Row ── */
.pd-color-size-row { display:flex; gap:16px; }
.pd-color-size-row .pd-option-group { flex:1; }

/* ── Tablet ── */
@media (max-width:900px) {
    .pd-inner { flex-direction:column; gap:24px; align-items:stretch; }
    .pd-gallery { flex:none; width:100%; }
    .pd-info { width:100%; }
    .pd-main-img { height:auto; }
    .pd-section { padding:28px 24px 50px; }
}
/* ── Mobile ── */
@media (max-width:600px) {
    .pd-section { padding:0 0 40px; }
    .pd-breadcrumb { padding:10px 16px; font-size:12px; }
    .pd-inner { width:100%; max-width:none; gap:0; }

    /* Gallery: main image on top, thumbs row below */
    .pd-gallery {
        flex-direction: column;
        gap: 0;
    }
    .pd-main-img-wrap {
        border-radius: 0;
        border-left: none;
        border-right: none;
        border-top: none;
    }
    .pd-main-img {
        height: 320px;
        object-fit: cover;
        object-position: top center;
    }
    .pd-thumbs {
        flex-direction: row;
        overflow-x: auto;
        gap: 8px;
        padding: 10px 16px;
        background: #fafafa;
        border-bottom: 1px solid #eee;
        scrollbar-width: none;
    }
    .pd-thumbs::-webkit-scrollbar { display:none; }
    .pd-thumb {
        flex: 0 0 60px;
        width: 60px;
        height: 60px;
    }
    .pd-zoom-btn { display:none; }

    /* Info panel */
    .pd-info {
        gap: 14px;
        width: 100%;
        padding: 20px 20px 0;
    }
    .pd-title-row {
        align-items: flex-start;
        gap: 8px;
    }
    .pd-title { font-size: 17px; line-height: 1.35; }
    .pd-stock { font-size: 12px; padding: 3px 9px; flex-shrink: 0; }
    .pd-price-new { font-size: 20px; }
    .pd-price-old { font-size: 14px; }

    /* Color + Size side by side */
    .pd-color-size-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        border: 1.5px solid #eee;
        border-radius: 12px;
        overflow: hidden;
    }
    .pd-color-size-row .pd-option-group {
        padding: 12px 14px;
        border: none;
    }
    .pd-color-size-row .pd-option-group:first-child {
        border-right: 1.5px solid #eee;
    }

    /* Options */
    .pd-option-label { font-size: 13px; margin-bottom: 8px; }
    .pd-size-header { flex-direction: column; align-items: flex-start; gap: 4px; }
    .pd-size-guide { font-size: 11px; }
    .pd-sizes { gap: 5px; flex-wrap: wrap; }
    .pd-size-btn { padding: 4px 10px; font-size: 12px; }
    .pd-colors { gap: 6px; flex-wrap: wrap; }
    .pd-color-swatch { width: 26px; height: 26px; }

    /* Quantity */
    .pd-qty-wrap { border-radius: 8px; }
    .pd-qty-btn { width: 42px; height: 42px; font-size: 20px; }
    .pd-qty-input { width: 52px; height: 42px; font-size: 15px; }

    /* CTA Buttons */
    .pd-cta-btns { gap: 10px; }
    .pd-btn-cart {
        padding: 15px;
        font-size: 15px;
        border-radius: 10px;
    }
    .pd-btn-buy {
        padding: 14px;
        font-size: 15px;
        border-radius: 10px;
    }

    /* Accordion */
    .pd-accordion {
        width: 100%;
        margin-top: 6px;
        border-top: 1px solid #f0f0f0;
    }
    .pd-acc-toggle {
        min-height: 56px;
        font-size: 15px;
        font-weight: 600;
        padding: 0;
    }
    .pd-acc-toggle span:first-child {
        min-width: 0;
        padding-right: 18px;
    }
    .pd-acc-icon {
        flex: 0 0 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
    .pd-acc-body {
        padding: 0 0 18px;
        font-size: 14px;
        line-height: 1.7;
    }
}

/* ── You May Also Like (yal-) ── */
.yal-section { padding:50px 40px 60px; background:#fff; border-top:1px solid #f0f0f0; }
.yal-heading { display:flex; align-items:center; justify-content:center; gap:18px; margin-bottom:32px; }
.yal-heading h2 { font-size:20px; font-weight:700; color:#111; white-space:nowrap; }
.yal-line { display:block; height:1.5px; width:60px; background:#999; }
.yal-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; max-width:1100px; margin:0 auto; }
.yal-card { display:flex; flex-direction:column; text-decoration:none; border-radius:8px; overflow:hidden; background:#fff; border:1px solid #f0f0f0; transition:box-shadow 0.25s,transform 0.25s; }
.yal-card:hover { box-shadow:0 6px 20px rgba(0,0,0,0.09); transform:translateY(-3px); }
.yal-img-wrap { overflow:hidden; line-height:0; background:#f7f7f7; height:280px; display:flex;  justify-content:center; }
.yal-img-wrap img { width:100%; height:100%; object-fit:cover; object-position:center center; display:block; transition:transform 0.4s ease; }
.yal-card:hover .yal-img-wrap img { transform:scale(1.06); }
.yal-info { padding:12px 12px 16px; display:flex; flex-direction:column; gap:5px; }
.yal-name { font-size:14px; font-weight:600; color:#222; }
.yal-price { display:flex; align-items:center; gap:8px; }
.yal-old { font-size:12px; color:#aaa; text-decoration:line-through; }
.yal-new { font-size:14px; font-weight:700; color:#111; }
@media (max-width:900px) { .yal-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:480px) { .yal-section { padding:36px 16px 40px; } .yal-grid { grid-template-columns:repeat(2,1fr); gap:12px; } .yal-img-wrap img { height:auto; } }

/* ── Size Guide Drawer (sg-) ── */
.sg-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1100; transition:opacity 0.3s; opacity:0; }
.sg-overlay.sg-show { display:block; opacity:1; }
.sg-drawer { position:fixed; top:0; right:-440px; width:420px; max-width:95vw; height:100dvh; background:#fff; z-index:1200; display:flex; flex-direction:column; transition:right 0.35s cubic-bezier(0.4,0,0.2,1); box-shadow:-6px 0 30px rgba(0,0,0,0.18); overflow-y:auto; }
.sg-drawer.sg-open { right:0; }
.sg-header { display:flex; align-items:center; justify-content:space-between; padding:20px 24px 16px; border-bottom:1.5px solid #f3e8ef; background:linear-gradient(135deg,#fce4ec,#f8f9ff); position:sticky; top:0; z-index:10; }
.sg-title { font-size:18px; font-weight:700; color:#c2185b; letter-spacing:0.2px; }
.sg-close { width:34px; height:34px; border:none; border-radius:50%; background:#fff; color:#888; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.1); transition:background 0.2s,color 0.2s,transform 0.2s; }
.sg-close:hover { background:#f06292; color:#fff; transform:scale(1.1); }
.sg-intro { font-size:13.5px; color:#555; padding:16px 24px 8px; line-height:1.6; }
.sg-table-wrap { padding:0 24px 12px; overflow-x:auto; }
.sg-table { width:100%; border-collapse:collapse; font-size:13.5px; }
.sg-table th { background:#fce4ec; color:#c2185b; font-weight:700; padding:10px 12px; text-align:center; border-bottom:2px solid #f48fb1; }
.sg-table td { padding:10px 12px; text-align:center; color:#333; border-bottom:1px solid #f0f0f0; }
.sg-table tbody tr:hover { background:#fff3f7; }
.sg-row-highlight td { background:#fce4ec; font-weight:600; }
.sg-tip { margin:8px 24px 12px; background:#e3f2fd; border-left:4px solid #29b6f6; border-radius:8px; padding:12px 16px; font-size:13px; color:#1565c0; display:flex; align-items:flex-start; gap:10px; line-height:1.55; }
.sg-tip-icon { font-size:18px; flex-shrink:0; margin-top:1px; }
.sg-measure { margin:4px 24px 28px; background:#f9f9f9; border-radius:10px; padding:16px 18px; }
.sg-measure-title { font-size:14px; font-weight:700; color:#222; margin-bottom:10px; }
.sg-measure-list { padding-left:18px; font-size:13px; color:#555; line-height:2; }
.sg-measure-list li strong { color:#f06292; }
@media (max-width:480px) { .sg-drawer { width:100vw; right:-100vw; } .sg-drawer.sg-open { right:0; } .sg-table { font-size:12px; } .sg-table th,.sg-table td { padding:8px 8px; } }
</style>


    <!-- ════════════════════════════════
         Product Detail Page
    ════════════════════════════════ -->

    <!-- Breadcrumb -->
    <nav class="pd-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="pd-bc-sep">›</span>
        <a href="{{ route('products.index') }}">Boys Wear</a>
        <span class="pd-bc-sep">›</span>
        <span class="pd-bc-current">{{ $product->name ?? 'Products' }}</span>
    </nav>

    <!-- Main Product Layout -->
    @isset($product)
    <section class="pd-section">
        <div class="pd-inner">

            <!-- ── LEFT: Image Gallery ── -->
            <div class="pd-gallery">

                <!-- Thumbnails column -->
                <div class="pd-thumbs" id="pd-thumbs">
                    @if(isset($product->images) && is_array($product->images) && count($product->images) > 0)
                        @foreach($product->images as $index => $image)
                            <button class="pd-thumb {{ $index == 0 ? 'pd-thumb--active' : '' }}" id="pd-thumb-{{ $index }}"
                                onclick="pdSetMain(this, '{{ asset($image) }}')">
                                <img src="{{ asset($image) }}" alt="Image {{ $index + 1 }}">
                            </button>
                        @endforeach
                    @else
                        <button class="pd-thumb pd-thumb--active" id="pd-thumb-0"
                            onclick="pdSetMain(this, '{{ asset('images/img-home/baby-wear.jpg') }}')">
                            <img src="{{ asset('images/img-home/baby-wear.jpg') }}" alt="Thumb 1">
                        </button>
                    @endif
                </div>

                <!-- Main image -->
                <div class="pd-main-img-wrap">
                    <img src="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $product->name }}" class="pd-main-img" id="pd-main-img">
                    <button class="pd-zoom-btn" id="pd-zoom-btn" aria-label="Zoom">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- ── RIGHT: Product Info ── -->
            <div class="pd-info">

                <!-- Title + Stock -->
                <div class="pd-title-row">
                    <h1 class="pd-title">{{ $product->name }}</h1>
                    <span class="pd-stock" id="pd-stock">{{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                </div>

                <!-- Rating -->
                <div class="pd-rating">
                    <span class="pd-stars">
                        <span class="pd-star pd-star--filled">★</span>
                        <span class="pd-star pd-star--filled">★</span>
                        <span class="pd-star pd-star--filled">★</span>
                        <span class="pd-star pd-star--filled">★</span>
                        <span class="pd-star pd-star--half">★</span>
                    </span>
                    <span class="pd-rating-val">4.6</span>
                    <span class="pd-rating-count">(26 Reviews)</span>
                </div>

                <!-- Price -->
                <div class="pd-price-row">
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <span class="pd-price-new">Rs {{ number_format($product->sale_price) }}</span>
                        <span class="pd-price-old">Rs {{ number_format($product->price) }}</span>
                    @else
                        <span class="pd-price-new">Rs {{ number_format($product->price) }}</span>
                    @endif
                </div>

                <div class="pd-divider"></div>

                <!-- Color + Size Row -->
                <div class="pd-color-size-row">

                    <!-- Color -->
                    @if($product->color)
                    <div class="pd-option-group" id="pd-color-group">
                        @php
                            $colors = explode(',', $product->color);
                            $colors = array_map('trim', $colors);
                        @endphp
                        <p class="pd-option-label">Color: <strong id="pd-color-val">{{ $colors[0] }}</strong></p>
                        <div class="pd-colors">
                            @foreach($colors as $index => $color)
                                <button type="button" class="pd-color-swatch {{ $index == 0 ? 'pd-color-swatch--active' : '' }}"
                                    style="background: {{ strtolower($color) == 'multi-color' ? 'linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet)' : (in_array(strtolower($color), ['white', 'black', 'red', 'blue', 'green', 'yellow', 'pink', 'purple', 'grey', 'brown', 'orange']) ? strtolower($color) : '#eee') }};"
                                    data-color="{{ $color }}" aria-label="{{ $color }}">
                                    @if(!in_array(strtolower($color), ['white', 'black', 'red', 'blue', 'green', 'yellow', 'pink', 'purple', 'grey', 'brown', 'orange', 'multi-color']))
                                        <span style="font-size:10px;display:block;text-align:center;margin-top:5px;">{{ substr($color, 0, 1) }}</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Size -->
                    <div class="pd-option-group" id="pd-size-group">
                        @if($product->size)
                            @php
                                $sizes = explode(',', $product->size);
                                $sizes = array_map('trim', $sizes);
                            @endphp
                            <p class="pd-option-label">Size: <strong id="pd-size-val">{{ $sizes[0] }}</strong></p>
                        @else
                            <p class="pd-option-label">Age: <strong id="pd-size-val">{{ $product->age_group ?? 'Standard' }}</strong></p>
                        @endif
                        <a href="#" class="pd-size-guide" id="pd-size-guide-link" onclick="openSizeGuide(event)">Size Guide ›</a>
                        <div class="pd-sizes" style="margin-top:8px;">
                            @if($product->size)
                                @foreach($sizes as $index => $size)
                                    <button type="button" class="pd-size-btn {{ $index == 0 ? 'pd-size-btn--active' : '' }}" data-size="{{ $size }}">{{ $size }}</button>
                                @endforeach
                            @else
                                <button type="button" class="pd-size-btn pd-size-btn--active" data-size="{{ $product->age_group ?? 'Standard' }}">{{ $product->age_group ?? 'Standard' }}</button>
                            @endif
                        </div>
                    </div>

                </div><!-- /.pd-color-size-row -->

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->sale_price ?? $product->price }}">
                    <input type="hidden" name="image" value="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}">
                    <input type="hidden" name="color" id="selected_color" value="{{ isset($colors) ? $colors[0] : '' }}">
                    <input type="hidden" name="size" id="selected_size" value="{{ isset($sizes) ? $sizes[0] : ($product->age_group ?? 'Standard') }}">
                    
                    <input type="hidden" name="buy_now" id="buy_now_input" value="0">
                    
                    <!-- Quantity -->
                    <div class="pd-option-group">
                        <p class="pd-option-label">Quantity:</p>
                        <div class="pd-qty-wrap">
                            <button type="button" class="pd-qty-btn" id="pd-qty-minus" aria-label="Decrease">−</button>
                            <input type="number" name="quantity" class="pd-qty-input" id="pd-qty-input" value="1" min="1" max="99" readonly>
                            <button type="button" class="pd-qty-btn" id="pd-qty-plus" aria-label="Increase">+</button>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pd-cta-btns">
                        <button type="submit" class="pd-btn-cart" id="pd-add-to-cart">Add to Cart</button>
                        <button type="submit" class="pd-btn-buy" id="pd-buy-now" onclick="document.getElementById('buy_now_input').value='1'">Buy it Now</button>
                    </div>
                </form>

                <!-- Accordion -->
                <div class="pd-accordion" id="pd-accordion">

                    <div class="pd-acc-item">
                        <button class="pd-acc-toggle" id="pd-acc-details">
                            <span>Product Details</span>
                            <span class="pd-acc-icon">›</span>
                        </button>
                        <div class="pd-acc-body">
                            <p>{{ $product->description ?? 'Premium quality fabric for your little one. Soft, breathable, and durable material. Machine washable. Perfect for party occasions.' }}</p>
                        </div>
                    </div>

                    <div class="pd-acc-item">
                        <button class="pd-acc-toggle" id="pd-acc-shipping">
                            <span>Shipping</span>
                            <span class="pd-acc-icon">›</span>
                        </button>
                        <div class="pd-acc-body">
                            <p>Free delivery on orders above Rs 3,000. Standard delivery 3-5 business days. Express delivery available.</p>
                        </div>
                    </div>

                    <div class="pd-acc-item">
                        <button class="pd-acc-toggle" id="pd-acc-return">
                            <span>Return &amp; Exchange</span>
                            <span class="pd-acc-icon">›</span>
                        </button>
                        <div class="pd-acc-body">
                            <p>Easy 30-day return policy. Items must be unused and in original condition. Exchange available within 7 days of delivery.</p>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end pd-info -->

        </div>
    </section>
    @else
    <section class="pd-section" style="text-align: center; padding: 80px 40px;">
        <h2 style="font-size: 24px; color: #333; margin-bottom: 16px;">Product Not Found</h2>
        <p style="color: #666; margin-bottom: 24px;">The product you're looking for doesn't exist or has been removed.</p>
        <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 32px; background: #f06292; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">Go to Homepage</a>
    </section>
    @endisset

    <!-- ════════════════════════════════
         Product Page Scripts
    ════════════════════════════════ -->
    <script>
        // ── Thumbnail switcher ──
        function pdSetMain(btn, src) {
            document.getElementById('pd-main-img').src = src;
            document.querySelectorAll('.pd-thumb').forEach(function(t) {
                t.classList.remove('pd-thumb--active');
            });
            btn.classList.add('pd-thumb--active');
        }

        // ── Color swatches ──
        document.querySelectorAll('.pd-color-swatch').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.pd-color-swatch').forEach(function(b) {
                    b.classList.remove('pd-color-swatch--active');
                });
                btn.classList.add('pd-color-swatch--active');
                var color = btn.getAttribute('data-color');
                document.getElementById('pd-color-val').textContent = color;
                document.getElementById('selected_color').value = color;
            });
        });

        // ── Size buttons ──
        document.querySelectorAll('.pd-size-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.pd-size-btn').forEach(function(b) {
                    b.classList.remove('pd-size-btn--active');
                });
                btn.classList.add('pd-size-btn--active');
                var size = btn.getAttribute('data-size');
                document.getElementById('pd-size-val').textContent = size;
                document.getElementById('selected_size').value = size;
            });
        });

        // ── Quantity ──
        document.getElementById('pd-qty-minus').addEventListener('click', function() {
            var inp = document.getElementById('pd-qty-input');
            if (parseInt(inp.value) > 1) inp.value = parseInt(inp.value) - 1;
        });
        document.getElementById('pd-qty-plus').addEventListener('click', function() {
            var inp = document.getElementById('pd-qty-input');
            if (parseInt(inp.value) < 99) inp.value = parseInt(inp.value) + 1;
        });

        // ── Accordion ──
        document.querySelectorAll('.pd-acc-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var body = btn.nextElementSibling;
                var icon = btn.querySelector('.pd-acc-icon');
                var isOpen = body.classList.contains('pd-acc-open');
                // Close all
                document.querySelectorAll('.pd-acc-body').forEach(function(b) { b.classList.remove('pd-acc-open'); });
                document.querySelectorAll('.pd-acc-icon').forEach(function(i) { i.style.transform = ''; });
                // Toggle
                if (!isOpen) {
                    body.classList.add('pd-acc-open');
                    icon.style.transform = 'rotate(90deg)';
                }
            });
        });
        // ── Size Guide Drawer ──
        function openSizeGuide(e) {
            e.preventDefault();
            document.getElementById('sg-drawer').classList.add('sg-open');
            document.getElementById('sg-overlay').classList.add('sg-show');
            document.body.style.overflow = 'hidden';
        }
        function closeSizeGuide() {
            document.getElementById('sg-drawer').classList.remove('sg-open');
            document.getElementById('sg-overlay').classList.remove('sg-show');
            document.body.style.overflow = '';
        }
    </script>

    <!-- ── Size Guide Drawer ── -->
    <div class="sg-overlay" id="sg-overlay" onclick="closeSizeGuide()"></div>
    <div class="sg-drawer" id="sg-drawer">
        <!-- Header -->
        <div class="sg-header">
            <h3 class="sg-title">📏 Size Guide</h3>
            <button class="sg-close" id="sg-close-btn" onclick="closeSizeGuide()" aria-label="Close">✕</button>
        </div>

        <!-- Intro -->
        <p class="sg-intro">Please measure your child carefully and refer to the chart below to find the perfect fit.</p>

        <!-- Size Table -->
        <div class="sg-table-wrap">
            <table class="sg-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Age</th>
                        <th>Height (cm)</th>
                        <th>Chest (cm)</th>
                        <th>Waist (cm)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>1-2Y</strong></td>
                        <td>1 – 2 yrs</td>
                        <td>80 – 92</td>
                        <td>48 – 51</td>
                        <td>46 – 49</td>
                    </tr>
                    <tr>
                        <td><strong>2-3Y</strong></td>
                        <td>2 – 3 yrs</td>
                        <td>92 – 98</td>
                        <td>51 – 54</td>
                        <td>49 – 51</td>
                    </tr>
                    <tr>
                        <td><strong>3-4Y</strong></td>
                        <td>3 – 4 yrs</td>
                        <td>98 – 104</td>
                        <td>54 – 57</td>
                        <td>51 – 53</td>
                    </tr>
                    <tr class="sg-row-highlight">
                        <td><strong>4-5Y</strong></td>
                        <td>4 – 5 yrs</td>
                        <td>104 – 110</td>
                        <td>57 – 60</td>
                        <td>53 – 55</td>
                    </tr>
                    <tr>
                        <td><strong>5-6Y</strong></td>
                        <td>5 – 6 yrs</td>
                        <td>110 – 116</td>
                        <td>60 – 63</td>
                        <td>55 – 57</td>
                    </tr>
                    <tr>
                        <td><strong>6-7Y</strong></td>
                        <td>6 – 7 yrs</td>
                        <td>116 – 122</td>
                        <td>63 – 66</td>
                        <td>57 – 59</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tip -->
        <div class="sg-tip">
            <span class="sg-tip-icon">💡</span>
            <span>If your child is between sizes, we recommend choosing the <strong>larger size</strong> for a comfortable fit.</span>
        </div>

        <!-- How to Measure -->
        <div class="sg-measure">
            <h4 class="sg-measure-title">How to Measure</h4>
            <ul class="sg-measure-list">
                <li><strong>Height:</strong> Measure from head to heel while standing straight.</li>
                <li><strong>Chest:</strong> Measure around the fullest part of the chest.</li>
                <li><strong>Waist:</strong> Measure around the natural waistline.</li>
            </ul>
        </div>
    </div>


    {{-- Testimonials Section --}}
    @include('partials.testimonials')
    
    <!-- ════════════════════════════════
         You May Also Like Section
    ════════════════════════════════ -->
    <section class="yal-section">

        <div class="yal-heading">
            <span class="yal-line"></span>
            <h2>You may also like</h2>
            <span class="yal-line"></span>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="yal-grid">

            @foreach($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->id) }}" class="yal-card">
                <div class="yal-img-wrap">
                    <img src="{{ asset($relatedProduct->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $relatedProduct->name }}">
                </div>
                <div class="yal-info">
                    <p class="yal-name">{{ $relatedProduct->name }}</p>
                    <div class="yal-price">
                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                            <span class="yal-old">Rs. {{ number_format($relatedProduct->price, 0) }}</span>
                            <span class="yal-new">Rs. {{ number_format($relatedProduct->sale_price, 0) }}</span>
                        @else
                            <span class="yal-new">Rs. {{ number_format($relatedProduct->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach

        </div>
        @else
        <div style="text-align: center; padding: 40px 20px; color: #999;">
            <p style="font-size: 15px;">No related products available at the moment.</p>
        </div>
        @endif

    </section>

@include('partials.footer')
