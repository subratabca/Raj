@extends('client.layout.master')
@section('title')
    @switch($type)
        @case('food_upload')
            Food Upload T&C Page
            @break
        @case('request_approve')
            Request Approve T&C Page
            @break
        @case('food_deliver')
            Food Deliver T&C Page
            @break
        @default
            Terms and Conditions Page
    @endswitch
@endsection

@section('breadcum')
    @switch($type)
        @case('food_upload')
            Food Upload T&C Information
            @break
        @case('request_approve')
            Request Approve T&C Information
            @break
        @case('food_deliver')
            Food Deliver T&C Information
            @break
        @default
            Terms and Conditions Information
    @endswitch
@endsection

@section('content')
    @include('client.components.terms-conditions.terms-conditions')
    <script>
        (async () => {
            await TermsConditionsByType();
        })()
    </script>
@endsection
