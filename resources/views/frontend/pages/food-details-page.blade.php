@extends('frontend.layout.app')
@section('title', 'Food Details')
@section('banner', 'Food Details Information')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.food-details')
    <script>
        (async () => {
            await FoodDetailsInfo();
        })()
    </script>
@endsection