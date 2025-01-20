@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">

        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">Detail Tugas Mahasiswa</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Deskripsi Tugas</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ $task->deskripsi }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">File Tugas</h2>
            <a href="{{ $task->link_dokumen }}" class="text-blue-500 dark:text-blue-400 hover:underline">Lihat File</a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Status Tugas</h2>
            <p class="text-gray-600 dark:text-gray-400"><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Status Pembimbing 1:</strong>
                {{ $task->status_dospem_1 ?? 'Belum disetujui' }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Status Pembimbing 2:</strong>
                {{ $task->status_dospem_2 ?? 'Belum disetujui' }}</p>
        </div>

        @role('dosen')
            @if ($task->status == 'dikerjakan')
                @if (
                    ($task->status_dospem_1 != 'disetujui' && Auth::user()->dosen->id == $task->dosen_pembimbing_1_id) ||
                        ($task->status_dospem_2 != 'disetujui' && Auth::user()->dosen->id == $task->dosen_pembimbing_2_id))
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Revisi atau ACC Tugas</h2>
                        <form method="POST"
                            action="{{ route('tasks.revisi', ['taskId' => $task->id_task, 'dosenId' => Auth::user()->dosen->id]) }}"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="komentar" class="block text-gray-600 dark:text-gray-400">Komentar Revisi</label>
                                <textarea name="komentar" id="komentar" rows="4"
                                    class="w-full p-3 rounded border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200" required></textarea>
                            </div>

                            <div>
                                <label for="link_dokumen" class="block text-gray-600 dark:text-gray-400">Link Dokumen
                                    Revisi</label>
                                <input type="url" name="link_dokumen" id="link_dokumen"
                                    class="w-full p-3 rounded border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200">
                            </div>

                            <button type="submit"
                                class="bg-red-500 dark:bg-red-600 text-white py-2 px-4 rounded hover:bg-red-600 dark:hover:bg-red-700 focus:outline-none">
                                Kirim Revisi
                            </button>
                        </form>

                        <form method="POST"
                            action="{{ route('tasks.acc', ['taskId' => $task->id_task, 'dosenId' => Auth::user()->dosen->id]) }}"
                            class="mt-4">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-500 dark:bg-green-600 text-white py-2 px-4 rounded hover:bg-green-600 dark:hover:bg-green-700 focus:outline-none">
                                ACC Tugas
                            </button>
                        </form>
                @endif
        </div>
        @endif
    @endrole

    @role('mahasiswa')
        @if ($task->status == 'dikerjakan')
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Unggah Ulang Proposal</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Jika proposal memerlukan revisi, Anda dapat mengunggah ulang di
                    halaman berikut.</p>
                <a href="{{ route('tasks.edit', ['taskId' => $task->id_task]) }}"
                    class="bg-blue-500 dark:bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">
                    Unggah Ulang Proposal
                </a>
            </div>
        @endif
    @endrole

    @if ($task->revisi)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Riwayat Revisi</h2>
            <ul class="list-disc pl-5 text-gray-600 dark:text-gray-400">
                @foreach ($task->revisi as $revisi)
                    <li class="mb-2">
                        <strong>Waktu:</strong> {{ $revisi['waktu'] }} <br>
                        <strong>Nama Dosen:</strong> {{ $revisi['dosen']['nama'] }} ({{ $revisi['dosen']['peran'] }}) <br>
                        <strong>Komentar:</strong> {{ $revisi['komentar'] }} <br>
                        @if (!empty($revisi['link_dokumen']))
                            <strong>Dokumen:</strong> <a href="{{ $revisi['link_dokumen'] }}" target="_blank"
                                class="text-blue-500 dark:text-blue-400 hover:underline">Lihat Dokumen</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mt-6">
        <a href="{{ url()->previous() }}"
            class="bg-gray-500 dark:bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none">
            Kembali
        </a>
    </div>
    </div>

@endsection
