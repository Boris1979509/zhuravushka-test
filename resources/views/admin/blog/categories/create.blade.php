@extends('layouts.app')
@section('description', __(''))
@section('title', __('Create'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-posts">
                @include('admin.blog.categories._nav')
                <h1>{{ __('Create') }}</h1>
                <form action="{{ route('admin.blog.categories.store') }}" method="POST">
                    @csrf
                    <div>
                        <div>
                            @include('admin.blog.categories.includes.item_create_main_col')
                        </div>
                        <div>
                            @include('admin.blog.categories.includes.item_edit_add_col')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
