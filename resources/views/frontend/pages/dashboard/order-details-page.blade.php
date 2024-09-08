@extends('frontend.layout.app')
@section('title', 'User || Order Details')
@section('banner', 'Order Details Information')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.order.order-details')
@endsection