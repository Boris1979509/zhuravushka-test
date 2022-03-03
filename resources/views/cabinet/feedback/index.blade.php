@extends('layouts.app')
@section('title', __('CabinetFeedBack'))
@section('content')
    <section id="cabinet">
        <div class="container">
            <div class="cabinet">
                <h1>{{ __('CabinetFeedBack') }}</h1>
                @include('cabinet.feedback._nav')
                @include('flash.index')
                @include('cabinet.feedback.feedback')
            </div>
        </div>
    </section>
@endsection
