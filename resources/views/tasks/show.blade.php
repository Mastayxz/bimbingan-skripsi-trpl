@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Heading Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Tugas</h1>
        <p class="text-gray-600">Detail dan pengaturan untuk tugas: <span class="font-semibold">{{ $task->nama_tugas }}</span></p>
    </div>

    <!-- Task Details -->
    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Informasi Tugas</h2>
        <p class="mb-2"><span class="font-semibold">Deskripsi:</span> {{ $task->deskripsi }}</p>
        <p class="mb-2"><span class="font-semibold">Status:</span> {{ $task->status }}</p>
        <p class="mb-2"><span class="font-semibold">Komentar Dosen:</span> {{ $task->komentar_dosen ?? 'Belum ada komentar' }}</p>
        <p class="mb-2">
            <span class="font-semibold">File Mahasiswa:</span>
            @if ($task->file_mahasiswa)
                <a href="{{ Storage::url($task->file_mahasiswa) }}" target="_blank" class="text-blue-400 underline">Download</a>
            @else
                <span class="text-gray-400">Belum ada file yang diunggah.</span>
            @endif
        </p>
    </div>

    <!-- Revision History -->
    <div class="bg-gray-100 p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Revisi</h2>
        @if ($task->revisi ?? [])
            <ul class="list-disc list-inside text-gray-700">
                @foreach ($task->revisi as $revisi)
                    <li class="mb-2">
                        <span class="font-semibold">Status:</span> {{ $revisi['status'] }} <br>
                        <span class="font-semibold">Komentar:</span> {{ $revisi['komentar_dosen'] ?? 'Tidak ada' }} <br>
                        <span class="font-semibold">Waktu:</span> {{ $revisi['updated_at'] }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">Belum ada riwayat revisi.</p>
        @endif
    </div>

    <!-- Edit Form -->
    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Edit/Revisi Tugas</h2>
        <form method="POST" action="{{ route('tasks.update', $task->id_task) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Tugas -->
            <div class="mb-4">
                <label for="nama_tugas" class="block text-gray-200 mb-2">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas" value="{{ $task->nama_tugas }}" 
                    class="w-full p-2 rounded border border-gray-700 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-200 mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" 
                    class="w-full p-2 rounded border border-gray-700 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ $task->deskripsi }}</textarea>
            </div>

            @role('mahasiswa')
            <!-- Upload File -->
            <div class="mb-4">
                <label for="file_mahasiswa" class="block text-gray-200 mb-2">Unggah File</label>
                <input type="file" id="file_mahasiswa" name="file_mahasiswa" 
                    class="w-full p-2 rounded border border-gray-700 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            @endrole

            @role('dosen')
            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-gray-200 mb-2">Status</label>
                <select id="status" name="status" 
                    class="w-full p-2 rounded border border-gray-700 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="menunggu persetujuan" {{ $task->status == 'menunggu persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ $task->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="sedang direvisi" {{ $task->status == 'sedang direvisi' ? 'selected' : '' }}>Sedang Direvisi</option>
                </select>
            </div>

            <!-- Komentar Dosen -->
            <div class="mb-4">
                <label for="komentar_dosen" class="block text-gray-200 mb-2">Komentar Dosen</label>
                <textarea id="komentar_dosen" name="komentar_dosen" rows="4" 
                    class="w-full p-2 rounded border border-gray-700 bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ $task->komentar_dosen }}</textarea>
            </div>
            @endrole

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
