@extends('layouts.auth')
@section('title', 'Notifications')
@section('content')
@if($notificationData)
<div class="notifyables-container">
    <div class="notifyables-header">
        <h5 class="text-lg-bold">Notifications</h5>
        <button class="btn btn-danger btn-sm" onclick="markAllAsRead()">Mark All as Read</button>
    </div>
    <div class="notifyables-list">
        @foreach($notificationData as $notification)
            <div class="notifyable-item {{ $notification->read_at ? 'read' : 'unread' }}">
                <div class="notifyable-content">
                    <h6 class="notifyable-title">{{ $notification->data['title'] }}</h6>
                    <p class="notifyable-message">{{ $notification->data['message'] }}</p>
                    <span class="notifyable-time">{{ $notification->created_at->diffForHumans   () }}</span>
                </div>
                <div class="notifyable-actions">
                    <button class="btn btn-primary btn-sm" onclick="markAsRead({{ $notification->id }})">Mark as Read</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteNotification({{ $notification->id }})">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="notifyables-container">
    <div class="notifyables-header">
        <h5 class="text-lg-bold">Notifications</h5>
    </div>
    <div class="notifyables-list">
        <div class="notifyable-item">
            <div class="notifyable-content">
                <h6 class="notifyable-title">No Notifications</h6>
                <p class="notifyable-message">You have no notifications at this time.</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
