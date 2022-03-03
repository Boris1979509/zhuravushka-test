@extends('layouts.app')
@section('description', '')
@section('title', __('Search'))
@section('content')
    <section id="search-wrap">
        <div class="container">
            @if(isset($products) && $products->count())
                <span
                    class="search-title">{{ '(' . $products->total() .  ') ' . __('SearchResult') . ' ' .  '"' . request()->get('search') . '"' }}</span>
                <div class="card-container grid">
                    @include('shop.card')
                </div>
                @if($products->total() > $products->count())
                    <div class="paginator-wrap">{{ $products->links() }}</div>
                @endif
            @else
                @include('flash.index', ['info' => __('NotFound')])
            @endif
        </div>
    </section>
@endsection
