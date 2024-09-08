@extends('backend.layout.master')
@section('title', 'Admin || Client List')
@section('breadcum', 'Client List')
@section('content')
    @include('backend.components.client.client-list')
@endsection