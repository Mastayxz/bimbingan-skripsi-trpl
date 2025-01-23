@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4 dark:text-gray-100">Daftar Bimbingan</h1>

    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50
         dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Judul Skripsi</th>
                    <th scope="col" class="px-6 py-3">NIM</th>
                    <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                    <th scope="col" class="px-6 py-3">NIP</th>
                    <th scope="col" class="px-6 py-3">Dosen Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3">NIP</th>
                    <th scope="col" class="px-6 py-3">Dosen Pembimbing 2</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    {{-- <th scope="col" class="px-6 py-3">Progres</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($bimbingan as $index => $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->skripsi->judul_skripsi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaBimbingan->nim }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaBimbingan->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing2->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing2->nama }}</td>
                        <td class="px-6 py-4 text-center">
                            <!-- Status -->
                            <span
                                class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                                @if ($item->status_bimbingan == 'selesai') bg-green-200 text-green-800 
                                @elseif($item->status_bimbingan == 'berjalan') bg-blue-200 text-blue-800 
                                @else bg-yellow-200 text-yellow-800 @endif">
                                {{ ucfirst($item->status_bimbingan) }}
                            </span>
                        </td>

                        {{-- <td class="px-6 py-4">{{ $item->progres }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $bimbingan->links('pagination::tailwind') }}
        </div>


    </div>
@endsection
