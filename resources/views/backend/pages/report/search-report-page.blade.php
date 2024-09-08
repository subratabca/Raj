@extends('backend.layout.master')
@section('title', 'Admin || Report Page')
@section('breadcum', 'Search Report Information')
@section('content')
    @include('backend.components.report.search-report')
    @include('backend.components.order.order-details')
@endsection