<!-- ════════════════════════════════
     Reviews / Testimonials Section
════════════════════════════════ -->
@php
    $testimonials = \App\Models\Testimonial::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('created_at', 'desc')
        ->get();
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
