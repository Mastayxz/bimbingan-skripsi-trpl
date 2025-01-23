@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-200">Dashboard Mahasiswa</h1>
    <div class="bg-gradient-to-r from-purple-500 to-purple-700 p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }}</h2>
        <p class="text-sm text-purple-200">Anda telah masuk ke dashboard Mahasiswa. Selamat bekerja dan semoga hari Anda
            menyenangkan!</p>
    </div>

    @if ($proposals->whereIn('status', ['diajukan', 'disetujui'])->isNotEmpty())
        <div class="mt-8 bg-gradient-to-r from-purple-500 to-purple-700 text-gray-100 shadow-lg rounded-lg p-6">
            <h2 class="font-bold text-2xl mb-4">Proposal Saya</h2>
            <p class="text-gray-300 mb-6">Jika Anda sudah mengajukan proposal, Anda dapat melanjutkan di sini.</p>

            <ul>
                @foreach ($proposals as $proposal)
                    <li class="mb-6 p-4 bg-white dark:bg-gray-700 rounded-lg shadow text-black dark:text-white">
                        <h3 class="text-xl font-semibold dark:text-white">Judul Proposal: {{ $proposal->judul }}</h3>
                        <p class="mt-2">Status:
                            <span
                                class="font-medium {{ $proposal->status === 'disetujui' ? 'text-green-400' : 'text-yellow-400' }}">
                                {{ $proposal->status }}
                            </span>
                        </p>
                        <div class="mt-4">
                            <label for="comments" class="block text-sm font-medium">Komentar dari Dosen Pembimbing</label>
                            <div class="mb-6">
                                <p class="dark:text-gray-300">{{ $proposal->komentar }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="dospem" class="block text-sm font-medium">Dosen Pembimbing</label>
                            <div class="mb-6">
                                <p class="dark:text-gray-300">{{ $proposal->dosenPembimbing1Proposal->nama }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-8 bg-gradient-to-r from-purple-500 to-purple-700 text-gray-100 shadow-lg rounded-lg p-6">
        <h2 class="font-bold text-2xl mb-4">Skripsi Saya</h2>
        <p class="text-gray-300 mb-6">Jika Anda sudah mengajukan skripsi, Anda dapat melanjutkan di sini.</p>

        <ul>
            @foreach ($bimbingans as $skripsiItem)
                <li class="mb-6 p-4 bg-gray-700 rounded-lg shadow">
                    <a href="{{ route('bimbingans.show', ['bimbingan_id' => $skripsiItem->id_bimbingan]) }}">
                        {{ $skripsiItem->skripsi->judul_skripsi }}
                    </a>
                    <p class="mt-2">Status:
                        <span
                            class="font-medium {{ $skripsiItem->status_bimbingan === 'berjalan' ? 'text-yellow-400' : 'text-green-400' }}">
                            {{ $skripsiItem->status_bimbingan }}
                        </span>
                    </p>
                    <div class="mt-4">
                        <label for="progress" class="block text-sm font-medium">Progres Bimbingan</label>
                        <div class="mb-6">
                            <div class="w-full bg-gray-700 rounded-full h-4 relative">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-700 h-4 rounded-full"
                                    style="width: {{ $progress }}%;"></div>
                                <span
                                    class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-gray-100">{{ number_format($progress, 2) }}%</span>
                            </div>
                            <p class="text-sm text-gray-400 mt-2">Progress: {{ number_format($progress, 2) }}%</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
