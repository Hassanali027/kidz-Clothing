<!-- ════════════════════════════════
     Reviews / Testimonials Section
════════════════════════════════ -->
@php
    $testimonialsQuery = \App\Models\Testimonial::where('is_active', true);

    if (isset($product)) {
        $testimonials = $testimonialsQuery->where('product_id', $product->id)
            ->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        $submittedReviews = \App\Models\ProductReview::where('product_id', $product->id)
            ->where('status', 'approved')->with('user')->latest()->get()
            ->map(function ($review) {
                return (object) [
                    'name' => $review->user ? $review->user->name : 'Customer',
                    'review_text' => $review->review_text,
                    'rating' => $review->rating,
                ];
            });
        $testimonials = $testimonials->concat($submittedReviews);
    } else {
        $testimonials = $testimonialsQuery->whereNull('product_id')
            ->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
    }

    /* $testimonials is either assigned product reviews or home-page reviews. */
    /* keep this query result as a collection for the existing card markup */
    $testimonials = $testimonials
        ->values();
@endphp

@if($testimonials->isNotEmpty())
    <section class="rv-section">
        <div class="rv-heading">
            <span class="rv-line"></span>
            <h2>Trusted by Parents, Loved by Kids</h2>
            <span class="rv-line"></span>
        </div>

        <div class="rv-grid" id="rv-grid">
            @foreach($testimonials as $testimonial)
                <div class="rv-card">
                    <div class="rv-stars">
                        @for($star = 1; $star <= $testimonial->rating; $star++)
                            <span>&#9733;</span>
                        @endfor
                    </div>
                    <div class="rv-author">
                        <span class="rv-name">{{ $testimonial->name }}</span>
                        <span class="rv-verified">&#10004;</span>
                    </div>
                    <p class="rv-text">{{ $testimonial->review_text }}</p>
                </div>
            @endforeach
        </div>

        <div class="rv-dots" id="rv-dots"></div>
    </section>

    <script>
        (function () {
            var section = document.querySelector('.rv-section');
            if (!section) return;

            var cards = Array.prototype.slice.call(section.querySelectorAll('.rv-card'));
            var dotsContainer = section.querySelector('#rv-dots');
            var currentPage = 0;

            function pageSize() {
                return window.innerWidth <= 768 ? 1 : 6;
            }

            function render(page) {
                var size = pageSize();
                var pages = Math.max(1, Math.ceil(cards.length / size));
                currentPage = Math.min(page, pages - 1);

                cards.forEach(function (card, index) {
                    card.style.display = index >= currentPage * size && index < (currentPage + 1) * size ? 'block' : 'none';
                });

                dotsContainer.innerHTML = '';
                for (var dotIndex = 0; dotIndex < pages; dotIndex++) {
                    var dot = document.createElement('span');
                    dot.className = 'rv-dot' + (dotIndex === currentPage ? ' rv-dot--active' : '');
                    dot.addEventListener('click', (function (selectedPage) {
                        return function () { render(selectedPage); };
                    })(dotIndex));
                    dotsContainer.appendChild(dot);
                }
            }

            render(0);
            window.addEventListener('resize', function () { render(currentPage); });
        })();
    </script>
@endif
