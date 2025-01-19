@extends('layouts.app')

@section('content')
    <!-- Header -->
    <h1 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-200">Dashboard Dosen</h1>
    <div class="bg-red-500 p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-white">Selamat Datang {{ Auth::user()->name }}</h2>
        <p class="text-sm text-purple-200">Anda telah masuk ke dashboard Dosen. Selamat bekerja dan semoga hari Anda
            menyenangkan!</p>
    </div>
    <!-- Statistik Proposal -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Proposal -->
        <div
            class="bg-gradient-to-r from-indigo-500 to-indigo-700 p-4 rounded-lg shadow-md text-white dark:bg-gradient-to-r dark:from-indigo-700 dark:to-indigo-900">
            <h3 class="text-xl font-semibold">Total Proposal</h3>
            <p class="text-3xl font-bold">{{ $totalProposals }}</p>
        </div>

        <!-- Proposal yang Sudah Ujian -->
        <div
            class="bg-gradient-to-r from-green-500 to-green-700 p-4 rounded-lg shadow-md text-white dark:bg-gradient-to-r dark:from-green-700 dark:to-green-900">
            <h3 class="text-xl font-semibold">Proposal yang Sudah Ujian</h3>
            <p class="text-3xl font-bold">{{ $proposalsOnExam }}</p>
        </div>

        <!-- Skripsi yang Berjalan -->
        <div
            class="bg-gradient-to-r from-yellow-500 to-yellow-700 p-4 rounded-lg shadow-md text-white dark:bg-gradient-to-r dark:from-yellow-700 dark:to-yellow-900">
            <h3 class="text-xl font-semibold">Skripsi yang Berjalan</h3>
            <p class="text-3xl font-bold">{{ $proposalsInProgress }}</p>
        </div>

        <!-- Skripsi yang Selesai -->
        <div
            class="bg-gradient-to-r from-gray-500 to-gray-700 p-4 rounded-lg shadow-md text-white dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-900">
            <h3 class="text-xl font-semibold">Skripsi yang Selesai</h3>
            <p class="text-3xl font-bold">{{ $completedProposals }}</p>
        </div>
    </div>

    <!-- Skripsi yang Dibimbing (Recent Proposal) -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b dark:border-gray-700">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200">Proposal Skripsi yang Dibimbing (Recent)</h2>
        </div>
        <div class="px-6 py-4">
            @forelse($proposals as $index => $item)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                    <div class="flex items-center mb-2">
                        <span class="font-bold text-gray-600 dark:text-gray-300">No:</span>
                        <span class="ml-2 text-gray-800 dark:text-gray-200">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Judul Proposal:</span>
                        <span class="ml-2 text-gray-800 dark:text-gray-200">{{ $item->judul }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Status:</span>
                        <span class="ml-2 text-gray-800 dark:text-gray-200 capitalize">{{ $item->status }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Mahasiswa:</span>
                        <span
                            class="ml-2 text-gray-800 dark:text-gray-200">{{ $item->mahasiswaProposal->nama ?? 'Tidak Ada Nama' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Pembimbing 1:</span>
                        <span
                            class="ml-2 text-gray-800 dark:text-gray-200">{{ $item->dosenPembimbing1Proposal->nama ?? 'Tidak Ada Nama' }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                    Tidak ada skripsi yang dibimbing.
                </div>
            @endforelse
        </div>
    </div>
@endsection
