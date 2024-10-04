@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 bg-black text-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Settings</h2>

    <div class="space-y-4">
        <div class="bg-gray-800 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Profile Settings</h3>
            <p class="text-gray-300">Manage your profile settings.</p>
            <a href="{{ route('profile.edit') }}" class="text-red-600 hover:underline">Edit Profile</a>
        </div>

        <div class="bg-gray-800 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Account Settings</h3>
            <p class="text-gray-300">Manage your account settings.</p>
            <a href="{{ route('account.settings') }}" class="text-red-600 hover:underline">Edit Account</a>
        </div>

        <div class="bg-gray-800 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Privacy Settings</h3>
            <p class="text-gray-300">Manage your privacy settings.</p>
            <a href="{{ route('privacy.settings') }}" class="text-red-600 hover:underline">Edit Privacy</a>
        </div>
    </div>
</div>
@endsection
