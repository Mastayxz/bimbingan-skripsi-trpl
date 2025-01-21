@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Skripsi Lulus Ujian</h1>

    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Informasi untuk set dosen pembimbing 2 -->
    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-4">
        Pastikan untuk menetapkan Dosen Pembimbing 2 sebelum membuat bimbingan.
    </div>

    <!-- Tabel Pengajuan Skripsi -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">No.</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Judul Skripsi</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIM</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Dosen Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIP Dosen Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Dosen Pembimbing 2</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIP Dosen Pembimbing 2</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    <th scope="col" class="px-6 py-3 text-center">Kelola</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($skripsi as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->judul_skripsi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaSkripsi->nim }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($item->dosenPembimbing2)
                                {{ $item->dosenPembimbing2->nama }}
                            @else
                                <span class="text-gray-500">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->dosenPembimbing2)
                                {{ $item->dosenPembimbing2->nip }}
                            @else
                                <span class="text-gray-500">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            @if ($item->status == 'lulus ujian')
                                <a href="{{ route('admin.skripsi.approve', $item->id_skripsi) }}"
                                    class="inline-block py-2 px-4 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                    Acc Bimbingan
                                </a>
                            @elseif($item->status == 'berjalan')
                                <span class="text-blue-600 font-semibold">berjalan</span>
                            @elseif($item->status == 'selesai')
                                <span class="text-green-600 font-semibold">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($item->dosenPembimbing2)
                                <span class="text-green-600 font-semibold">Pembimbing 2 Ditentukan</span>
                            @else
                                <a href="{{ route('admin.skripsi.edit', $item->id_skripsi) }}"
                                    class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                    Set Pembimbing 2
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
