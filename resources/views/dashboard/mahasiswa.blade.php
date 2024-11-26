<!-- resources/views/dashboard/mahasiswa.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome, Mahasiswa!") }}
                </div>

                <div class="mt-6">
                    <a href="{{ route('skripsi.create') }}" class="text-blue-500 hover:text-blue-700">
                        Daftarkan Skripsi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
