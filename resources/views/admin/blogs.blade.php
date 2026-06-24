@extends('admin.layout')

@section('header_title', 'Blog Management')

@section('content')
    <div class="content-card">
        <div class="card-header">
            <h2>Blog Posts</h2>
            <a href="{{ route('admin.blogs.add') }}" class="btn-primary" style="text-decoration: none;">+ Create New Post</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Home Page</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->thumbnail)
                                <img src="{{ asset('storage/' . $blog->thumbnail) }}" style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div style="width: 50px; height: 35px; background: #eee; border-radius: 4px;"></div>
                            @endif
                        </td>
                        <td>{{ $blog->title }}</td>
                        <td>
                            <span class="status-badge {{ $blog->status == 'published' ? 'status-success' : 'status-warning' }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </td>
                        <td>
                            @if($blog->show_on_home)
                                <span style="color: #22c55e;"><i class="fa-solid fa-check-circle"></i> Yes</span>
                            @else
                                <span style="color: #999;">No</span>
                            @endif
                        </td>
                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" style="color: #29b6f6;"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.blogs.delete', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: #f87171; cursor: pointer;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">No blog posts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
