@extends('layouts.app')
@section('description', __(''))
@section('title', __('Create'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-create-user">
                @include('admin.users._nav')
                <h1>{{ __('Create') }}</h1>
                <form method="POST" action="{{ route('admin.users.store') }}" class="create-user-form">
                    @csrf
                    <div class="form-input">
                        <label for="name" class="form-input-label">{{ __('Name') }}</label>
                        <input id="name" class="input" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="phone" class="form-input-label">{{ __('Phone') }}</label>
                        <input id="phone" type="tel"
                               class="input mask-input" name="phone"
                               value="{{ old('phone') }}" required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="email" class="form-input-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"
                               class="input" name="email"
                               value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <button type="submit" class="btn btn-go-on btn-outline">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
