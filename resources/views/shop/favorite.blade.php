@extends('layouts.app')
@section('description', '')
@section('title', __('Favorite'))
@section('content')
    <section id="favorite">
        <div class="container">
            <div class="favorite">
                <div class="favorite__title">
                    <h1>{{ __('Favorite') }} <span class="favorite__count">({{ $favoriteCount }})</span></h1>
                    @if($favoriteCount)
                        @include('shop.inc.cardRender')
                    @endif
                </div>
                @if($favoriteCount)
                    <div class="card-container">
                        @include('shop.card')
                    </div>
                @else
                    @include('flash.index')
                @endif
            </div>
        </div>
    </section>
@endsection
