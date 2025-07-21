<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Log in to your account</h1>
        <p class="auth-subtitle">Welcome back! Please enter your details.</p>

        {{-- Session Status (e.g., after password reset) --}}
        @if (session('status'))
        <x-alert-message type="success" :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    autofocus class="form-input @error('email') is-invalid @enderror">
                @error('email')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group-checkbox">
                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                <label for="remember_me" class="form-checkbox-label">Remember me</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary auth-submit-button">Log in</button>

                @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                @endif
            </div>
        </form>

        {{-- Separator for Social Login --}}
        <div class="social-login-separator">
            <span>Or</span>
        </div>

        {{-- Google Login Button --}}
        <div class="social-login-buttons">
            <a href="{{ route('google.auth') }}" class="button-social button-google">
                <svg class="google-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.0003 4.75C14.0263 4.75 15.8473 5.432 17.2403 6.782L20.0003 4C17.9213 2.035 15.1013 1 12.0003 1C7.79834 1 4.01534 3.42 2.19734 7.045L5.02134 9.222C5.67934 6.945 8.51334 4.75 12.0003 4.75Z"
                        fill="#EA4335" />
                    <path
                        d="M23.0003 12.0003C23.0003 11.2723 22.9393 10.5643 22.8193 9.87934H12.0003V14.1253H18.4413C18.1813 15.5183 17.3883 16.6663 16.3193 17.4093V20.2113H19.9603C22.1153 18.2773 23.0003 15.3443 23.0003 12.0003Z"
                        fill="#4285F4" />
                    <path
                        d="M5.02129 14.7773L2.19729 16.9543C4.01529 20.5793 7.79829 23.0003 12.0003 23.0003C15.1013 23.0003 17.9213 21.9653 20.0003 20.0003L17.2403 17.2183C15.8473 18.5683 14.0263 19.2503 12.0003 19.2503C8.51329 19.2503 5.67929 17.0553 5.02129 14.7773Z"
                        fill="#FBBC05" />
                    <path
                        d="M1 12.0003C1 11.2723 1.111 10.5643 1.291 9.87934H12.0003V14.1253H1.291C1.111 13.4393 1 12.7273 1 12.0003Z"
                        fill="#34A853" />
                </svg>
                <span>Sign in with Google</span>
            </a>
        </div>


        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign up here</a></p>
        </div>
    </div>
</div>
@endsection
