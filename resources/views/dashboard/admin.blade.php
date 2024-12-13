@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Dashboard Admin</h1>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Mahasiswa</h2>
                <p class="text-sm text-gray-500">Jumlah mahasiswa yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-blue-600">{{ $mahasiswaCount }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Dosen</h2>
                <p class="text-sm text-gray-500">Jumlah dosen yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-blue-600">{{ $dosenCount }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Skripsi</h2>
                <p class="text-sm text-gray-500">Jumlah skripsi yang sedang diproses.</p>
                <div class="text-3xl font-bold text-blue-600">{{ $skripsiCount }}</div>
            </div>
        </div>

        <!-- Recent Skripsi -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Recent Skripsi</h2>
            <ul>
                @foreach ($recentSkripsi as $skripsi)
                    <li class="border-b border-gray-200 py-2">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-semibold text-gray-700">{{ $skripsi->judul_skripsi }}</p>
                                <p class="text-sm text-gray-500">
                                    Oleh: {{ $skripsi->mahasiswaSkripsi->nama ?? 'Nama Tidak Ditemukan' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Pembimbing 1: {{ $skripsi->dosenPembimbing1->nama ?? 'Tidak Ditemukan' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Pembimbing 2: {{ $skripsi->dosenPembimbing2->nama ?? 'Tidak Ditemukan' }}
                                </p>
                            </div>
                            <p class="text-sm text-gray-400">
                                {{ \Carbon\Carbon::parse($skripsi->tanggal_pengajuan)->format('d M Y') }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($recentSkripsi->isEmpty())
                <p class="text-sm text-gray-500 mt-4">Belum ada skripsi yang diajukan.</p>
            @endif
        </div>
        
    </div>
@endsection 
