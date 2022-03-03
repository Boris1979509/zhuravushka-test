@extends('layouts.app')
@php /** @var ProductCategory $category */use App\Models\Shop\ProductCategory;@endphp
@section('title', $category->title)
@section('description', $category->description)
@section('content')
    <section id="catalog">
        <div class="container">
            <div class="catalog">
                @include('shop.sort.topSort')
                <h1>{{ $category->title }}</h1>
                @include('flash.index')
                <div class="catalog__wrap">
                    <div class="catalog__subsection">
                        @if(($category->children)->count())
                            <ul class="catalog__category">
                                @foreach($category->children as $categoryItem)
                                    <a href="{{ route('category', $categoryItem->slug) }}"
                                       title="{{ $categoryItem->title }}" class="catalog__category-link">
                                        <li class="catalog__subsections-item">{{ $categoryItem->title }} <span
                                                class="item-qty">{{ $categoryItem->productCount }}</span>
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        @endif
                        @include('shop.sort.leftSort')
                    </div>
                    <div class="catalog__items-section">
                        <div class="card-container">
                            @include('shop.card')
                        </div>
                        @if($products->total() > $products->count())
                            <div class="paginator-wrap">{{ $products->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
