@extends('layouts.auth')
@section('title', 'Manage Your Profile')
@section('description', 'Gluto HEP: User Profile Management')
@section('content')

<h1 class="mb-4 font-semibold text-black text-xl">User Profile Management</h1>
<div class="bg-gray-800 p-6 rounded-lg">



    <div class="flex items-center space-x-4">
        <div class="flex justify-center items-center bg-green-500 p-1 rounded-full w-[100px] h-[100px]">
            <img src="{{ $profilePic }}" alt="" class="rounded-full w-[90%] h-[90%] object-cover">

      </div>

      <div x-data="{ open: false }">
        <!-- Button to open the modal -->
        <button @click="open = true" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white">
            Upload photo
        </button>

        <!-- Modal -->
        <div x-show="open" class="z-50 fixed inset-0 flex justify-center items-center" style="display: none;">
            <div class="bg-white shadow-lg p-6 rounded-lg w-96">
                <h2 class="mb-4 font-semibold text-xl">Upload Profile Photo</h2>
                <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <input type="file" name="profile_pic" accept="image/jpeg, image/png, image/jpg" class="mb-4">

                    <div class="flex justify-end">
                        <button type="button" @click="open = false" class="bg-gray-300 hover:bg-gray-400 mr-2 px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Overlay -->
        <div x-show="open" class="fixed inset-0 bg-black opacity-50" @click="open = false" style="display: none;"></div>
    </div>


    </div>
  </div>


    <div class="py-6">
        <div class="space-y-6 max-w-7xl">
            <div class="bg-white shadow p-4 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white shadow p-4 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white shadow p-4 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>


@endsection
