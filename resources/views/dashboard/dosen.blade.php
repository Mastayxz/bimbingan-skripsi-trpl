@extends('layouts.app')

@section('content')


    <!-- Header -->
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Dashboard Dosen</h1>
    <div class="bg-red-500 p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-bold text-white">Selamat Datang, Dosen!</h2>
        <p class="text-sm text-purple-200">Anda telah masuk ke dashboard Dosen. Selamat bekerja dan semoga hari Anda menyenangkan!</p>
    </div>
    <!-- Statistik Proposal -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Proposal -->
        <div class="bg-indigo-600 p-4 rounded-lg shadow-md text-white">
            <h3 class="text-xl font-semibold">Total Proposal</h3>
            <p class="text-3xl font-bold">{{ $totalProposals }}</p>
        </div>

        <!-- Proposal yang Sudah Ujian -->
        <div class="bg-green-600 p-4 rounded-lg shadow-md text-white">
            <h3 class="text-xl font-semibold">Proposal yang Sudah Ujian</h3>
            <p class="text-3xl font-bold">{{ $proposalsOnExam }}</p>
        </div>

        <!-- Skripsi yang Berjalan -->
        <div class="bg-yellow-600 p-4 rounded-lg shadow-md text-white">
            <h3 class="text-xl font-semibold">Skripsi yang Berjalan</h3>
            <p class="text-3xl font-bold">{{ $proposalsInProgress }}</p>
        </div>

        <!-- Skripsi yang Selesai -->
        <div class="bg-gray-600 p-4 rounded-lg shadow-md text-white">
            <h3 class="text-xl font-semibold">Skripsi yang Selesai</h3>
            <p class="text-3xl font-bold">{{ $completedProposals }}</p>
        </div>
    </div>

    <!-- Skripsi yang Dibimbing (Recent Proposal) -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="font-bold text-xl text-gray-800">Proposal Skripsi yang Dibimbing (Recent)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="text-left py-2 px-4 border-r text-gray-600">No</th>
                        <th class="text-left py-2 px-4 border-r text-gray-600">Judul Proposal</th>
                        <th class="text-left py-2 px-4 border-r text-gray-600">Status</th>
                        <th class="text-left py-2 px-4 text-gray-600">Mahasiswa</th>
                        <th class="text-left py-2 px-4 text-gray-600">Pembimbing 1</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->judul }}</td>
                            <td class="py-2 px-4 border-b capitalize">{{ $item->status }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->mahasiswaProposal->nama ?? 'Tidak Ada Nama' }}</td>
                            <td class="py-2 px-4 border-b">{{ $item->dosenPembimbing1Proposal->nama ?? 'Tidak Ada Nama' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Tidak ada skripsi yang dibimbing.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
