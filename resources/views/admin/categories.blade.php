@extends('admin.layout')

@section('header_title', 'Categories')

@section('content')
    @if(session('success'))
        <div id="success-message" style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="content-card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h2>Category Page SEO Settings</h2>
        </div>
        <form action="{{ route('admin.settings.updateSeo') }}" method="POST" class="admin-form">
            @csrf
            <input type="hidden" name="page" value="category">
            
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="seo_title" class="form-control" value="{{ $seoTitle }}" required>
                <small style="color: #666; font-size: 13px;">This appears in the browser tab and search engine results for the main Categories/Shop page.</small>
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="seo_description" class="form-control" rows="3" required>{{ $seoDescription }}</textarea>
                <small style="color: #666; font-size: 13px;">A brief description for search engines (max 160 characters recommended).</small>
            </div>
            
            <button type="submit" class="btn-primary">Save SEO Settings</button>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>All Categories</h2>
            <a href="{{ route('admin.category.add') }}" class="btn-primary">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>

        @if($categories->count() > 0)
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th style="width: 100px;">Products</th>
                            <th style="width: 100px;">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr id="category-{{ $category->id }}">
                            <td>
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-image" style="color: #ccc;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $category->name }}</strong>
                                @if($category->description)
                                    <br><small style="color: #666;">{{ Str::limit($category->description, 50) }}</small>
                                @endif
                            </td>
                            <td><code style="background: #f5f5f5; padding: 4px 8px; border-radius: 4px;">{{ $category->slug }}</code></td>
                            <td style="text-align: center;">
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 600;">
                                    {{ $category->products->count() }}
                                </span>
                            </td>
                            <td style="text-align: center;">{{ $category->order }}</td>
                            <td>
                                @if($category->status == 'active')
                                    <span class="status-badge status-success">Active</span>
                                @else
                                    <span class="status-badge status-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.category.edit', $category->id) }}" class="action-btn action-btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button onclick="deleteCategory({{ $category->id }})" class="action-btn action-btn-delete" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <i class="fa-solid fa-layer-group" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="font-size: 16px; margin-bottom: 20px;">No categories found</p>
                <a href="{{ route('admin.category.add') }}" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Add Your First Category
                </a>
            </div>
        @endif
    </div>

    <!-- Delete Undo Toast -->
    <div id="delete-toast" style="display: none; position: fixed; bottom: 30px; right: 30px; background: #323232; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 9999; min-width: 300px;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
            <span id="delete-message">Category deleted</span>
            <button onclick="undoDelete()" style="background: #f06292; color: white; border: none; padding: 6px 16px; border-radius: 4px; cursor: pointer; font-weight: 600;">
                UNDO
            </button>
        </div>
        <div id="delete-timer" style="margin-top: 8px; font-size: 12px; opacity: 0.8;">Deleting in <span id="countdown">5</span>s...</div>
    </div>

    <script>
        let deleteTimer;
        let deleteCategoryId;
        let deleteCategoryRow;

        function deleteCategory(categoryId) {
            deleteCategoryId = categoryId;
            deleteCategoryRow = document.getElementById('category-' + categoryId);
            
            // Hide the row
            deleteCategoryRow.style.opacity = '0.5';
            
            // Show toast
            document.getElementById('delete-toast').style.display = 'block';
            
            // Start countdown
            let seconds = 5;
            document.getElementById('countdown').textContent = seconds;
            
            deleteTimer = setInterval(() => {
                seconds--;
                document.getElementById('countdown').textContent = seconds;
                
                if (seconds <= 0) {
                    clearInterval(deleteTimer);
                    performDelete();
                }
            }, 1000);
        }

        function undoDelete() {
            clearInterval(deleteTimer);
            document.getElementById('delete-toast').style.display = 'none';
            deleteCategoryRow.style.opacity = '1';
        }

        function performDelete() {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/category/' + deleteCategoryId + '/delete';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }

        // Auto-hide success message
        setTimeout(() => {
            const successMsg = document.getElementById('success-message');
            if (successMsg) {
                successMsg.style.transition = 'opacity 0.5s';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
