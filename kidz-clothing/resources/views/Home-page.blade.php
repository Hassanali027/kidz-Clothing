@include('partials.header')

    <!-- Hero Banner -->
    <section class="hero-banner">
        <img
            src="{{ asset($heroBanner ?? 'images/img-home/hero-banner.jpg') }}"
            alt="Kidz Wear - Happy Halloween Kids Collection"
        >
    </section>

    <!-- Shop by Category Section -->
    <section class="category-section">
        <div class="category-heading">
            <span class="heading-line"></span>
            <h2>Shop by Category</h2>
            <span class="heading-line"></span>
        </div>

        <div class="category-grid">

            @php
                // Get categories from database
                $categories = \App\Models\Category::where('status', 'active')->orderBy('order', 'asc')->get();
                
                // Map category names to their data
                $categoryMap = [
                    'boys' => ['name' => 'Boys Wear', 'key' => 'boys'],
                    'girls' => ['name' => 'Girls Wear', 'key' => 'girls'],
                    'baby' => ['name' => 'Baby Clothing', 'key' => 'baby'],
                    'party' => ['name' => 'Party Wear', 'key' => 'party'],
                ];
            @endphp

            @foreach($categoryMap as $key => $catData)
                @php
                    // Find matching category from database
                    $currentKey = $key;
                    $dbCategory = $categories->first(function($cat) use ($catData, $currentKey) {
                        return stripos($cat->name, $catData['name']) !== false || 
                               stripos($cat->name, $currentKey) !== false;
                    });
                    
                    // Use database category slug or fallback to key
                    $categorySlug = $dbCategory ? $dbCategory->slug : $key . '-wear';
                @endphp
                
                <a href="{{ route('categories.show', $categorySlug) }}" class="category-card" id="cat-{{ $key }}">
                    @if(isset($shopByCategory[$key]) && $shopByCategory[$key]->isNotEmpty())
                        <img src="{{ asset($shopByCategory[$key]->first()->images[0] ?? $categoryImages[$key]) }}" alt="{{ $catData['name'] }}">
                    @else
                        <img src="{{ asset($categoryImages[$key]) }}" alt="{{ $catData['name'] }}">
                    @endif
                    <div class="category-label">
                        <span>{{ $catData['name'] }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </section>

    <!-- ════════════════════════════════
         Featured Products Section
    ════════════════════════════════ -->
    <section class="fp-section">

        <div class="fp-heading">
            <span class="fp-line"></span>
            <h2>Featured Products</h2>
            <span class="fp-line"></span>
        </div>

        <!-- Tabs -->
        <div class="fp-tabs">
            <button class="fp-tab fp-tab--active" data-tab="fp-baby">Baby</button>
            <button class="fp-tab" data-tab="fp-girls">Girls</button>
            <button class="fp-tab" data-tab="fp-boys">Boys</button>
            <button class="fp-tab" data-tab="fp-party">Party</button>
        </div>

        <!-- Baby Tab -->
        <div class="fp-grid fp-tab-content fp-tab-content--active" id="fp-baby">
            @forelse($featuredProducts->filter(fn($p) => stripos($p->category, 'baby') !== false)->take(6) as $product)
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="fp-card">
                <div class="fp-card-img-wrap">
                    <img src="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="fp-card-info">
                    <p class="fp-card-name">{{ $product->name }}</p>
                    <div class="fp-card-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="fp-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="fp-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            <span class="fp-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                <p>No baby products available</p>
            </div>
            @endforelse
        </div>

        <!-- Girls Tab -->
        <div class="fp-grid fp-tab-content" id="fp-girls">
            @forelse($featuredProducts->filter(fn($p) => stripos($p->category, 'girls') !== false)->take(6) as $product)
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="fp-card">
                <div class="fp-card-img-wrap">
                    <img src="{{ asset($product->images[0] ?? 'images/img-home/girls-wear.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="fp-card-info">
                    <p class="fp-card-name">{{ $product->name }}</p>
                    <div class="fp-card-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="fp-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="fp-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            <span class="fp-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                <p>No girls products available</p>
            </div>
            @endforelse
        </div>

        <!-- Boys Tab -->
        <div class="fp-grid fp-tab-content" id="fp-boys">
            @forelse($featuredProducts->filter(fn($p) => stripos($p->category, 'boys') !== false)->take(6) as $product)
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="fp-card">
                <div class="fp-card-img-wrap">
                    <img src="{{ asset($product->images[0] ?? 'images/img-home/boys-wear.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="fp-card-info">
                    <p class="fp-card-name">{{ $product->name }}</p>
                    <div class="fp-card-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="fp-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="fp-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            <span class="fp-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                <p>No boys products available</p>
            </div>
            @endforelse
        </div>

        <!-- Party Tab -->
        <div class="fp-grid fp-tab-content" id="fp-party">
            @forelse($featuredProducts->filter(fn($p) => stripos($p->category, 'party') !== false)->take(6) as $product)
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="fp-card">
                <div class="fp-card-img-wrap">
                    <img src="{{ asset($product->images[0] ?? 'images/img-home/partywear.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="fp-card-info">
                    <p class="fp-card-name">{{ $product->name }}</p>
                    <div class="fp-card-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="fp-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="fp-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            <span class="fp-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                <p>No party wear products available</p>
            </div>
            @endforelse
        </div>

    </section>

    <!-- ════════════════════════════════
         New Arrivals Section
    ════════════════════════════════ -->
    <section class="na-section">
        <div class="na-inner">

            <!-- Left Promo Card -->
            <a href="{{ route('products.index') }}" class="na-promo" style="text-decoration:none;">
                <div class="na-promo-img">
                    <img src="{{ asset('images/img-home/boys-wear.jpg') }}" alt="New Arrivals">
                </div>
                <div class="na-promo-text">
                    <h3 class="na-promo-title">New Arrivals</h3>
                    <p class="na-promo-desc">Discover our latest stylish kidswear.</p>
                    <span class="na-promo-btn">Shop Now</span>
                </div>
            </a>

            <!-- Right Product Cards (Desktop - 3 cards) -->
            <div class="na-right">
                <div class="na-right-header">
                    <a href="{{ route('categories.index') }}" class="na-view-all">View All</a>
                </div>
                <div class="na-grid">
                    @forelse($newArrivals->take(3) as $product)
                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="na-card">
                        <div class="na-badge">New</div>
                        <div class="na-card-img-wrap">
                            <img src="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $product->name }}">
                        </div>
                        <p class="na-card-name">{{ $product->name }}</p>
                        <div class="na-card-price">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="na-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                                <span class="na-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                            @else
                                <span class="na-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                        <p>No new arrivals available</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Mobile Only Section (4 cards in 2x2 grid) -->
        <div class="na-mobile-section">
            <div class="na-mobile-heading">
                <h3>New Arrivals</h3>
            </div>
            
            <div class="na-mobile-grid">
                @forelse($newArrivals->take(4) as $product)
                <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="na-card">
                    <div class="na-badge">New</div>
                    <div class="na-card-img-wrap">
                        <img src="{{ asset($product->images[0] ?? 'images/img-home/baby-wear.jpg') }}" alt="{{ $product->name }}">
                    </div>
                    <p class="na-card-name">{{ $product->name }}</p>
                    <div class="na-card-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="na-old-price">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="na-new-price">Rs. {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            <span class="na-new-price">Rs. {{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </a>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                    <p>No new arrivals available</p>
                </div>
                @endforelse
            </div>

            <div class="na-mobile-actions">
                <a href="{{ route('products.index') }}" class="na-mobile-btn na-mobile-btn--primary">Shop Now</a>
                <a href="{{ route('categories.index') }}" class="na-mobile-btn na-mobile-btn--secondary">View All</a>
            </div>
        </div>

    </section>

    <!-- Tab Switching Script -->
    <script>
        document.querySelectorAll('.fp-tab').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.fp-tab').forEach(function(t) {
                    t.classList.remove('fp-tab--active');
                });
                document.querySelectorAll('.fp-tab-content').forEach(function(c) {
                    c.classList.remove('fp-tab-content--active');
                });
                btn.classList.add('fp-tab--active');
                var target = btn.getAttribute('data-tab');
                document.getElementById(target).classList.add('fp-tab-content--active');
            });
        });
    </script>

    <!-- ════════════════════════════════
         CTA Banner Section
    ════════════════════════════════ -->
    <section class="cta-section">
        <img src="{{ asset($ctaBanner ?? 'images/img-home/home-cta.jpg') }}" alt="Summer Sale" class="cta-bg-img">
        <div class="cta-overlay"></div>
        <div class="cta-content">
            <h2 class="cta-title">Summer Sale</h2>
            <p class="cta-subtitle">Up to 50% Off on Kids Collection</p>
            <a href="{{ route('categories.index') }}" class="cta-btn" id="cta-shop-now">Shop Now</a>
        </div>
    </section>

    <!-- ════════════════════════════════
         Shop by Age Section
    ════════════════════════════════ -->
    <section class="sba-section">

        <div class="sba-heading">
            <span class="sba-line"></span>
            <h2>Shop by Age</h2>
            <span class="sba-line"></span>
        </div>

        <div class="sba-grid">

            <!-- Left tall card: 0-2 Years -->
            <a href="{{ route('categories.index', ['size' => 'Newborn']) }}" class="sba-card sba-card--tall" id="sba-0-2">
                @if($shopByAge['0-2']->isNotEmpty())
                    <img src="{{ asset($shopByAge['0-2']->first()->images[0] ?? 'images/img-home/0-2year.jpg') }}" alt="0-2 Years">
                @else
                    <img src="{{ asset('images/img-home/0-2year.jpg') }}" alt="0-2 Years">
                @endif
                <div class="sba-label">0–2 Years</div>
            </a>

            <!-- Top right wide card: 2-5 Years -->
            <a href="{{ route('categories.index', ['size' => '2-4Y']) }}" class="sba-card sba-card--wide" id="sba-2-5">
                @if($shopByAge['2-5']->isNotEmpty())
                    <img src="{{ asset($shopByAge['2-5']->first()->images[0] ?? 'images/img-home/2-5year.jpg') }}" alt="2-5 Years">
                @else
                    <img src="{{ asset('images/img-home/2-5year.jpg') }}" alt="2-5 Years">
                @endif
                <div class="sba-label">2–5 Years</div>
            </a>

            <!-- Bottom right left: 5-8 Years -->
            <a href="{{ route('categories.index', ['size' => '6-8Y']) }}" class="sba-card" id="sba-5-8">
                @if($shopByAge['5-8']->isNotEmpty())
                    <img src="{{ asset($shopByAge['5-8']->first()->images[0] ?? 'images/img-home/5-8year.jpg') }}" alt="5-8 Years">
                @else
                    <img src="{{ asset('images/img-home/5-8year.jpg') }}" alt="5-8 Years">
                @endif
                <div class="sba-label">5–8 Years</div>
            </a>

            <!-- Bottom right right: 8-14 Years -->
            <a href="{{ route('categories.index', ['size' => '8-10Y']) }}" class="sba-card" id="sba-8-14">
                @if($shopByAge['8-14']->isNotEmpty())
                    <img src="{{ asset($shopByAge['8-14']->first()->images[0] ?? 'images/img-home/8-14year.jpg') }}" alt="8-14 Years">
                @else
                    <img src="{{ asset('images/img-home/8-14year.jpg') }}" alt="8-14 Years">
                @endif
                <div class="sba-label">8–14 Years</div>
            </a>

        </div>

    </section>

    {{-- Testimonials Section --}}
    @include('partials.testimonials')

    <!-- ════════════════════════════════
         Style Tips for Little Ones
    ════════════════════════════════ -->
    <section class="st-section">

        <div class="st-heading">
            <span class="st-line"></span>
            <h2>Style Tips for Little Ones</h2>
            <span class="st-line"></span>
        </div>

        <div class="st-grid">
            @forelse($homeBlogs as $index => $blog)
            <article class="st-card" id="st-card-{{ $index + 1 }}">
                <a href="{{ route('blog.post', $blog->slug) }}" class="st-card-img-wrap">
                    @if($blog->thumbnail)
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}">
                    @else
                        <img src="{{ asset('images/img-home/8-14year.jpg') }}" alt="{{ $blog->title }}">
                    @endif
                </a>
                <div class="st-card-body">
                    <h3 class="st-card-title"><a href="{{ route('blog.post', $blog->slug) }}">{{ $blog->title }}</a></h3>
                    <p class="st-card-desc">{{ Str::limit(strip_tags($blog->description), 150) }}</p>
                    <div class="st-card-meta">
                        <span class="st-author">{{ $blog->author }}</span>
                        <span class="st-divider">|</span>
                        <span class="st-date">{{ $blog->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </article>
            @empty
            <article class="st-card" style="grid-column: 1 / -1;">
                <div style="padding: 40px; text-align: center; color: #999; background: #f9f9f9; border-radius: 8px;">No featured style tips at the moment.</div>
            </article>
            @endforelse
        </div>

        <div class="st-btn-wrap">
            <a href="{{ route('blog') }}" class="st-read-all" id="st-read-all-btn">Read All</a>
        </div>

    </section>

    <!-- ════════════════════════════════
         Features / Benefits Strip
    ════════════════════════════════ -->
    <section class="feat-section">
        <div class="feat-inner">

            <div class="feat-item" id="feat-delivery">
                <div class="feat-icon-wrap">
                    <img src="{{ asset('images/img-home/fast-delivery.svg') }}" alt="Free Delivery">
                </div>
                <div class="feat-text">
                    <h4 class="feat-title">FREE AND FAST DELIVERY</h4>
                    <p class="feat-desc">Free delivery for all orders over Rs 2000</p>
                </div>
            </div>

            <div class="feat-item" id="feat-support">
                <div class="feat-icon-wrap">
                    <img src="{{ asset('images/img-home/247.svg') }}" alt="24/7 Customer Service">
                </div>
                <div class="feat-text">
                    <h4 class="feat-title">24/7 CUSTOMER SERVICE</h4>
                    <p class="feat-desc">Friendly 24/7 customer support</p>
                </div>
            </div>

            <div class="feat-item" id="feat-moneyback">
                <div class="feat-icon-wrap">
                    <img src="{{ asset('images/img-home/money-back.svg') }}" alt="Money Back Guarantee">
                </div>
                <div class="feat-text">
                    <h4 class="feat-title">MONEY BACK GUARANTEE</h4>
                    <p class="feat-desc">We return money within 30 days</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Testimonials Slider Script -->
    <script>
        // Testimonials Slider
        const rvGrid = document.getElementById('rv-grid');
        const rvDots = document.querySelectorAll('.rv-dot');
        const rvCards = document.querySelectorAll('.rv-card');
        let currentSlide = 0;

        // Function to show specific slide
        function showSlide(index) {
            // Remove active class from all dots
            rvDots.forEach(dot => dot.classList.remove('rv-dot--active'));
            
            // Add active class to current dot
            rvDots[index].classList.add('rv-dot--active');
            
            // Hide all cards
            rvCards.forEach(card => card.style.display = 'none');
            
            // Show cards based on screen size
            if (window.innerWidth <= 768) {
                // Mobile: show 1 card
                rvCards[index].style.display = 'block';
            } else {
                // Desktop: show 3 cards (all)
                rvCards.forEach(card => card.style.display = 'block');
            }
            
            currentSlide = index;
        }

        // Add click event to dots
        rvDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
            });
        });

        // Auto slide every 5 seconds
        setInterval(() => {
            currentSlide = (currentSlide + 1) % rvDots.length;
            showSlide(currentSlide);
        }, 5000);

        // Initialize first slide
        showSlide(0);

        // Handle window resize
        window.addEventListener('resize', () => {
            showSlide(currentSlide);
        });
    </script>

@include('partials.footer')
