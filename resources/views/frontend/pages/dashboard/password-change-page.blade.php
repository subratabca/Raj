@extends('frontend.layout.app')
@section('title', 'User || Update Password')
@section('banner', 'Update Password')
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.dashboard.password-change')
@endsection