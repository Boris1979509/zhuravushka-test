@extends('layouts.app')
@section('description', '')
@section('title',  __('Reset Password'))
@section('content')
    <section id="reset-password">
        <div class="container">
            <h1>{{ __('Reset Password') }}</h1>
            @include('flash.index')
            <div class="row">
                <div class="reset-password">
                    <form method="POST" action="{{ route('password.update') }}" id="reset-password-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-input">
                            <label for="email"
                                   class="form-input-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="input"
                                   name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-input">
                            <label for="password" class="form-input-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="input" name="password"
                                   autocomplete="new-password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-input">
                            <label for="password-confirm"
                                   class="form-input-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="input"
                                   name="password_confirmation"
                                   autocomplete="new-password" required>
                        </div>
                        <div class="form-input">
                            <button type="submit" class="btn btn-outline btn-go-on">
                                {{ __('Reset') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
