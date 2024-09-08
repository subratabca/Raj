@extends('client.layout.master')
@section('title', 'Client || Order Page')
@section('breadcum', 'Order List')
@section('content')
    @include('client.components.order.order-list')
    @include('client.components.order.order-details')
@endsection