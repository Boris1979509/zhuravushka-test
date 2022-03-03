@extends('layouts.app')
@section('title', __('ProfileSetting'))
@section('content')
    <section id="cabinet">
        <div class="container">
            <div class="cabinet profile">
                <h1>{{ __('ProfileSetting') }}</h1>
                @include('flash.index')
                @include('cabinet.profile._nav')
                @include('cabinet.profile.profile')
            </div>
        </div>
    </section>
@endsection
