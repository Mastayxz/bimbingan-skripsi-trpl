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
        @role('dosen')
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
        @endrole
        @if ($bimbingans->isEmpty())
            <div class="text-center text-gray-500">
                <p>Tidak ada bimbingan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($bimbingans as $bimbingan)
                    <a href="{{ route('bimbingans.show', ['bimbingan_id' => $bimbingan->id_bimbingan]) }}"
                        class="dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-xl block">
                        <div class="text-gray-800 font-semibold text-lg mb-2 dark:text-white uppercase">
                            {{ strtoupper($bimbingan->skripsi->judul_skripsi) }}
                        </div>

                        <div class="text-sm text-gray-600 dark:text-white mt-2">
                            @role('dosen')
                                <p><span class="font-medium">Mahasiswa:</span> {{ $bimbingan->mahasiswaBimbingan->nama }}
                                    ({{ $bimbingan->mahasiswaBimbingan->nim }})</p>
                            @endrole

                            @role('mahasiswa')
                                <p><span class="font-medium">Pembimbing 1:</span> {{ $bimbingan->dosenPembimbing1->nama }}
                                    ({{ $bimbingan->dosenPembimbing1->nip }})</p>
                                <p><span class="font-medium">Pembimbing 2:</span> {{ $bimbingan->dosenPembimbing2->nama }}
                                    ({{ $bimbingan->dosenPembimbing2->nip }})</p>
                            @endrole
                        </div>

                        <div class="mt-4">
                            <span class="text-xs text-gray-500 dark:text-white">
                                Bimbingan ini
                                {{ $bimbingan->status_bimbingan === 'selesai' ? 'Selesai' : 'Sedang Berlangsung' }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>


            <!-- Pagination -->
            <div class="mt-6">
                {{ $bimbingans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
