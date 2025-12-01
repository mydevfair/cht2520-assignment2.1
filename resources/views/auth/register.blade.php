@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 style="color: #2c3e50; margin-bottom: 20px;">Register</h2>

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                @error('password_confirmation')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-buttons" style="justify-content: space-between;">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>

                <a href="{{ route('login') }}" class="btn btn-success">
                    Already registered?
                </a>
            </div>
        </form>
    </div>
@endsection
