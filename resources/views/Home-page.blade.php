@include('partials.header')

    <!-- Hero Banner Slider -->
    <section class="hero-slider-wrap">
        <div class="hero-slider" id="heroSlider">
            <div class="hero-slide"><img src="{{ asset($heroBanner1) }}" alt="Slide 1"></div>
            <div class="hero-slide"><img src="{{ asset($heroBanner2) }}" alt="Slide 2"></div>
            <div class="hero-slide"><img src="{{ asset($heroBanner3) }}" alt="Slide 3"></div>
        </div>
        <div class="hero-slider-nav">
            <button class="hero-prev" id="heroPrev">&#10094;</button>
            <button class="hero-next" id="heroNext">&#10095;</button>
        </div>
        <div class="hero-dots" id="heroDots">
            <span class="hero-dot active" data-index="0"></span>
            <span class="hero-dot" data-index="1"></span>
            <span class="hero-dot" data-index="2"></span>
        </div>
    </section>

    <style>
        .hero-slider-wrap {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: #f0f0f0;
        }
        .hero-slider {
            display: flex;
            width: 300%; /* 3 slides */
            transition: transform 0.5s ease-in-out;
            align-items: stretch;
        }
        .hero-slide {
            width: 33.3333%; /* 100% / 3 */
            display: flex;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        /* Navigation Arrows */
        .hero-slider-nav button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.6);
            border: none;
            color: #333;
            padding: 10px 15px;
            font-size: 24px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
            transition: background 0.3s;
        }
        .hero-slider-nav button:hover {
            background: rgba(255,255,255,0.9);
        }
        .hero-prev { left: 20px; }
        .hero-next { right: 20px; }
        
        /* Dots */
        .hero-dots {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            z-index: 10;
        }
        .hero-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }
        .hero-dot.active {
            background: #fff;
            transform: scale(1.2);
        }

        @media (max-width: 768px) {
            .hero-slider-nav button {
                padding: 5px 10px;
                font-size: 18px;
            }
            .hero-prev { left: 10px; }
            .hero-next { right: 10px; }
            .hero-dots { bottom: 10px; }
            .hero-dot { width: 8px; height: 8px; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('heroSlider');
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            const prevBtn = document.getElementById('heroPrev');
            const nextBtn = document.getElementById('heroNext');
            
            let currentSlide = 0;
            const totalSlides = slides.length;
            let autoSlideInterval;

            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * (100 / totalSlides)}%)`;
                dots.forEach(dot => dot.classList.remove('active'));
                dots[currentSlide].classList.add('active');
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            function resetInterval() {
                clearInterval(autoSlideInterval);
                autoSlideInterval = setInterval(nextSlide, 5000);
            }

            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetInterval();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetInterval();
            });

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlider();
                    resetInterval();
                });
            });

            // Start auto slide
            autoSlideInterval = setInterval(nextSlide, 5000);
        });
    </script>

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
         Pre-Featured Banner Section
    ════════════════════════════════ -->
    <section class="cta-section" style="margin-bottom: 40px;">
        <img src="{{ asset($preFeaturedBanner ?? 'images/img-home/home-cta.jpg') }}" alt="{{ $preFeaturedTitle ?? 'Summer Sale' }}" class="cta-bg-img">
        <div class="cta-overlay"></div>
        <div class="cta-content">
            <h2 class="cta-title">{{ $preFeaturedTitle ?? 'Summer Sale' }}</h2>
            <p class="cta-subtitle">{{ $preFeaturedSubtitle ?? 'Up to 50% Off on Kids Collection' }}</p>
            <a href="{{ $preFeaturedBtnLink ?? route('categories.index') }}" class="cta-btn">{{ $preFeaturedBtnText ?? 'Shop Now' }}</a>
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
                <div class="fp-card-img-wrap" style="position: relative;">
                    @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                    @endif
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
                <div class="fp-card-img-wrap" style="position: relative;">
                    @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                    @endif
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
                <div class="fp-card-img-wrap" style="position: relative;">
                    @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                    @endif
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
                <div class="fp-card-img-wrap" style="position: relative;">
                    @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                    @endif
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
                        <div class="na-card-img-wrap" style="position: relative;">
                            @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                                <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                            @endif
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
                    <div class="na-card-img-wrap" style="position: relative;">
                        @if(isset($product->stock_quantity) && $product->stock_quantity <= 0)
                            <div style="position: absolute; top: 10px; left: 10px; background: rgba(220, 53, 69, 0.9); color: white; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Out of Stock</div>
                        @endif
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
        <img src="{{ asset($ctaBanner ?? 'images/img-home/home-cta.jpg') }}" alt="{{ $ctaTitle ?? 'Summer Sale' }}" class="cta-bg-img">
        <div class="cta-overlay"></div>
        <div class="cta-content">
            <h2 class="cta-title">{{ $ctaTitle ?? 'Summer Sale' }}</h2>
            <p class="cta-subtitle">{{ $ctaSubtitle ?? 'Up to 50% Off on Kids Collection' }}</p>
            <a href="{{ $ctaBtnLink ?? route('categories.index') }}" class="cta-btn" id="cta-shop-now">{{ $ctaBtnText ?? 'Shop Now' }}</a>
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
                    <p class="feat-desc">Free delivery for all orders over Rs 3000</p>
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
                    <p class="feat-desc">We return money within 7 days</p>
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
            if(rvDots[index]) {
                rvDots[index].classList.add('rv-dot--active');
            }
            
            // Hide all cards
            rvCards.forEach(card => card.style.display = 'none');
            
            // Show cards based on screen size
            if (window.innerWidth <= 768) {
                // Mobile: show 1 card at a time based on index
                // Since there are only 3 dots, we can loop back or just map dot 0 -> card 0, dot 1 -> card 1...
                // Actually it's better to show 1 card per dot
                if(rvCards[index]) {
                    rvCards[index].style.display = 'block';
                }
            } else {
                // Desktop: show 3 cards per slide
                let start = index * 3;
                for(let i = 0; i < 3; i++) {
                    if (rvCards[start + i]) {
                        rvCards[start + i].style.display = 'block';
                    }
                }
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
