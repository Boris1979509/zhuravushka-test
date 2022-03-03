@extends('layouts.app')
@section('description', '')
@section('title', __('Compare'))
@section('content')
    <section id="compare">
        <div class="container">
            <div class="compare">
                <div class="compare__title"><h1>{{ __('Compare') }} <span
                            class="compare__count">({{ $compareCount }})</span>
                    </h1>
{{--                    @if($compareCount)--}}
{{--                        @include('shop.inc.cardRender')--}}
{{--                    @endif--}}
                </div>
                @if($compareCount)
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
