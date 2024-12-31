@extends('layouts.app')

@section('content')
<div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Detail Bimbingan</h1>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="w-full bg-gray-700 rounded-full h-4 relative">
            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
            <span class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-gray-100">{{ number_format($progress, 2) }}%</span>
        </div>
        <p class="text-sm text-gray-400 mt-2">Progress: {{ number_format($progress, 2) }}%</p>
    </div>

    <!-- Daftar Task -->
    <h2 class="text-xl font-semibold mb-4">Daftar Task</h2>
    @if ($tasks->isEmpty())
        <p class="text-gray-400">Belum ada tugas yang ditambahkan.</p>
    @else
        <ul class="space-y-4">
            @foreach ($tasks as $task)
            <li class="border p-4 rounded-lg shadow-sm bg-gray-700">
                <div class="flex justify-between items-center">
                    <a href="{{ route('tasks.show', $task->id_task) }}" class="font-semibold text-blue-400 hover:underline">
                        {{ $task->nama_tugas }}
                    </a>
                    <span class="px-3 py-1 rounded-full text-sm text-white 
                        {{ $task->status == 'disetujui' ? 'bg-green-500' : ($task->status == 'sedang direvisi' ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-300 mt-2">{{ $task->deskripsi }}</p>

                <!-- File dan Komentar -->
                <div class="mt-3">
                    @if ($task->file_mahasiswa)
                        <p class="text-sm">File Tugas: 
                            <a href="{{ asset('storage/' . $task->file_mahasiswa) }}" target="_blank" class="text-blue-400 hover:text-blue-600">Lihat</a>
                        </p>
                    @endif

                    @if ($task->komentar_dosen)
                        <p class="text-sm mt-2">Komentar Dosen: <span class="italic text-gray-300">{{ $task->komentar_dosen }}</span></p>
                    @endif

                    @if ($task->file_feedback_dosen)
                        <p class="text-sm mt-2">Feedback Dosen: 
                            <a href="{{ asset('storage/' . $task->file_feedback_dosen) }}" target="_blank" class="text-blue-400 hover:text-blue-600">Lihat</a>
                        </p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    @endif

    <!-- Form Tambah Task untuk Mahasiswa -->
    @role('mahasiswa')
    <h2 class="text-xl font-semibold mt-10">Tambah Task Baru</h2>
    <form action="{{ route('tasks.store', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="nama_tugas" class="block text-sm font-medium">Nama Tugas</label>
            <input type="text" id="nama_tugas" name="nama_tugas" class="w-full border-gray-500 bg-gray-700 rounded-md shadow-sm text-gray-300" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full border-gray-500 bg-gray-700 rounded-md shadow-sm text-gray-300" required></textarea>
        </div>
        <div class="mb-4">
            <label for="file_mahasiswa" class="block text-sm font-medium">Upload File</label>
            <input type="file" id="file_mahasiswa" name="file_mahasiswa" class="w-full border-gray-500 bg-gray-700 rounded-md shadow-sm text-gray-300">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-800">Tambah Task</button>
    </form>
    @endrole
</div>
@endsection
