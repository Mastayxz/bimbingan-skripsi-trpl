{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h3 class="text-2xl font-semibold mb-6">Task untuk Bimbingan Skripsi: {{ $bimbingan->skripsi->judul_skripsi }}</h3>

    <!-- Untuk Dosen: Link untuk Tambah Task -->
    @if (Auth::user()->hasRole('dosen'))
        <a href="{{ route('tasks.create', $bimbingan->id_bimbingan) }}" class="block mb-6 py-2 px-4 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Tambah Task
        </a>
    @endif

    <!-- Daftar Task -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($tasks as $task)
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-200">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">{{ $task->nama_tugas }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($task->deskripsi, 150) }}</p>

                <div class="mb-4">
                    <span class="text-sm text-gray-500">Status: </span>
                    <span class="font-semibold {{ $task->status == 'belum dikerjakan' ? 'text-red-500' : ($task->status == 'sedang direvisi' ? 'text-yellow-500' : 'text-green-500') }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>

                <!-- Link untuk Mahasiswa: Upload File -->
                @if (Auth::user()->hasRole('mahasiswa'))
                    @if ($task->status == 'belum dikerjakan') <!-- Hanya tampilkan link upload untuk tugas yang belum dikerjakan -->
                        <a href="{{ route('tasks.unggah', $bimbingan->id_bimbingan) }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                            Upload Tugas
                        </a>
                    @endif
                @endif

                <!-- Link untuk Dosen: Lihat File Mahasiswa atau Feedback -->
                @if (Auth::user()->hasRole('dosen'))
                    @if ($task->link_mahasiswa)
                        <a href="{{ Storage::url($task->link_mahasiswa) }}" target="_blank" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                            Lihat File Mahasiswa
                        </a>
                    @endif
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">Feedback: </span>
                        <a href="{{ Storage::url($task->link_feedback_dosen) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            Lihat Feedback Dosen
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>
@endsection
