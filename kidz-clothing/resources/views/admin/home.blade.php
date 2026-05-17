@extends('admin.layout')

@section('header_title', 'Home Page Content')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            ✗ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Validation Errors:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h2>Hero Banner</h2>
        </div>
        <form action="{{ route('admin.home.updateBanner') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            <input type="hidden" name="banner_type" value="hero">
            
            <div class="form-group">
                <label>Current Banner</label>
                <div style="margin-bottom: 15px;">
                    <img src="{{ asset($heroBanner) }}?v={{ time() }}" alt="Hero Banner" style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                </div>
            </div>

            <div class="form-group">
                <label>Upload New Banner Image</label>
                <input type="file" name="banner_image" class="form-control" accept="image/*" required>
                <small style="color: #666; font-size: 13px;">Recommended size: 1920x600px (JPG, PNG, GIF, WEBP - Max 5MB)</small>
            </div>
            
            <button type="submit" class="btn-primary">Update Hero Banner</button>
        </form>
    </div>

    <div class="content-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h2>CTA Banner (Summer Sale)</h2>
        </div>
        <form action="{{ route('admin.home.updateBanner') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            <input type="hidden" name="banner_type" value="cta">
            
            <div class="form-group">
                <label>Current Banner</label>
                <div style="margin-bottom: 15px;">
                    <img src="{{ asset($ctaBanner) }}?v={{ time() }}" alt="CTA Banner" style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                </div>
            </div>

            <div class="form-group">
                <label>Upload New Banner Image</label>
                <input type="file" name="banner_image" class="form-control" accept="image/*" required>
                <small style="color: #666; font-size: 13px;">Recommended size: 1920x400px (JPG, PNG, GIF, WEBP - Max 5MB)</small>
            </div>
            
            <button type="submit" class="btn-primary">Update CTA Banner</button>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2>Section Management</h2>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Section Name</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Featured Products</td>
                        <td><span class="status-badge status-success">Active</span></td>
                        <td>1</td>
                        <td><a href="#" style="color: var(--secondary-color);"><i class="fa-solid fa-gear"></i></a></td>
                    </tr>
                    <tr>
                        <td>Shop By Category</td>
                        <td><span class="status-badge status-success">Active</span></td>
                        <td>2</td>
                        <td><a href="#" style="color: var(--secondary-color);"><i class="fa-solid fa-gear"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
