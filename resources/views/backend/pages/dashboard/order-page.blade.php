@extends('backend.layout.master')
@section('title', 'Admin || Order Page')
@section('breadcum', 'Order List')
@section('content')
    @include('backend.components.order.order-list')
    @include('backend.components.order.order-details')
@endsection