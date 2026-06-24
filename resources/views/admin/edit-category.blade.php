@extends('admin.layout')

@section('header_title', 'Edit Category')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
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

    <div class="content-card">
        <div class="card-header">
            <h2>Edit Category: {{ $category->name }}</h2>
        </div>

        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Category Name <span style="color: #f06292;">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    <small style="color: #666;">e.g., Boys Wear, Girls Wear, Baby Wear</small>
                </div>

                <div class="form-group">
                    <label for="slug">Slug <span style="color: #666;">(Auto-generated)</span></label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" placeholder="Auto-generated from name">
                    <small style="color: #666;">URL-friendly version (e.g., boys-wear)</small>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Category Image</label>
                @if($category->image)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="max-width: 200px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: #666;">Recommended size: 600x400px (JPG, PNG, WEBP - Max 5MB). Leave empty to keep current image.</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Brief description about this category">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="order">Display Order</label>
                    <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $category->order) }}" min="0">
                    <small style="color: #666;">Lower numbers appear first</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save"></i> Update Category
                </button>
                <a href="{{ route('admin.category') }}" class="btn-secondary">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
