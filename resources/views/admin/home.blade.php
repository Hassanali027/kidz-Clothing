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
            <h2>Home Page SEO Settings</h2>
        </div>
        <form action="{{ route('admin.settings.updateSeo') }}" method="POST" class="admin-form">
            @csrf
            <input type="hidden" name="page" value="home">
            
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="seo_title" class="form-control" value="{{ $seoTitle }}" required>
                <small style="color: #666; font-size: 13px;">This appears in the browser tab and search engine results.</small>
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="seo_description" class="form-control" rows="3" required>{{ $seoDescription }}</textarea>
                <small style="color: #666; font-size: 13px;">A brief description of your site for search engines (max 160 characters recommended).</small>
            </div>
            
            <button type="submit" class="btn-primary">Save SEO Settings</button>
        </form>
    </div>

    <div class="content-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h2>Hero Banners (Slider)</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <!-- Banner 1 -->
            <form action="{{ route('admin.home.updateBanner') }}" method="POST" enctype="multipart/form-data" class="admin-form" style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                @csrf
                <input type="hidden" name="banner_type" value="hero_1">
                <h3 style="margin-bottom: 10px; font-size: 16px;">Slide 1</h3>
                <div class="form-group" style="margin-bottom: 10px;">
                    <img src="{{ asset($heroBanner1) }}?v={{ time() }}" alt="Slide 1" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <input type="file" name="banner_image" class="form-control" accept="image/*" required style="font-size: 13px; padding: 6px;">
                </div>
                <button type="submit" class="btn-primary" style="padding: 8px 12px; font-size: 13px;">Update Slide 1</button>
            </form>

            <!-- Banner 2 -->
            <form action="{{ route('admin.home.updateBanner') }}" method="POST" enctype="multipart/form-data" class="admin-form" style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                @csrf
                <input type="hidden" name="banner_type" value="hero_2">
                <h3 style="margin-bottom: 10px; font-size: 16px;">Slide 2</h3>
                <div class="form-group" style="margin-bottom: 10px;">
                    <img src="{{ asset($heroBanner2) }}?v={{ time() }}" alt="Slide 2" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <input type="file" name="banner_image" class="form-control" accept="image/*" required style="font-size: 13px; padding: 6px;">
                </div>
                <button type="submit" class="btn-primary" style="padding: 8px 12px; font-size: 13px;">Update Slide 2</button>
            </form>

            <!-- Banner 3 -->
            <form action="{{ route('admin.home.updateBanner') }}" method="POST" enctype="multipart/form-data" class="admin-form" style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                @csrf
                <input type="hidden" name="banner_type" value="hero_3">
                <h3 style="margin-bottom: 10px; font-size: 16px;">Slide 3</h3>
                <div class="form-group" style="margin-bottom: 10px;">
                    <img src="{{ asset($heroBanner3) }}?v={{ time() }}" alt="Slide 3" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <input type="file" name="banner_image" class="form-control" accept="image/*" required style="font-size: 13px; padding: 6px;">
                </div>
                <button type="submit" class="btn-primary" style="padding: 8px 12px; font-size: 13px;">Update Slide 3</button>
            </form>
        </div>
        <div style="margin-top: 15px; padding-left: 5px;">
            <small style="color: #666; font-size: 13px;">Recommended size for all slides: 1920x600px (JPG, PNG, GIF, WEBP - Max 5MB)</small>
        </div>
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

    <div class="content-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h2>Social Media Links</h2>
        </div>
        <form action="{{ route('admin.settings.updateSocial') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Twitter URL</label>
                <input type="url" name="social_twitter" class="form-control" value="{{ $socialTwitter == '#' ? '' : $socialTwitter }}" placeholder="https://twitter.com/yourpage">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Facebook URL</label>
                <input type="url" name="social_facebook" class="form-control" value="{{ $socialFacebook == '#' ? '' : $socialFacebook }}" placeholder="https://facebook.com/yourpage">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Instagram URL</label>
                <input type="url" name="social_instagram" class="form-control" value="{{ $socialInstagram == '#' ? '' : $socialInstagram }}" placeholder="https://instagram.com/yourpage">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label>TikTok URL</label>
                <input type="url" name="social_tiktok" class="form-control" value="{{ $socialTiktok == '#' ? '' : $socialTiktok }}" placeholder="https://tiktok.com/@yourpage">
            </div>
            
            <button type="submit" class="btn-primary">Save Social Links</button>
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
