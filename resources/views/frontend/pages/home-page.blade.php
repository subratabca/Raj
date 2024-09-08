@extends('frontend.layout.app')
@section('title', 'Home Page')
@section('content')
    @include('frontend.components.home.slider')
    @include('frontend.components.home.food-list')
    <script>
        (async () => {
            await SliderList();
            await FoodList();
        })()
    </script>
@endsection