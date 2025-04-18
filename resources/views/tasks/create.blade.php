@extends('layouts.app')

@section('content')
    <div class="dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Tambah Task Baru</h1>

        <form action="{{ route('tasks.store', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Tugas -->
            <div class="mb-4">
                <label for="nama_tugas" class="block text-sm font-medium">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas"
                    class="w-full border-gray-500 dark:bg-gray-700 rounded-md shadow-sm dark:text-gray-300 @error('nama_tugas') border-red-500 @enderror"
                    required>
                @error('nama_tugas')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi"
                    class="w-full border-gray-500 dark:bg-gray-700 rounded-md shadow-sm dark:text-gray-300 @error('deskripsi') border-red-500 @enderror"
                    required></textarea>
                @error('deskripsi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- File -->
            <div class="mb-4">
                <label for="link_document" class="block text-sm font-medium">Link Document</label>
                <input type="url" id="link_document" name="link_document"
                    class="w-full border-gray-500 dark:bg-gray-700 rounded-md shadow-sm dark:text-gray-300 @error('link_document') border-red-500 @enderror">
                @error('link_document')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-800">Tambah
                Task</button>
        </form>
    </div>
    <div class="mt-6">
        <a href="{{ route('bimbingans.show', ['bimbingan_id' => $bimbingan->id_bimbingan]) }}"
            class="bg-gray-500 dark:bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none">
            Kembali
        </a>
    </div>
@endsection
