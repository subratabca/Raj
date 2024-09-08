@extends('frontend.layout.app')
@section('title', 'Available Food')
@section('banner', 'Available Food List')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.available-food-list')
    <script>
        (async () => {
            await AvailableFoodList();
        })()
    </script>
@endsection