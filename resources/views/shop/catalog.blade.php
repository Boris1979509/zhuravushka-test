@extends('layouts.app')
@php /** @var ProductCategory $category */use App\Models\Shop\ProductCategory;@endphp
@section('title', __('Catalog'))
@section('description', __('Catalog'))

@section('content')
    <section id="page-catalog">
        <div class="container">
            <h1>{{ __('Catalog') }}</h1>
            <div class="page-catalog">
                @include('components.barMenu')
            </div>
        </div>
    </section>
@endsection
