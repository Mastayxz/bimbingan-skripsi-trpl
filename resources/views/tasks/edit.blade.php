@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4 dark:text-white">Unggah Ulang Dokumen</h1>

    <form method="POST" action="{{ route('tasks.update', ['taskId' => $task->id_task]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- <div class="mb-4">
            <label for="proposal" class="block text-gray-600">Unggah File Proposal</label>
            <input type="file" name="proposal" id="proposal" class="w-full p-2 rounded border border-gray-300">
        </div> --}}

        <div class="mb-4">
            <label for="link_dokumen" class="block text-gray-600">Deskripsi</label>
            <input type="text" name="deskripsi" id="link_dokumen" class="w-full p-2 rounded border border-gray-300"
                value="{{ $task->deskripsi }}">
        </div>
        <div class="mb-4">
            <label for="link_dokumen" class="block text-gray-600">Atau Masukkan Link Dokumen</label>
            <input type="url" name="link_dokumen" id="link_dokumen" class="w-full p-2 rounded border border-gray-300">
        </div>

        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 focus:outline-none">
            Simpan Perubahan
        </button>
    </form>


    <div class="mt-6">
        <a href="{{ route('bimbingans.show', ['bimbingan_id' => $task->bimbingan->id_bimbingan]) }}"
            class="bg-gray-500 dark:bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none">
            Kembali
        </a>
    </div>
@endsection
