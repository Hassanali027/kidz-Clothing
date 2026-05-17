@extends('admin.layout')

@section('header_title', 'Dashboard')

@section('content')
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Products</h3>
                <div class="value">124</div>
            </div>
            <div class="stat-icon pink">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Active Categories</h3>
                <div class="value">8</div>
            </div>
            <div class="stat-icon blue">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Blogs</h3>
                <div class="value">12</div>
            </div>
            <div class="stat-icon green">
                <i class="fa-solid fa-blog"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Site Settings</h3>
                <div class="value">Updated</div>
            </div>
            <div class="stat-icon orange">
                <i class="fa-solid fa-gear"></i>
            </div>
        </div>
    </div>

    <!-- Recent Activity or Other Info -->
    <div class="content-card">
        <div class="card-header">
            <h2>Welcome to Admin Panel</h2>
        </div>
        <p style="color: var(--text-muted); line-height: 1.6;">
            Manage your website content, products, and categories from here. Use the sidebar to navigate through different sections of your store.
        </p>
    </div>
@endsection
