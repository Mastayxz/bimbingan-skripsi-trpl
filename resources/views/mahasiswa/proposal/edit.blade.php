@extends('layouts.app')
@endsection
@section('content')
<h1 class="text-3xl font-semibold mb-6 dark:text-white">Revisi Proposal</h1>

<!-- Form Revisi -->
<form action="{{ route('proposals.update', $proposal->id_proposal) }}" method="POST" enctype="multipart/form-data"
    class="bg-white shadow-lg rounded-lg p-6">
    @csrf
    @method('PUT')

    <!-- Judul -->
    <div class="mb-4">
        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Proposal</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $proposal->judul) }}" required
            class="w-full px-4 py-2 border rounded-lg @error('judul') border-red-500 @enderror">
        @error('judul')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div class="mb-4">
        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Proposal</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" required
            class="w-full px-4 py-2 border rounded-lg @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
        @error('deskripsi')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- File Proposal -->
    <div class="mb-4">
        <label for="file_proposal" class="block text-gray-700 font-semibold mb-2">Unggah File Proposal</label>
        <input type="url" id="file_proposal" name="file_proposal"
            class="w-full px-4 py-2 border rounded-lg @error('file_proposal') border-red-500 @enderror">
        <small class="text-gray-500">File saat ini:
            @if ($proposal->file_proposal)
                <a href="{{ $proposal->file_proposal }}" class="text-blue-500 hover:underline">Lihat File</a>
            @else
                Tidak ada file.
            @endif
        </small>
        @error('file_proposal')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Tombol Submit -->
    <div class="flex justify-end">
        <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">
            Ajukan Revisi
        </button>
    </div>
</form>
</div>
@endsection
