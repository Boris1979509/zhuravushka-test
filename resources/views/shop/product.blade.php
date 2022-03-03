@extends('layouts.app')
@php /** @var Product $product */use App\Models\Shop\Product;@endphp
@section('title', $product->title)
@section('description', $product->description)

@section('content')
    <div class="container">
        <div class="product-wrap">
            <div class="product">
                <div class="product__photo-container container-preload-lazy-load">
                    <div class="preload"></div>
                    <img data-src="{{ fileExist("images/products/{$product->photo}") }}" alt="{{ $product->title }}"
                         class="product__img lazy-load">
                </div>
                <div class="product__all">
                    <h1>{{ $product->title }}</h1>
                    <div class="product__desc">
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="characteristics">
                        <div class="characteristics__props">
                            <p class="characteristics__props-name">{{ __('ProductCode') }}</p>
                            <p class="characteristics__props-value">{{ $product->code }}</p>
                        </div>
                    </div>
                </div>
                <div class="product__actions-container">
                    <div class="card">
                        <div class="card__footer">
                            @include('shop.priceBlock', ['product' => $product])
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="addCart">
                                @csrf
                                <div class="product-qty">
                                    <div class="product-qty__qty">
                                        <span class="product-qty__minus"></span>
                                        <input type="text" class="product-qty__input" value="1" name="qty">
                                        <span class="product-qty__plus"></span>
                                    </div>
                                    <button class="btn btn-active btn-add">{{ __('CartButtonAdd') }}</button>
                                </div>
                            </form>
                            <div class="card__icons">
                                <div class="card__icons-container">
                                    @include('shop.cardIconFavorite', ['productItem' => $product])
                                    <div class="favorite__title">{{ __('Add to favourites') }}</div>
                                </div>
                                <div class="card__icons-container">
                                    @include('shop.cardIconCompare', ['productItem' => $product])
                                    <div class="compare__title">{{ __('Add to compares') }}</div>
                                </div>
                                {{--                                <div class="card__icons-container">--}}
                                {{--                                    <div class="informer">--}}
                                {{--                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"--}}
                                {{--                                             xmlns="http://www.w3.org/2000/svg">--}}
                                {{--                                            <circle cx="12" cy="12.4836" r="11.5" stroke="#FC8507"/>--}}
                                {{--                                            <path--}}
                                {{--                                                d="M9.26 18V16.502H8.14V15.144H9.26V14.052H8.14V12.316H9.26V8.004H12.452C13.74 8.004 14.678 8.26533 15.266 8.788C15.8633 9.31067 16.162 10.0293 16.162 10.944C16.162 11.4853 16.0407 11.994 15.798 12.47C15.5553 12.946 15.1493 13.3287 14.58 13.618C14.02 13.9073 13.2547 14.052 12.284 14.052H11.374V15.144H13.53V16.502H11.374V18H9.26ZM11.374 12.316H12.074C12.6713 12.316 13.1427 12.2133 13.488 12.008C13.8427 11.8027 14.02 11.4713 14.02 11.014C14.02 10.1647 13.46 9.74 12.34 9.74H11.374V12.316Z"--}}
                                {{--                                                fill="#FC8507"/>--}}
                                {{--                                        </svg>--}}
                                {{--                                        <div class="informer__title">Сообщить об изменении цены?</div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-info-tabs">
                @include('shop.productTabs')
            </div>
            @if(!empty($moreGoods))
                <div class="more-goods">
                    @include('shop.moreGoods')
                </div>
            @endif
        </div>
    </div>
@endsection
