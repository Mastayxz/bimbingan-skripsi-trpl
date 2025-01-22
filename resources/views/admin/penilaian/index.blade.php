@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Penilaian Bimbingan</h1>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Daftar Penilaian -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Judul Skripsi</th>
                        <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                        <th scope="col" class="px-6 py-3">Pembimbing 1</th>
                        <th scope="col" class="px-6 py-3">NIP Pembimbing 1</th>
                        <th scope="col" class="px-6 py-3">Pembimbing 2</th>
                        <th scope="col" class="px-6 py-3">NIP Pembimbing 2</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian as $nilai)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->skripsi->judul_skripsi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->mahasiswaBimbingan->nama  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->dosenPembimbing1->nama  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->dosenPembimbing1->nip  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->dosenPembimbing2->nama  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->bimbingan->dosenPembimbing2->nip  }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        
        </div>
        <div class="mt-6">
        <a href="{{ route('admin.penilaian.detail') }}"
                class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600">
                Detail
        </a>
    </div>
    </div>
@endsection