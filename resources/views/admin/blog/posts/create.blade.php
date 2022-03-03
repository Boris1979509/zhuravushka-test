@extends('layouts.app')
@section('description', __(''))
@section('title', __(''))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-posts">
                @include('admin.blog.posts._nav')
                <h1>{{ __('Create') }}</h1>
                <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div>
                            @include('admin.blog.posts.includes.item_create_main_col')
                        </div>
                        <div>
                            @include('admin.blog.posts.includes.item_edit_add_col')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
