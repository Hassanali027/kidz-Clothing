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

        <div class="rv-dots">
            <span class="rv-dot rv-dot--active"></span>
            <span class="rv-dot"></span>
            <span class="rv-dot"></span>
        </div>
    </section>
@endif
