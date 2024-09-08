@extends('client.layout.master')
@section('title', 'Client || Report Page')
@section('breadcum', 'Search Report Information')
@section('content')
    @include('client.components.report.search-report')
    @include('client.components.order.order-details')
@endsection