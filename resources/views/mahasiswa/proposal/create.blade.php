@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-2xl font-bold mb-6">Daftarkan Proposal</h2>
        <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="judul_proposal" class="block text-gray-700 font-bold mb-2">Judul Proposal</label>
                <input type="text" id="judul_proposal" name="judul_proposal" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="tanggal_pengajuan" class="block text-gray-700 font-bold mb-2">Tanggal Pengajuan</label>
                <input type="date" id="tanggal_pengajuan" name="tanggal_pengajuan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="file_proposal" class="block text-gray-700 font-bold mb-2">Upload File</label>
                <input type="file" id="file_proposal" name="file_proposal" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="dosen_pembimbing_1" class="block text-gray-700 font-bold mb-2">Dosen Pembimbing 1</label>
                <select id="dosen_pembimbing_1" name="dosen_pembimbing_1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
