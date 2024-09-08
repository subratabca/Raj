@extends('frontend.layout.app')
@section('title', 'User || Notification')
@section('banner', $type)
@section('content')
    @include('frontend.layout.banner')
    @include('frontend.components.notification.notification-details')
    <script>
        (async () => {
            await NotificationsByType();
        })()
    </script>
@endsection