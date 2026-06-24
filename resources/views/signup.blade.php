@include('partials.header')

<style>
/* ── Auth Page (Shared with Sign-in) ── */
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
    margin-bottom: 30px;
}
.auth-switch a {
    color: #29b6f6;
    text-decoration: none;
    font-weight: 500;
}
.auth-switch a:hover { text-decoration: underline; }

/* Separator */
.auth-separator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
    color: #888;
    font-size: 14px;
}
.auth-sep-line {
    height: 1px;
    background: #ddd;
    flex: 1;
}

/* Social Buttons */
.auth-social-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
.auth-social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 0;
    border: 1px solid #ffc1e3; /* Pinkish border like in image */
    border-radius: 6px;
    background: #fff;
    color: #333;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.auth-social-btn:hover { background: #fff5f8; }
.auth-social-btn img {
    width: 16px;
    height: 16px;
}

</style>

<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Create Account</h1>

        <form action="{{ route('signup.submit') }}" method="POST">
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
                <label class="auth-label">Full Name</label>
                <input type="text" name="name" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Email</label>
                <input type="email" name="email" id="email" class="auth-input" required oninput="validateEmail()">
                <div id="email-error" style="color: #f44336; font-size: 12.5px; margin-top: 6px; display: none;">Please enter a valid email address.</div>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Password</label>
                <input type="password" name="password" id="password" class="auth-input" required>
                <span class="auth-toggle-password" onclick="togglePassword('password', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </span>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input" required>
                <span class="auth-toggle-password" onclick="togglePassword('password_confirmation', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </span>
            </div>

            <button type="submit" class="auth-submit-btn">Create Account</button>

            <p class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </p>

            <div class="auth-separator">
                <div class="auth-sep-line"></div>
                OR
                <div class="auth-sep-line"></div>
            </div>

            <div class="auth-social-row">
                <a href="#" class="auth-social-btn">
                    <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google">
                    Sign up with Google
                </a>
                <a href="#" class="auth-social-btn">
                    <img src="https://www.svgrepo.com/show/330401/facebook.svg" alt="Facebook">
                    Sign up with Facebook
                </a>
            </div>

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

function validateEmail() {
    const email = document.getElementById('email').value;
    const errorSpan = document.getElementById('email-error');
    // Simple email regex
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email.length > 0 && !regex.test(email)) {
        errorSpan.style.display = 'block';
    } else {
        errorSpan.style.display = 'none';
    }
}
</script>

@include('partials.footer')
