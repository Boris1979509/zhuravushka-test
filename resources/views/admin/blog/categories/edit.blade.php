@extends('layouts.app')
@section('description', __(''))
@section('title', __('Edit'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-posts-categories">
                @include('admin.blog.posts._nav')
                <h1>{{ __('Edit') }}</h1>
                @include('flash.index')
                @php /** @var App\Models\Blog\BlogCategory $category */@endphp
                <form action="{{ route('admin.blog.categories.update', $category) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="posts-category-wrap">
                        <div class="category-content">
                            @include('admin.blog.categories.includes.item_edit_main_col')
                        </div>
                        <div class="category-info">
                            @include('admin.blog.categories.includes.item_edit_add_col')
                        </div>
                    </div>
                </form>
                {{-- DELETE --}}
                <form action="{{ route('admin.blog.categories.destroy', $category) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="">
                        <button type="submit" onclick="clicked(this.form); return false"
                                class="btn btn-cancel btn-outline ml">{{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function clicked(form) {
            if (confirm('{{ __('Confirm deletion') }}')) {
                form.submit();
            } else {
                return false;
            }
        }
    </script>
@endsection
