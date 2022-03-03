@extends('layouts.app')
@section('title', __('Cabinet'))
@section('content')
    <section id="cabinet">
        <div class="container">
            <div class="cabinet">
                <h1>{{ __('Cabinet') }}</h1>
                <div class="cabinet__home">
                    <a href="{{ route('cabinet.order') }}"
                       class="cabinet__home-link">{{ __('CabinetOrder') }} ({{ $user->orders->count() }})</a>
                    <a href="{{ route('cabinet.comment') }}"
                       class="cabinet__home-link">{{ __('CabinetComment') }} (0)</a>
                    <a href="{{ route('cabinet.feedback') }}"
                       class="cabinet__home-link">{{ __('CabinetFeedBack') }}</a>
                    <a href="{{ route('cabinet.profile.home') }}"
                       class="cabinet__home-link">{{ __('ProfileSetting') }}</a>
                    @include('cabinet.logout.logout')
                </div>
            </div>
        </div>
    </section>
@endsection
