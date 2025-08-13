@extends('layouts.auth')
@section('title', 'Notifications')
@section('content')
@if($notificationData)
<div class="bg-white shadow-md p-6 rounded-lg w-full">
    <div class="flex justify-between items-center mb-4">
        <h5 class="font-bold text-lg">Notifications</h5>
        {{-- <button class="bg-red-500 px-3 py-1 rounded-sm text-white text-sm" onclick="markAllAsRead()">Delete All</button> --}}
    </div>
    <div class="space-y-4">
        @foreach($notificationData as $notification)
            <div class="bg-gray-50 hover:bg-gray-100 p-4 border rounded-lg transition-all">
                <div class="flex flex-col">
                    <h6 class="font-semibold text-md">{{ $notification['title'] }}</h6>
                    <p class="text-gray-700">{{ $notification['message'] }}</p>
                    <span class="mt-1 text-gray-500 text-sm">{{ $notification['time'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white shadow-md p-6 rounded-lg w-full">
    <div class="flex justify-between items-center mb-4">
        <h5 class="font-bold text-lg">Notifications</h5>
    </div>
    <div class="bg-gray-50 p-4 border rounded-lg">
        <h6 class="font-semibold text-md">No Notifications</h6>
        <p class="text-gray-700">You have no notifications at this time.</p>
    </div>
</div>
@endif
@endsection
