@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header -->
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Dashboard Dosen</h1>
        <p class="text-gray-600 mb-6">Selamat datang, Dosen. Anda dapat melihat skripsi yang dibimbing oleh Anda di sini.</p>

        <!-- Skripsi yang Dibimbing -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-bold text-xl text-gray-800">Skripsi yang Dibimbing</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="text-left py-2 px-4 border-r text-gray-600">No</th>
                            <th class="text-left py-2 px-4 border-r text-gray-600">Judul Skripsi</th>
                            <th class="text-left py-2 px-4 border-r text-gray-600">Status</th>
                            <th class="text-left py-2 px-4 text-gray-600">Mahasiswa</th>
                            <th class="text-left py-2 px-4 text-gray-600">Pembimbing 1</th>
                            <th class="text-left py-2 px-4 text-gray-600">Pembimbing 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skripsi as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->judul_skripsi }}</td>
                                <td class="py-2 px-4 border-b capitalize">{{ $item->status }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->mahasiswaSkripsi->nama ?? 'Tidak Ada Nama' }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->dosenPembimbing1->nama ?? 'Tidak Ada Nama' }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->dosenPembimbing2->nama ?? 'Tidak Ada Nama' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
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
