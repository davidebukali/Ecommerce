<!-- resources/views/auth/forgot-password.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Forgot your password?</h1>
        <p class="auth-subtitle">No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.</p>

        {{-- Session Status (e.g., "We have emailed your password reset link!") --}}
        @if (session('status'))
        <x-alert-message type="success" :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    autofocus class="form-input @error('email') is-invalid @enderror">
                @error('email')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary auth-submit-button">Email Password Reset Link</button>
            </div>
        </form>

        <div class="auth-footer">
            <p><a href="{{ route('login') }}" class="auth-link">Back to login</a></p>
        </div>
    </div>
</div>
@endsection
