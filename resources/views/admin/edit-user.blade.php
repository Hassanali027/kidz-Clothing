@extends('admin.layout')

@section('header_title', 'Edit User')

@section('content')
    <div class="content-card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Edit User Details</h2>
            <a href="{{ route('admin.users') }}" class="btn-cancel" style="text-decoration: none; padding: 8px 16px; background: #f1f1f1; border-radius: 4px; color: #333; font-size: 14px;">Back to Users</a>
        </div>
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                ✓ {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                ! {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            
            <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">Basic Information</h3>
            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <h3 style="margin-top: 30px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333;">Address Information</h3>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>
            
            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Province</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $user->province) }}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
            </div>

            <div class="form-actions" style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-submit" style="background: #111; color: #fff; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 15px;">Update User Details</button>
            </div>
        </form>
    </div>

    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            color: #333;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #111;
            outline: none;
        }
        .required {
            color: #f44336;
        }
        .btn-submit:hover {
            background: #333;
        }
    </style>
@endsection
