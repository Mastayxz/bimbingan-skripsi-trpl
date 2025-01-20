@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Edit Skripsi</h2>
        <form action="{{ route('admin.skripsi.update', $skripsi->id_skripsi) }}" method="POST">
            @csrf
            @method('POST')

            <div class="mb-4">
                <label for="judul" class="block text-gray-700">Judul Skripsi:</label>
                <input type="text" id="judul" name="judul" value="{{ $skripsi->judul_skripsi }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
            </div>

            <div class="mb-4">
                <label for="mahasiswa" class="block text-gray-700">Nama Mahasiswa:</label>
                <input type="text" id="mahasiswa" name="mahasiswa" value="{{ $skripsi->mahasiswaSkripsi->nama }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
            </div>

            <div class="mb-4">
                <label for="dosen_pembimbing_1" class="block text-gray-700">Dosen Pembimbing 1:</label>
                <select id="dosen_pembimbing_1" name="dosen_pembimbing_1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @foreach ($dosens as $d)
                        <option value="{{ $d->id }}" {{ $skripsi->dosen_pembimbing_1 == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="dosen_pembimbing_2" class="block text-gray-700">Dosen Pembimbing 2:</label>
                <select id="dosen_pembimbing_2" name="dosen_pembimbing_2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @foreach ($dosens as $d)
                        <option value="{{ $d->id }}" {{ $skripsi->dosen_pembimbing_2 == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </form>
    </div>
@endsection
