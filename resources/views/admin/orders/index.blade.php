@extends('layouts.app')
@section('description', __(''))
@section('title', __('AdminOrders'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin">
                <div class="admin-orders">
                    @include('admin.orders._nav')
                    <h1>{{ __('AdminOrders') }} <span class="count">({{ $orders->total() }})</span></h1>
                    @include('flash.index')
                    @include('admin.orders.includes.orders')
                </div>
            </div>
        </div>
    </section>
@endsection
