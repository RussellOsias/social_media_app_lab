<x-app-layout>
    <x-slot name="header">
        <div class="bg-red-600 p-4 rounded-t-lg shadow-md text-center">
            <h2 class="text-white text-3xl font-bold">
                🖼️ {{ __('Profile') }}
            </h2>
            <span class="text-lg text-white font-medium">{{ __('Manage your account settings') }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Overview -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-white text-2xl font-semibold mb-4">👤 {{ __('Profile Overview') }}</h3>
                <p class="text-gray-400">Here you can update your profile information, change your password, and manage your account settings.</p>
                <hr class="my-4 border-red-600" />
            </div>

            <!-- Update Profile Information Form -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-red-600 text-xl font-semibold mb-4">✏️ {{ __('Update Profile Information') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Email Form -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-red-600 text-xl font-semibold mb-4">📧 {{ __('Update Email Address') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-user-email-form')
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-red-600 text-xl font-semibold mb-4">🔒 {{ __('Update Password') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Form -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-red-600 text-xl font-semibold mb-4">🗑️ {{ __('Delete Account') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Additional Features Section -->
            <div class="bg-black p-6 rounded-lg shadow-md border border-red-600">
                <h3 class="text-white text-xl font-semibold mb-4">✨ {{ __('Additional Features') }}</h3>
                <ul class="list-disc list-inside text-gray-300">
                    <li>📝 {{ __('View your activity log') }}</li>
                    <li>📊 {{ __('Check your account statistics') }}</li>
                    <li>🔗 {{ __('Manage connected apps and services') }}</li>
                    <li>📩 {{ __('Set up two-factor authentication') }}</li>
                </ul>
            </div>

            <!-- Support Section -->
            <div class="bg-red-600 p-6 rounded-lg shadow-md border border-red-700">
                <h3 class="text-white text-xl font-semibold mb-4">🛠️ {{ __('Need Help?') }}</h3>
                <p class="text-gray-200">If you encounter any issues, feel free to reach out to our support team.</p>
                <button class="mt-4 px-4 py-2 bg-white text-red-600 rounded hover:bg-gray-200 transition duration-150">Contact Support</button>
            </div>
        </div>
    </div>
</x-app-layout>
