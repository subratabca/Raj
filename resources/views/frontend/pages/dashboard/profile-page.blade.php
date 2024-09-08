@extends('frontend.layout.app')
@section('title', 'User || Profile')
@section('banner', 'My Profile')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.dashboard.profile')
@endsection