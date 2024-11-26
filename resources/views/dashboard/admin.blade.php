<!-- resources/views/dashboard/dosen.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    <div class="mt-6">
        <a href="{{ route('admin.mahasiswa') }}" class="text-blue-500 hover:text-blue-700">
            Lihat Data Mahasiswa
        </a>
    </div>
    
</x-app-layout>
