@extends('layouts.app')

@section('content')
    
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>
        <div class="bg-purple-600 p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold text-white">Selamat Datang, Admin!</h2>
            <p class="text-sm text-purple-200">Anda telah masuk ke dashboard admin. Selamat bekerja dan semoga hari Anda menyenangkan!</p>
        </div>
        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Mahasiswa -->
            <div class="bg-blue-600 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white">Mahasiswa</h2>
                <p class="text-sm text-blue-200">Jumlah mahasiswa yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-white">{{ $mahasiswaCount }}</div>
            </div>

            <!-- Dosen -->
            <div class="bg-green-600 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white">Dosen</h2>
                <p class="text-sm text-green-200">Jumlah dosen yang terdaftar di sistem.</p>
                <div class="text-3xl font-bold text-white">{{ $dosenCount }}</div>
            </div>

            <!-- Skripsi -->
            <div class="bg-yellow-600 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white">Skripsi</h2>
                <p class="text-sm text-yellow-200">Jumlah skripsi yang sedang diproses.</p>
                <div class="text-3xl font-bold text-white">{{ $skripsiCount }}</div>
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
@endsection
