@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h3 class="text-2xl font-semibold mb-6">Tambah Task untuk Bimbingan Skripsi: {{ $bimbingan->skripsi->judul_skripsi }}</h3>

    <form action="{{ route('tasks.store', $bimbingan->id_bimbingan) }}" method="POST" class="space-y-6">
        @csrf

        <div class="form-group">
            <label for="nama_tugas" class="block text-sm font-medium text-gray-700">Nama Tugas</label>
            <input type="text" name="nama_tugas" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <div class="form-group">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        <div class="form-group">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="belum dikerjakan">Belum Dikerjakan</option>
                <option value="sedang direvisi">Sedang Direvisi</option>
                <option value="disetujui">Disetujui</option>
            </select>
        </div>

        <div class="form-group">
            <label for="link_feedback_dosen" class="block text-sm font-medium text-gray-700">Link Feedback Dosen</label>
            <input type="url" name="link_feedback_dosen" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div class="form-group">
            <label for="komentar_dosen" class="block text-sm font-medium text-gray-700">Komentar Dosen</label>
            <textarea name="komentar_dosen" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Task</button>
    </form>
</div>
@endsection
