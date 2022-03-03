@extends('layouts.app')
@section('title', __('Dashboard'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin">
                <h1>{{ __('Dashboard') }}</h1>
                @include('flash.index')
                <div class="admin__home">
                    <a href="{{ route('admin.users.index') }}"
                       class="admin__home-link">{{ __('Users') }} ({{ $users }})</a>
                    <a href="{{ route('admin.blog.posts.index') }}"
                       class="admin__home-link">{{ __('Blog') }} ({{ $posts }})</a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="admin__home-link">{{ __('AdminOrders') }} ({{ $orders }})</a>
                    @include('cabinet.logout.logout')
                </div>
            </div>
        </div>
    </section>
@endsection
