@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4 dark:text-white">Edit Skripsi</h2>
    <form action="{{ route('admin.skripsi.update', $skripsi->id_skripsi) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="judul_skripsi" class="block text-gray-700 dark:text-white">Judul Skripsi:</label>
            <input type="text" id="judul_skripsi" name="judul_skripsi" value="{{ $skripsi->judul_skripsi }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-white">
        </div>

        <div class="mb-4">
            <label for="mahasiswa" class="block text-gray-700 dark:text-white">Nama Mahasiswa:</label>
            <input type="text" id="mahasiswa" name="mahasiswa" value="{{ $skripsi->mahasiswaSkripsi->nama }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-white" disabled>
        </div>
        <div class="mb-4">
            <label for="mahasiswa" class="block text-gray-700 dark:text-white">Dosen Pembimbing 1:</label>
            <input type="text" id="dosen_pembimbing_1" name="dosen_pembimbing_1"
                value="{{ $skripsi->dosenPembimbing1->nama }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-white" disabled>
        </div>

        <div class="mb-4">
            <label for="dosen_pembimbing_2" class="block text-gray-700 dark:text-white">Dosen Pembimbing 2:</label>
            <select id="dosen_pembimbing_2" name="dosen_pembimbing_2"
                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-white">
                @foreach ($dosens as $d)
                    <option value="{{ $d->id }}" {{ $skripsi->dosen_pembimbing_2 == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4 flex-col justify-center">
            <!-- Tombol Update -->
            <button type="submit" class="text-white w-full bg-blue-500 px-4 py-2 rounded-md mb-2">Update</button>

            <!-- Link yang Lebar seperti Tombol -->
            <a href="{{ route('admin.skripsi.index') }}"
                class="text-center w-full bg-gray-500 text-white px-4 py-2 rounded-md mb-2 block text-center hover:bg-gray-600">
                Kembali ke Daftar Skripsi
            </a>
        </div>
    </form>
    </div>
@endsection
