@extends('admin.layout')

@section('header_title', 'User Management')

@section('content')
    <div class="content-card">
        <div class="card-header">
            <h2>Registered Users</h2>
        </div>
        
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>#{{ $user->id }}</strong></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="action-btns" style="display: flex;">
                                    <a href="{{ route('admin.users.orders', $user->id) }}" class="btn-action" style="background: #7c3aed;" title="View Order History">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action btn-edit" title="Edit User">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-delete" title="Delete User">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #999;">No registered users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table th, .admin-table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .admin-table th {
            background: #f9f9f9;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            font-size: 13px;
        }
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            color: #fff;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
            text-decoration: none;
        }
        .btn-edit { background: #2196F3; }
        .btn-delete { background: #f44336; }
        .btn-action:hover { opacity: 0.8; }
    </style>
@endsection
