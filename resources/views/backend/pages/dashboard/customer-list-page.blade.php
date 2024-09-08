@extends('backend.layout.master')
@section('title', 'Admin || Customer List')
@section('breadcum', 'Customer List')
@section('content')
    @include('backend.components.customer.customer-list')
@endsection