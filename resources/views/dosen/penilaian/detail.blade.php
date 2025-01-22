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
                        <th scope="col" class="px-6 py-3">Motivasi</th>
                        <th scope="col" class="px-6 py-3">Kreativitas</th>
                        <th scope="col" class="px-6 py-3">Disiplin</th>
                        <th scope="col" class="px-6 py-3">Metodologi</th>
                        <th scope="col" class="px-6 py-3">Perencanaan</th>
                        <th scope="col" class="px-6 py-3">Rancangan</th>
                        <th scope="col" class="px-6 py-3">Kesesuaian Rancangan</th>
                        <th scope="col" class="px-6 py-3">Keberfungsian</th>
                        <th scope="col" class="px-6 py-3">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                   
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->id  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->motivasi }}</td>

                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->kreativitas  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->disiplin  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->metodologi  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->perencanaan  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->rancangan  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->kesesuaian_rancangan  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->keberfungsian  }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $penilaian->jumlah_skor  }}</td>
                            
                        </tr>
                    
                </tbody>
                
            </table>
            
        </div>
        <div class="mt-6">
            <a href="{{ route('dosen.penilaian.index') }}"
                class="bg-gray-500 dark:bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none">
                Kembali
            </a>
        </div>
    </div>
    
@endsection