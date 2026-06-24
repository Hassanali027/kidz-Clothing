@include('partials.header')

<style>
/* ── Sign In / Auth Pages ── */
.auth-page {
    background: #fdfdfd;
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
}
.auth-card {
    width: 100%;
    max-width: 440px;
    background: transparent;
}
.auth-title {
    font-size: 28px;
    font-weight: 800;
    color: #111;
    text-align: center;
    margin-bottom: 50px;
}

/* Form Styling */
.auth-form-group {
    margin-bottom: 35px;
    position: relative;
}
.auth-toggle-password {
    position: absolute;
    right: 0;
    bottom: 12px;
    cursor: pointer;
    color: #888;
}
.auth-toggle-password svg {
    width: 20px;
    height: 20px;
}
.auth-label {
    display: block;
    font-size: 13px;
    color: #aaa;
    margin-bottom: 8px;
}
.auth-input {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    font-size: 14px;
    color: #111;
    background: transparent;
    outline: none;
    transition: border-color 0.2s;
}
.auth-input:focus {
    border-color: #4fc3f7;
}

/* Forget Password Link */
.auth-forget {
    display: block;
    text-align: right;
    font-size: 12px;
    color: #29b6f6;
    text-decoration: none;
    margin-top: -25px;
    margin-bottom: 40px;
}
.auth-forget:hover { text-decoration: underline; }

/* Main Button */
.auth-submit-btn {
    width: 100%;
    background: #4fc3f7;
    color: #fff;
    border: none;
    padding: 16px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 25px;
}
.auth-submit-btn:hover { background: #29b6f6; }

/* Switch Auth Link */
.auth-switch {
    text-align: center;
    font-size: 13.5px;
    color: #444;
}
.auth-switch a {
    color: #29b6f6;
    text-decoration: none;
    font-weight: 500;
}
.auth-switch a:hover { text-decoration: underline; }

</style>

<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Sign-in</h1>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px; font-size: 14px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="auth-form-group">
                <label class="auth-label">Email</label>
                <input type="email" name="email" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Password</label>
                <input type="password" name="password" id="password" class="auth-input" required>
                <span class="auth-toggle-password" onclick="togglePassword('password', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </span>
            </div>

            <a href="#" class="auth-forget">Forget Password?</a>

            <button type="submit" class="auth-submit-btn">Login</button>

            <p class="auth-switch">
                Don't have an account? <a href="{{ route('signup') }}">Signup Here</a>
            </p>

        </form>
    </div>
</div>

<script>
function togglePassword(inputId, iconSpan) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        iconSpan.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>';
    } else {
        input.type = 'password';
        iconSpan.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>';
    }
}
</script>

@include('partials.footer')
