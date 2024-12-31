@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-100">Mahasiswa</h2>
                <p class="text-sm text-gray-400">Jumlah mahasiswa yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-blue-400">{{ $mahasiswaCount }}</div>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-100">Dosen</h2>
                <p class="text-sm text-gray-400">Jumlah dosen yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-blue-400">{{ $dosenCount }}</div>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-100">Skripsi</h2>
                <p class="text-sm text-gray-400">Jumlah skripsi yang sedang diproses.</p>
                <div class="text-3xl font-bold text-blue-400">{{ $skripsiCount }}</div>
            </div>
        </div>

        <!-- Recent Skripsi -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-100 mb-4">Recent Skripsi</h2>
            <ul>
                @foreach ($recentSkripsi as $skripsi)
                    <li class="border-b border-gray-600 py-2">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-semibold text-gray-100">{{ $skripsi->judul_skripsi }}</p>
                                <p class="text-sm text-gray-400">
                                    Oleh: {{ $skripsi->mahasiswaSkripsi->nama ?? 'Nama Tidak Ditemukan' }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    Pembimbing 1: {{ $skripsi->dosenPembimbing1->nama ?? 'Tidak Ditemukan' }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    Pembimbing 2: {{ $skripsi->dosenPembimbing2->nama ?? 'Tidak Ditemukan' }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($skripsi->tanggal_pengajuan)->format('d M Y') }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($recentSkripsi->isEmpty())
                <p class="text-sm text-gray-400 mt-4">Belum ada skripsi yang diajukan.</p>
            @endif
        </div>
    </div>
@endsection
