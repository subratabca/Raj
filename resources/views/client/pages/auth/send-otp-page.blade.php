@extends('client.auth.auth-layout')
@section('title', 'Client || OTP Page')
@section('content')
    @include('client.components.auth.send-otp-form')
@endsection