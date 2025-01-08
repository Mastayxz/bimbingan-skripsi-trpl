@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">Detail Bimbingan</h1>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
            <div class="bg-gray-800 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
        </div>
        <p class="text-gray-800 font-medium">Progress: {{ number_format($progress, 2) }}%</p>
    </div>

    <!-- Daftar Task -->
    <h2 class="text-3xl font-bold mb-4 text-gray-800">Daftar Task</h2>
    @if ($tasks->isEmpty())
        <p class="text-gray-600">Belum ada tugas yang ditambahkan.</p>
    @else
        <ul class="space-y-4">
            @foreach ($tasks as $task)
            <li class="p-4 bg-gray-100 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-2">
                    <a href="{{ route('tasks.show', $task->id_task) }}" class="text-xl font-semibold text-gray-800">{{ $task->nama_tugas }}</a>
                    <span class="text-sm font-medium text-gray-600">{{ ucfirst($task->status) }}</span>
                </div>
                <p class="text-gray-700 mb-2">{{ $task->deskripsi }}</p>

                <!-- File dan Komentar -->
                <div class="space-y-2">
                    @if ($task->file_mahasiswa)
                        <p class="text-gray-600">File Tugas: <a href="{{ asset('storage/' . $task->file_mahasiswa) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a></p>
                    @endif

                    @if ($task->komentar_dosen)
                        <p class="text-gray-600">Komentar Dosen: <span class="text-gray-800">{{ $task->komentar_dosen }}</span></p>
                    @endif

                    @if ($task->file_feedback_dosen)
                        <p class="text-gray-600">Feedback Dosen: <a href="{{ asset('storage/' . $task->file_feedback_dosen) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a></p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    @endif

    <!-- Form Tambah Task untuk Mahasiswa -->
    @role('mahasiswa')
    <div class="mt-8 p-6 bg-gray-50 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Task Baru</h2>
        <form action="{{ route('tasks.store', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="flex flex-col">
                <label for="nama_tugas" class="mb-2 font-medium text-gray-700">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas" required class="border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>
            <div class="flex flex-col">
                <label for="deskripsi" class="mb-2 font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" required class="border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-800"></textarea>
            </div>
            <div class="flex flex-col">
                <label for="file_mahasiswa" class="mb-2 font-medium text-gray-700">Upload File</label>
                <input type="file" id="file_mahasiswa" name="file_mahasiswa" class="border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-3 rounded-md hover:bg-gray-900 transition duration-300">Tambah Task</button>
        </form>
    </div>
    @endrole
</div>
@endsection