@extends('frontend.layout.app')
@section('title', 'User || Verify OTP Page')
@section('banner', 'Verify OTP Page')
@section('content')
    @include('frontend.components.auth.verify-otp-form')
@endsection