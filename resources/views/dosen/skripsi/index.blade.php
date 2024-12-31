@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Daftar Mahasiswa</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Mahasiswa -->
    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-3 text-left">No.</th>
                <th class="px-4 py-3 text-left">Judul Skripsi</th>
                <th class="px-4 py-3 text-left">Nama Mahasiswa</th>
                <th class="px-4 py-3 text-left">Pembimbing 1</th>
                <th class="px-4 py-3 text-left">Pembimbing 2</th>
                <th class="px-4 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($skripsi as $index => $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{  $item->judul_skripsi  }}</td>
                    <td class="px-4 py-3">{{ $item->mahasiswaSkripsi->nama }}</td>
                    <td class="px-4 py-3">{{ $item->dosenPembimbing1->nama}}</td>
                    <td class="px-4 py-3">{{ $item->dosenPembimbing2->nama}}</td>
                    <td class="px-4 py-3 text-center">
                        <!-- Status -->
                        <span class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                            @if($item->status == 'disetujui') bg-green-200 text-green-800 
                            @elseif($item->status == 'ditolak') bg-red-200 text-red-800 
                            @else bg-yellow-200 text-yellow-800 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $mahasiswa->links('pagination::tailwind') }}
    </div> --}}
</div>

   
@endsection
