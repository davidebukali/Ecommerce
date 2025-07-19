<!-- resources/views/auth/reset-password.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Reset your password</h1>
        <p class="auth-subtitle">Enter your new password below.</p>

        {{-- Session Status --}}
        @if (session('status'))
        <x-alert-message type="success" :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autocomplete="email" autofocus class="form-input @error('email') is-invalid @enderror">
                @error('email')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" class="form-input">
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary auth-submit-button">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
