@extends('layouts.app')

@section('content')
    <div class="bg-gray-800 text-white py-8 px-4 rounded-lg shadow-md">
        <h1 class="text-4xl font-bold mb-4">Dashboard Mahasiswa</h1>
        <p class="text-lg">Selamat datang, Mahasiswa. Anda dapat mengakses informasi skripsi Anda di sini.</p>
    </div>

    <div class="mt-8 bg-gray-800 text-gray-100 shadow-lg rounded-lg p-6">
        <h2 class="font-bold text-2xl mb-4">Proposal Saya</h2>
        <p class="text-gray-300 mb-6">Jika Anda sudah mengajukan proposal, Anda dapat melanjutkan di sini.</p>
        
        <ul>
            @foreach ($proposals as $proposal)
                <li class="mb-6 p-4 bg-gray-700 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-white">Judul Proposal: {{ $proposal->judul }}</h3>
                    <p class="mt-2">Status: 
                        <span class="font-medium {{ $proposal->status === 'disetujui' ? 'text-green-400' : 'text-yellow-400' }}">
                            {{ $proposal->status }}
                        </span>
                    </p>
                    <!-- Bar progres -->
                    <div class="mt-4">
                        <label for="comments" class="block text-sm font-medium">Komentar dari Dosen Pembimbing</label>
                        <div class="mb-6">
                            <p class="text-gray-300">{{ $proposal->komentar }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="dospem" class="block text-sm font-medium">Dosen Pembimbing</label>
                        <div class="mb-6">
                            <p class="text-gray-300">{{ $proposal->dosenPembimbing1Proposal->nama }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mt-8 bg-gray-800 text-gray-100 shadow-lg rounded-lg p-6">
        <h2 class="font-bold text-2xl mb-4">Skripsi Saya</h2>
        <p class="text-gray-300 mb-6">Jika Anda sudah mengajukan skripsi, Anda dapat melanjutkan di sini.</p>
        
        <ul>
            @foreach ($skripsi as $skripsiItem)
                <li class="mb-6 p-4 bg-gray-700 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-white">Judul Skripsi: {{ $skripsiItem->judul_skripsi }}</h3>
                    <p class="mt-2">Status: 
                        <span class="font-medium {{ $skripsiItem->status === 'Disetujui' ? 'text-green-400' : 'text-yellow-400' }}">
                            {{ $skripsiItem->status }}
                        </span>
                    </p>
                    <!-- Bar progres -->
                    <div class="mt-4">
                        <label for="progress" class="block text-sm font-medium">Progres Bimbingan</label>
                        <div class="mb-6">
                            <div class="w-full bg-gray-700 rounded-full h-4 relative">
                                <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
                                <span class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-gray-100">{{ number_format($progress, 2) }}%</span>
                            </div>
                            <p class="text-sm text-gray-400 mt-2">Progress: {{ number_format($progress, 2) }}%</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
