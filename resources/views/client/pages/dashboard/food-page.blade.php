@extends('client.layout.master')
@section('title', 'Client || Food Page')
@section('breadcum', 'Food Information')
@section('content')
    @include('client.components.food.index')
    @include('client.components.food.create')
    @include('client.components.food.show')
    @include('client.components.food.update')
    @include('client.components.food.delete')
    @include('client.components.food.multi-image')
@endsection