@extends('layouts.app')

@section('content')

    <div class="py-12"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Daftarkan Skripsi</h1>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('skripsi.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="judul_skripsi" class="block text-sm font-medium text-gray-700">Judul Skripsi</label>
                        <input type="text" name="judul_skripsi" id="judul_skripsi" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('judul_skripsi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('tanggal_pengajuan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Dosen Pembimbing 1 -->
                    <div class="mt-4">
                        <label for="dosen_pembimbing_1" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 1</label>
                        <select name="dosen_pembimbing_1" id="dosen_pembimbing_1" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                        @error('dosen_pembimbing_1')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Dosen Pembimbing 2 -->
                    <div class="mt-4">
                        <label for="dosen_pembimbing_2" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 2</label>
                        <select name="dosen_pembimbing_2" id="dosen_pembimbing_2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Dosen Pembimbing 2 (Opsional) --</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                        @error('dosen_pembimbing_2')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Abstrak -->
                    <div class="mt-4">
                        <label for="abstrak" class="block text-sm font-medium text-gray-700">Abstrak</label>
                        <textarea name="abstrak" id="abstrak" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        @error('abstrak')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold text-sm rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Daftarkan Skripsi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection
