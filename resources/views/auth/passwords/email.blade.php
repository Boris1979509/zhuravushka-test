@extends('layouts.app')
@section('description', '')
@section('title',  __('Request Password'))
@section('content')
    <section id="request-password">
        <div class="container">
            <h1>{{ __('Request Password') }}</h1>
            @include('flash.index')
            <div class="row">
                <div class="request-password">
                    <form method="POST" action="{{ route('password.email') }}" id="request-password-form">
                        @csrf
                        <div class="form-input">
                            <label for="email" class="form-input-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="input" name="email" value="{{ old('email') }}"
                                  required autocomplete="email" autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-input">
                            <button type="submit" class="btn btn-outline btn-go-on">
                                {{ __('Request') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
