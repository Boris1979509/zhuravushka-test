@extends('layouts.app')
@section('description', __(''))
@section('title', __('Categories'))

@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-posts-categories">
                @include('admin.blog.categories._nav')
                <h1>{{ __('Categories') }}</h1>
                @include('flash.index')
                <a href="{{ route('admin.blog.categories.create') }}"
                   class="btn btn-outline btn-go-on">{{ __('Add category') }}</a>
                <table class="table mt-1">
                    <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Parent') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php /** @var BlogCategory $item */use App\Models\Blog\BlogCategory;
                    @endphp
                    @foreach ($categories as $item)
                        <tr @if($item->deleted_at) class="item-remove" @endif>
                            <td>{{ $item->id }}</td>
                            <td>@if(is_null($item->deleted_at))
                                    <a href='{{ route('admin.blog.categories.edit', $item->id) }}'
                                       class="link edit">{{ $item->title }}</a>
                                @else
                                    {{ $item->title }}
                                    <div class="mt-1">
                                        {{ __('Category is deleted') }}
                                        <a href="{{ route('admin.blog.category.restore', $item) }}">{{ __('Restore') }}</a>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->parentTitle }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
