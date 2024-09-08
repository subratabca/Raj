@extends('backend.layout.master')
@section('title', 'Admin || Slider Page')
@section('breadcum', 'Slider')
@section('content')
    @include('backend.components.slider.index')
    @include('backend.components.slider.create')
    @include('backend.components.slider.update')
    @include('backend.components.slider.delete')
@endsection