@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4 dark:text-gray-100">Daftar Bimbingan</h1>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Judul Skripsi</th>
                <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                <th scope="col" class="px-6 py-3">Dosen Pembimbing 1</th>
                <th scope="col" class="px-6 py-3">Dosen Pembimbing 2</th>
                <th scope="col" class="px-6 py-3">Status</th>
                {{-- <th scope="col" class="px-6 py-3">Progres</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($bimbingan as $index => $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->skripsi->judul_skripsi }}</td>
                <td class="px-6 py-4">{{ $item->mahasiswaBimbingan->nama }}</td>
                <td class="px-6 py-4">{{ $item->dosenPembimbing1->nama }}</td>
                <td class="px-6 py-4">{{ $item->dosenPembimbing2->nama }}</td>
                <td class="px-6 py-4">{{ $item->status_bimbingan}}</td>
                {{-- <td class="px-6 py-4">{{ $item->progres }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bimbingan->links() }}
</div>
@endsection
