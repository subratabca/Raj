@extends('client.layout.master')
@section('title', 'Client || Dashboard')
@section('breadcum', 'Dashboard')
@section('content')
    @include('client.components.dashboard.dashboard-form')
@endsection