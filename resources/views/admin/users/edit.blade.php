@extends('layouts.app')
@section('description', __(''))
@section('title', __('Edit'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-create-user">
                @include('admin.users._nav')
                <h1>{{ __('Edit') }}</h1>
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-input">
                        <label for="name" class="form-input-label">@lang('Name')</label>
                        <input id="name" class="input" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="lastName" class="form-input-label">@lang('LastName')</label>
                        <input type="text" name="last_name" id="lastName" class="input"
                               placeholder="@lang('LastName')" value="{{ $user->last_name }}">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="middleName" class="form-input-label">@lang('MiddleName')</label>
                        <input type="text" name="middle_name" id="middleName" class="input"
                               placeholder="@lang('MiddleName')" autocomplete="name"
                               value="{{ $user->middle_name }}">
                        @error('middle_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="phone" class="form-input-label">@lang('Phone')</label>
                        <input type="tel" name="phone" id="phone" class="input"
                               placeholder="@lang('Phone')" value="{{ $user->phone }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="email" class="form-input-label">@lang('E-Mail Address')</label>
                        <input id="email" type="email" class="input" name="email"
                               value="{{ $user->email }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <label for="role" class="form-input-label">@lang('Role')</label>
                        <select id="role" class="input" name="role">
                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}" @if($value === old('role', $user->role)) selected @endif>{{
                                    $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input">
                        <button type="submit" class="btn btn-outline btn-go-on">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
