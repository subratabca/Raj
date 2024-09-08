@extends('client.layout.master')
@section('title', 'Client || Today Report')
@section('breadcum', 'Today Report Information')
@section('content')
    @include('client.components.report.todays-report')
    @include('client.components.order.order-details')
@endsection