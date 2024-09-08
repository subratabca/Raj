@extends('frontend.layout.app')
@section('title', 'User || Order Page')
@section('banner', 'My Order Information')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.order.order-list')
@endsection