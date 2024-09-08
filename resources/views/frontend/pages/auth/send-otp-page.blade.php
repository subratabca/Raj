@extends('frontend.layout.app')
@section('title', 'User || OTP Page')
@section('banner', 'User OTP Page')
@section('content')
    @include('frontend.components.auth.send-otp-form')
@endsection