@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Daftar Pengajuan Skripsi</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Pengajuan Skripsi -->
    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-3 text-left">No.</th>
                <th class="px-4 py-3 text-left">Judul Skripsi</th>
                <th class="px-4 py-3 text-left">Nama Mahasiswa</th>
                <th class="px-4 py-3 text-left">Tanggal Pengajuan</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Nama Dosen Pembimbing</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($skripsi as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $item->judul_skripsi }}</td>
                    <td class="px-4 py-3">{{ $item->mahasiswa_nama }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <!-- Status -->
                        <span class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                            @if($item->status == 'disetujui') bg-green-200 text-green-800 
                            @elseif($item->status == 'ditolak') bg-red-200 text-red-800 
                            @else bg-yellow-200 text-yellow-800 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $item->dosen_nama }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <!-- Aksi untuk pengajuan yang masih pending -->
                        @if($item->status == 'diajukan')
                            <a href="{{ route('admin.skripsi.approve', $item->id_skripsi) }}" 
                               class="inline-block py-2 px-4 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                               Setujui
                            </a>
                            <a href="{{ route('admin.skripsi.reject', $item->id_skripsi) }}" 
                               class="inline-block py-2 px-4 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                               Tolak
                            </a>
                        @elseif($item->status == 'disetujui')
                            <span class="text-green-600 font-semibold">Disetujui</span>
                        @elseif($item->status == 'ditolak')
                            <span class="text-red-600 font-semibold">Ditolak</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
