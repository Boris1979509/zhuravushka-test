@extends('layouts.app')
@section('description', '')
@section('title', __('Page Not Found'))
@section('content')
    <div class="container">
        <div class="row">
            <img src="{{ asset('images/404.png') }}" alt="{{ __('Page Not Found') }}">
        </div>
    </div>
@endsection
