@extends('frontend.layout.app')
@section('title', 'About')
@section('banner', 'About US')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.about')
    <script>
        (async () => {
            await AboutInfo();
        })()
    </script>
@endsection