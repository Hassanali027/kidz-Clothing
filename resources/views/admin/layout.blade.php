<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Admin Panel' }} | Kidz Wear</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/img-home/Kids-wear-fav.webp') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Kidz<span>Wear</span></h2>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.home') }}" class="menu-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Home Page</span>
                    </a>
                </li>
                <li class="menu-item has-dropdown">
                    <a href="#" class="menu-link {{ request()->routeIs('admin.category*') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Category</span>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('admin.category.add') }}" class="dropdown-link {{ request()->routeIs('admin.category.add') ? 'active' : '' }}">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Category</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.category') }}" class="dropdown-link {{ request()->routeIs('admin.category') ? 'active' : '' }}">
                                <i class="fa-solid fa-list"></i>
                                <span>View Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item has-dropdown">
                    <a href="#" class="menu-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box"></i>
                        <span>Products</span>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('admin.products.add') }}" class="dropdown-link {{ request()->routeIs('admin.products.add') ? 'active' : '' }}">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Product</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products') }}" class="dropdown-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                <i class="fa-solid fa-list"></i>
                                <span>View Products</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.orders') }}" class="menu-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.coupons') }}" class="menu-link {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket"></i>
                        <span>Coupon Codes</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.testimonials') }}" class="menu-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star"></i>
                        <span>Customer Reviews</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.blogs') }}" class="menu-link {{ request()->routeIs('admin.blogs') ? 'active' : '' }}">
                        <i class="fa-solid fa-blog"></i>
                        <span>Blogs Section</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.users') }}" class="menu-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.settings') }}" class="menu-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i>
                        <span>Site Setting</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.password') }}" class="menu-link {{ request()->routeIs('admin.password') ? 'active' : '' }}">
                        <i class="fa-solid fa-lock"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn" style="width: 100%; background: none; border: none; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-title">
                    <h1>@yield('header_title', 'Dashboard')</h1>
                </div>
                <div class="header-user">
                    <span>Admin</span>
                    <div class="user-avatar">A</div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Dropdown menu functionality
        document.querySelectorAll('.has-dropdown > .menu-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const menuItem = this.parentElement;
                const isOpen = menuItem.classList.contains('open');
                
                // Close all other dropdowns
                document.querySelectorAll('.has-dropdown').forEach(item => {
                    item.classList.remove('open');
                });
                
                // Toggle current dropdown
                if (!isOpen) {
                    menuItem.classList.add('open');
                }
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.has-dropdown')) {
                document.querySelectorAll('.has-dropdown').forEach(item => {
                    item.classList.remove('open');
                });
            }
        });
    </script>

</body>
</html>
