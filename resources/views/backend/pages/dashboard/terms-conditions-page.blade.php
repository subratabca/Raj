@extends('backend.layout.master')
@section('title', 'Admin || T&C Page')
@section('breadcum', 'Terms & Conditions Setting')
@section('content')
    @include('backend.components.terms-conditions.index')
    @include('backend.components.terms-conditions.create')
    @include('backend.components.terms-conditions.update')
    @include('backend.components.terms-conditions.delete')
@endsection