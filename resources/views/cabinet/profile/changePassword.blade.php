@extends('layouts.app')
@section('title', __('CabinetProfileChangePassword'))
@section('content')
    <section id="cabinet">
        <div class="container">
            <div class="cabinet">
                <h1>{{ __('CabinetProfileChangePassword') }}</h1>
                @include('cabinet.profile._nav')
                <form action="{{ route('cabinet.change.password') }}" method="POST">
                    @csrf
                    <div class="profile-setting">
                        <div class="profile-setting__user-change-password grid">
                            <div class="form-input">
                                <label for="old_password" class="form-input-label">{{ __('OldPassword') }}</label>
                                <input type="password" name="old_password" id="old_password" class="input"
                                       autocomplete="new-password" placeholder="{{ __('OldPassword') }}">
                                @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="new_password" class="form-input-label">{{ __('NewPassword') }}</label>
                                <input type="password" name="new_password" id="new_password" class="input"
                                       autocomplete="new-password" placeholder="{{ __('NewPassword') }}">
                                @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="passwordConfirm"
                                       class="form-input-label">{{ __('PasswordConfirm') }}</label>
                                <input type="password" name="password_confirmation" id="passwordConfirm" class="input"
                                       autocomplete="new-password" placeholder="{{ __('PasswordConfirm') }}">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-input">
                            <button type="submit"
                                    class="btn btn-outline btn-go-on">{{ __('ChangePassword') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
