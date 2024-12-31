@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    {{-- <h3 class="text-2xl font-semibold mb-6">Upload Tugas untuk Bimbingan Skripsi: {{ $bimbingan->skripsi->judul_skripsi }}</h3> --}}

    <form action="{{ route('tasks.upload', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="form-group">
            <label for="file_mahasiswa" class="block text-sm font-medium text-gray-700">Upload File Tugas</label>
            <input type="file" name="file_mahasiswa" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Upload File</button>
    </form>
</div>
@endsection
