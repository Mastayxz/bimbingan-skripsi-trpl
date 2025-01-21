@extends('layouts.app')
@section('breadcrumb')
    <x-breadcrumb :links="[
        'Daftar Bimbingan' => route('bimbingan.index'),
    ]" />
@endsection
@section('content')
    <div class="container mx-auto px-4 ">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6 dark:text-white">Daftar Bimbingan</h1>

        <!-- Form Pencarian -->
        <form action="{{ route('bimbingan.search') }}" method="GET" class="mb-6">
            <div class="flex items-center">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari berdasarkan NIM"
                    class="form-input w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                    Cari
                </button>
            </div>
        </form>

        @if ($bimbingans->isEmpty())
            <div class="text-center text-gray-500">
                <p>Tidak ada bimbingan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ">
                @foreach ($bimbingans as $bimbingan)
                    <div
                        class="dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <a href="{{ route('bimbingans.show', ['bimbingan_id' => $bimbingan->id_bimbingan]) }}"
                            class="block text-gray-800 hover:text-blue-800 font-semibold text-lg mb-2 dark:text-white">
                            {{ $bimbingan->skripsi->judul_skripsi }}
                        </a>
                        @role('dosen')
                            <p class="text-gray-600 text-sm dark:text-white">NIM :
                                {{ $bimbingan->mahasiswaBimbingan->nim }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Nama Mahasiswa:
                                {{ $bimbingan->mahasiswaBimbingan->nama }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Email: {{ $bimbingan->mahasiswaBimbingan->email }}
                            </p>
                            <p class="text-gray-600 text-sm dark:text-white">Telepon:
                                {{ $bimbingan->mahasiswaBimbingan->telepon }}</p>
                        @endrole
                        @role('mahasiswa')
                            <p class="text-gray-600 text-sm dark:text-white">NIP Pembimbing 1:
                                {{ $bimbingan->dosenPembimbing1->nip }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Nama Pembimbing 1:
                                {{ $bimbingan->dosenPembimbing1->nama }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Email Pembimbing 1:
                                {{ $bimbingan->dosenPembimbing1->email }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Nama Pembimbing 2:
                                {{ $bimbingan->dosenPembimbing2->nama }}</p>
                            <p class="text-gray-600 text-sm dark:text-white">Email Pembimbing 2:
                                {{ $bimbingan->dosenPembimbing2->email }}</p>
                        @endrole
                        <div class="mt-4">
                            @if ($bimbingan->status_bimbingan === 'selesai')
                                <span class="text-xs text-gray-500 dark:text-white">Bimbingan ini Selesai</span>
                            @else
                                <span class="text-xs text-gray-500 dark:text-white">Bimbingan ini Sedang Berlangsung</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bimbingans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
