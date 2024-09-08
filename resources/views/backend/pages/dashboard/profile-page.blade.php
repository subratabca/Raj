@extends('backend.layout.master')
@section('title', 'Admin || Profile Page')
@section('breadcum', 'Update Profile')
@section('content')
    @include('backend.components.dashboard.profile-form')
@endsection