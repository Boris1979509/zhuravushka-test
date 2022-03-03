@extends('layouts.app')
@section('title', $post->title)
@section('description', $post->excerpt)
@section('content')
    <div class="container">
        <h1 class="blog-title">{{ $post->title }}</h1>
        <div class="blog-wrap">
            @include('blog.blog-categories-sideBar')
            <div class="blog">
                @php /** @var BlogPost $post */use App\Models\Blog\BlogPost; @endphp
                <div class="blog__item">
                    <div class="blog__image">
                        <img src="{{ asset('images/blog/' . $post->image) }}" alt="{{ $post->title }}"
                             class="blog__item-image">
                    </div>
                    <div class="blog__body">
                        <p class="published">{{ parseDate(carbon($post->published_at))->format('j F, Y') }}</p>
                        <p class="link blog__title-link"
                           title="{{ $post->title }}">
                            {{ $post->title }}
                        </p>
                        <div class="blog__content">
                            <p title="{{ $post->content }}">
                                {{ $post->content }}
                            </p>
                            {{--{{ $post->category->title }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
