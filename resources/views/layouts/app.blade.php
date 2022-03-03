<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="16x16">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Style -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'build') }}">
</head>
<body>
@include('components.header')
@php /**  @uses Breadcrumbs \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs*/@endphp
@if(url()->current() != url('/'))
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render() }}
        </div>
    </div>
@endif
<div class="flex-center position-ref full-height">
    @yield('content')
</div>
@include('components.modal')
@include('components.footer')


<script src="{{ asset('plugins/glider.min.js') }}"></script>
<script src="{{ mix('js/app.js', 'build') }}"></script>
@yield('script')
</body>
</html>
