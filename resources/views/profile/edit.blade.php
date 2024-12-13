<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Update Profile Information -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ __('Update Profile Information') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ __('Update Password') }}</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-red-600">{{ __('Delete Account') }}</h3>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
