@extends('layouts.app')

@section('description', __('Login'))
@section('title',  __('Login'))

@section('content')
    <section id="section-login">
        <div class="container">
            <h1>{{ __('Login') }}</h1>
            @include('flash.index')
            @include('auth.login')
        </div>
    </section>
@endsection
