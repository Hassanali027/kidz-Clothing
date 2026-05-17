<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Kidz Wear - Premium Kids Clothing Collection. Shop the latest trends for your little ones.' }}">
    <title>{{ $pageTitle ?? 'Kidz Wear - Kids Clothing Store' }}</title>
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
            <img src="{{ asset('images/img-home/logo.svg') }}" alt="Kidz Wear Logo">
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
                <a href="{{ route('categories.index') }}" class="mob-menu-link">Mid Summer Sale</a>
            </li>
            <li class="mob-menu-item mob-has-sub">
                <button class="mob-menu-link mob-toggle" id="mob-clothing-toggle">
                    Clothing
                    <span class="mob-arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </span>
                </button>
                <ul class="mob-submenu" id="mob-clothing-sub">
                    <li><a href="{{ route('categories.index') }}">Tops &amp; Shirts</a></li>
                    <li><a href="{{ route('categories.index') }}">Bottoms</a></li>
                    <li><a href="{{ route('categories.index') }}">Dresses</a></li>
                    <li><a href="{{ route('categories.index') }}">Jackets &amp; Coats</a></li>
                    <li><a href="{{ route('categories.index') }}">Sleepwear</a></li>
                    <li><a href="{{ route('categories.index') }}">Swimwear</a></li>
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
                    <li><a href="{{ route('categories.index') }}">Hats &amp; Caps</a></li>
                    <li><a href="{{ route('categories.index') }}">Bags &amp; Backpacks</a></li>
                    <li><a href="{{ route('categories.index') }}">Shoes</a></li>
                    <li><a href="{{ route('categories.index') }}">Socks</a></li>
                </ul>
            </li>
        </ul>

    </div>
