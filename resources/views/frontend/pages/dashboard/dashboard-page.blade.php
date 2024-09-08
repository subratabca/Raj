@extends('frontend.layout.app')
@section('title', 'User || Dashboard')
@section('banner', 'My Dashboard')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.dashboard.dashboard')
@endsection