@extends('layouts.app')

@section('title', $page->title)

@section('description', $page->description)

@section('content')
    @include('components.pageNavMenu')
    @include('pages.' . $page->page)
    <div hidden>
        @include('components.barMenu')
    </div>
@endsection
