@extends('client.layout.master')
@section('title', 'Client || Notification')
@section('breadcum')
    @switch($type)
        @case('Food Publish Notification')
            Food Publish Notification
            @break
        @case('Food Request Notification')
            Food Request Notification
            @break
        @default
            Notification Details
    @endswitch
@endsection

@section('content')
    @include('client.components.notification.notification-details')
    <script>
        (async () => {
            await NotificationsByType();
        })()
    </script>
@endsection