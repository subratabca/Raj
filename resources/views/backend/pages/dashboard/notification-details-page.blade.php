@extends('backend.layout.master')
@section('title', 'Admin || Notification')
@section('breadcum')
    @switch($type)
        @case('New Food Upload Notification')
            New Food Upload Notification
            @break
        @case('Food Delivery Notification')
            Food Delivery Notification
            @break
        @default
            Notification Details
    @endswitch
@endsection

@section('content')
    @include('backend.components.notification.notification-details')
    <script>
        (async () => {
            await NotificationsByType();
        })()
    </script>
@endsection