@extends('backend.auth.auth-layout')
@section('title', 'Admin || OTP Page')
@section('content')
    @include('backend.components.auth.send-otp-form')
@endsection