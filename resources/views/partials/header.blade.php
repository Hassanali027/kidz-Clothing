<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Kidz Wear - Premium Kids Clothing Collection. Shop the latest trends for your little ones.' }}">
    <title>{{ $pageTitle ?? 'Kidz Wear - Kids Clothing Store' }}</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/img-home/Kids-wear-fav.webp') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        Free Delivery on Orders Above Rs. 3000 ✨
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="hamburger">&#9776;</div>

        <a href="{{ route('home') }}" class="navbar-logo">
            <img src="{{ asset('images/img-home/logo.png') }}" alt="Kidz Wear Logo">
        </a>

      

        <div class="navbar-icons">
            <a href="#" title="Search" id="nav-search">
                <img src="{{ asset('images/img-home/search.svg') }}" alt="Search">
            </a>
            <a href="{{ route('cart') }}" title="Cart" id="nav-cart">
                <img src="{{ asset('images/img-home/shopping-cart.svg') }}" alt="Cart">
            </a>
            <a href="{{ route('login') }}" title="My Account" id="nav-profile">
                <img src="{{ asset('images/img-home/profile.svg') }}" alt="Profile">
            </a>
        </div>
    </nav>

    <!-- Global Slide-Down Search Bar -->
    <div class="search-overlay" id="search-overlay">
        <div class="search-container">
            <div class="search-input-wrap">
                <img src="{{ asset('images/img-home/search.svg') }}" alt="Search" class="search-icon">
                <input type="text" id="global-search-input" placeholder="Search for products, categories, or collections..." autocomplete="off">
                <button class="search-close-btn" id="search-close-btn" aria-label="Close search">&times;</button>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════
         Mobile Drawer
    ════════════════════════════════ -->
    <!-- Overlay -->
    <div class="mob-overlay" id="mob-overlay"></div>

    <!-- Drawer -->
    <div class="mob-drawer" id="mob-drawer">

        <!-- Close button -->
        <button class="mob-close" id="mob-close" aria-label="Close menu">&#x2715;</button>

        <!-- Logo -->
        <div class="mob-logo-wrap">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/img-home/logo.svg') }}" alt="Kidz Wear" class="mob-logo">
            </a>
        </div>

        <!-- Horizontal category links -->
        <div class="mob-cats">
            <a href="{{ route('categories.show', 'boys-wear') }}" class="mob-cat">Boys</a>
            <a href="{{ route('categories.show', 'girls-wear') }}" class="mob-cat">Girls</a>
            <a href="{{ route('categories.show', 'baby-wear') }}" class="mob-cat">Babies</a>
            <a href="{{ route('categories.show', 'party-wear') }}" class="mob-cat">Party Wear</a>
            <a href="{{ route('categories.index') }}" class="mob-cat">Clearance</a>
        </div>

        <div class="mob-divider"></div>

        <!-- Expandable menu items -->
        <ul class="mob-menu">
            <li class="mob-menu-item">
                <a href="{{ route('about') }}" class="mob-menu-link">About Us</a>
            </li>
            <li class="mob-menu-item">
                <a href="{{ route('faqs') }}" class="mob-menu-link">FAQs</a>
            </li>
            <li class="mob-menu-item">
                <a href="{{ route('contact') }}" class="mob-menu-link">Contact Us</a>
            </li>
            <li class="mob-menu-item">
                <a href="{{ route('categories.index') }}" class="mob-menu-link"> Sale</a>
            </li>
            <li class="mob-menu-item mob-has-sub">
                <button class="mob-menu-link mob-toggle" id="mob-clothing-toggle">
                    Product Type
                    <span class="mob-arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </span>
                </button>
                <ul class="mob-submenu" id="mob-clothing-sub">
                    @foreach(($mobileProductTypes ?? collect()) as $productType)
                        <li><a href="{{ route('categories.index', ['product_type' => $productType]) }}">{{ $productType }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="mob-menu-item mob-has-sub">
                <button class="mob-menu-link mob-toggle" id="mob-acc-toggle">
                    Accessories
                    <span class="mob-arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </span>
                </button>
                <ul class="mob-submenu" id="mob-acc-sub">
                    <li>
                        <a href="{{ isset($accessoriesCategory) && $accessoriesCategory ? route('categories.show', $accessoriesCategory->slug) : route('categories.index') }}">
                            All Accessories
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>

    <!-- Global Search JavaScript Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchIcon = document.getElementById('nav-search');
            var searchOverlay = document.getElementById('search-overlay');
            var searchClose = document.getElementById('search-close-btn');
            var searchInput = document.getElementById('global-search-input');
            
            if (searchIcon && searchOverlay && searchClose && searchInput) {
                // Open search overlay
                searchIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchOverlay.classList.add('search-overlay--open');
                    setTimeout(function() {
                        searchInput.focus();
                    }, 200);
                });
                
                // Close search overlay
                searchClose.addEventListener('click', function() {
                    searchOverlay.classList.remove('search-overlay--open');
                    searchInput.value = '';
                    // If on category page, trigger filter update to reset product list
                    if (typeof applyFiltersAndSort === 'function') {
                        applyFiltersAndSort();
                    }
                });
                
                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && searchOverlay.classList.contains('search-overlay--open')) {
                        searchClose.click();
                    }
                });
                
                // Real-time search matching (for instant filtering on Category/Category Slug pages)
                searchInput.addEventListener('input', function() {
                    if (typeof applyFiltersAndSort === 'function') {
                        applyFiltersAndSort();
                    }
                });

                // On enter key, if not on Category Page, redirect to Category Page with search query parameter
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        var query = this.value.trim();
                        if (query && typeof applyFiltersAndSort !== 'function') {
                            window.location.href = "{{ route('categories.index') }}?search=" + encodeURIComponent(query);
                        }
                    }
                });
            }
        });
    </script>
