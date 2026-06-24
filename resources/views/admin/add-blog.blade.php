@extends('admin.layout')

@section('header_title', 'Add New Blog Post')

@section('content')
    <div class="content-card">
        <div class="card-header">
            <h2>Create Blog Post</h2>
        </div>
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            <div class="form-group">
                <label>Blog Title</label>
                <input type="text" name="title" id="blog_title" class="form-control" placeholder="Enter blog title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label>Slug (URL)</label>
                <input type="text" name="slug" id="blog_slug" class="form-control" placeholder="url-slug-here" value="{{ old('slug') }}">
                <small style="color: #666;">Leave empty to auto-generate from title</small>
            </div>

            <div class="form-group">
                <label>Blog Content</label>
                <textarea name="description" id="editor" class="form-control" rows="10">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>

            <div class="form-group" style="margin-top: 10px;">
                <label class="checkbox-label" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="show_on_home" value="1" style="width: 18px; height: 18px;">
                    <span class="checkbox-text">
                        <strong>Show on Home Page</strong>
                        <small style="display: block; color: #666;">Display this blog in the "Style Tips" section of the homepage</small>
                    </span>
                </label>
            </div>

            <div class="form-row" style="margin-top: 20px;">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 30px;">
                <button type="submit" class="btn-primary">Publish Blog</button>
                <a href="{{ route('admin.blogs') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

        // Auto-slug generation
        document.getElementById('blog_title').addEventListener('input', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('blog_slug').value = slug;
        });
    </script>

    <style>
        .admin-form .form-group { margin-bottom: 20px; }
        .admin-form label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-family: inherit; }
        .btn-primary { background: #29b6f6; color: #fff; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-secondary { background: #eee; color: #333; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; margin-left: 10px; }
    </style>
@endsection
