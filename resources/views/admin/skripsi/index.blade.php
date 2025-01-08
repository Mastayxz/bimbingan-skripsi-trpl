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
                <th class="px-4 py-3 text-left">Nama Dosen Pembimbing 1</th>
                <th class="px-4 py-3 text-left">Nama Dosen Pembimbing 2</th>
                <th class="px-4 py-3 text-center">Aksi</th>
                <th class="px-4 py-3 text-center">Kelola</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($skripsi as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $item->judul_skripsi }}</td>
                    <td class="px-4 py-3">{{ $item->mahasiswaSkripsi->nama }}</td>
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
                    <td class="px-4 py-3">{{ $item->dosenPembimbing1->nama }}</td>
                    <td class="px-4 py-3">
                        @if($item->dosenPembimbing2)
                            {{ $item->dosenPembimbing2->nama }}
                        @else
                            <span class="text-gray-500">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <!-- Aksi untuk pengajuan yang masih pending -->
                        @if($item->status == 'berjalan')
                            <a href="{{ route('admin.skripsi.approve', $item->id_skripsi) }}" 
                               class="inline-block py-2 px-4 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                               Acc Bimbingan
                            </a>
                        @elseif($item->status == 'selesai')
                            <span class="text-green-600 font-semibold">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.skripsi.edit', $item->id_skripsi) }}" 
                           class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                           Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
