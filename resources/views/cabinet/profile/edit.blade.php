@extends('layouts.app')
@section('title', __('CabinetProfileEdit'))
@section('content')
    <section id="cabinet">
        <div class="container">
            <div class="cabinet edit-profile">
                <h1>{{ __('CabinetProfileEdit') }}</h1>
                @include('cabinet.profile._nav')
                <form action="{{ route('cabinet.profile.update') }}" method="POST">
                    @csrf
                    <div class="profile-setting">
                        <div class="profile-setting__user-data grid">
                            <div class="form-input">
                                <label for="name" class="form-input-label">{{ __('Name') }}<span
                                        class="require">*</span></label>
                                <input type="text" name="name" id="name" class="input"
                                       placeholder="{{ __('Name') }}" autocomplete="name" value="{{ $user->name }}"
                                       autofocus>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="lastName" class="form-input-label">{{ __('LastName') }}<span
                                        class="require">*</span></label>
                                <input type="text" name="last_name" id="lastName" class="input"
                                       placeholder="{{ __('LastName') }}" value="{{ $user->last_name }}">
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="middleName" class="form-input-label">{{ __('MiddleName') }}</label>
                                <input type="text" name="middle_name" id="middleName" class="input"
                                       placeholder="{{ __('MiddleName') }}" autocomplete="name"
                                       value="{{ $user->middle_name }}">
                                @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="phone" class="form-input-label">{{ __('Phone') }}<span
                                        class="require">*</span></label>
                                <input type="tel" name="phone" id="phone" class="input"
                                       placeholder="{{ __('Phone') }}" readonly value="{{ $user->phone }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-input">
                                <label for="email" class="form-input-label">{{ __('E-Mail Address') }}<span
                                        class="require">*</span></label>
                                <input type="email" name="email" id="email" class="input"
                                       placeholder="{{ __('E-Mail Address') }}" autocomplete="email"
                                       value="{{ $user->email }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="title">{{ __('DeliveryData') }}</div>
                        <div class="profile-setting__user-address grid">
                            <div class="form-input">
                                <label class="form-input-label" for="city">{{ __('City') }}</label>
                                <input type="text" class="input" name="city" id="city" placeholder="{{ __('City') }}"
                                       value="@if($user->delivery_place){{ $user->delivery_place->city }}@endif">
                            </div>
                            <div class="form-input">
                                <label class="form-input-label" for="street">{{ __('Street') }}</label>
                                <input type="text" class="input" name="street" id="street"
                                       placeholder="{{ __('Street') }}"
                                       value="@if($user->delivery_place){{ $user->delivery_place->street }}@endif">
                            </div>
                            <div class="form-input">
                                <label class="form-input-label" for="houseNumber">{{ __('HouseNumber') }}</label>
                                <input type="number" class="input" name="house_number" id="houseNumber"
                                       placeholder="{{ __('HouseNumber') }}"
                                       value="@if($user->delivery_place){{ $user->delivery_place->house_number }}@endif">
                            </div>
                            <div class="form-input">
                                <label class="form-input-label" for="apartment">{{ __('Apartment') }}</label>
                                <input type="number" class="input" name="apartment" id="apartment"
                                       placeholder="{{ __('Apartment') }}"
                                       value="@if($user->delivery_place){{ $user->delivery_place->apartment }}@endif">
                            </div>
                        </div>
                        <div class="profile-setting__user-change-password-link">
                            <a class="link"
                               href="{{ route('cabinet.change.password.index') }}">{{ __('ChangePassword') }}</a>
                        </div>
                        <div class="form-input">
                            <button type="submit"
                                    class="btn btn-outline btn-go-on">{{ __('SaveSetting') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
