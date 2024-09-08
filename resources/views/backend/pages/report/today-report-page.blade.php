@extends('backend.layout.master')
@section('title', 'Admin || Today Report')
@section('breadcum', 'Today Report Information')
@section('content')
    @include('backend.components.report.todays-report')
    @include('backend.components.order.order-details')
@endsection