@extends('backend.layout.master')
@section('title', 'Admin || Dashboard')
@section('breadcum', 'Dashboard')
@section('content')
    @include('backend.components.dashboard.dashboard-form')
@endsection