@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Skripsi Lulus Ujian</h1>

    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50
         dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('skripsi.search') }}" method="GET" class="flex items-center mb-6">
        <input type="text" name="keyword" placeholder="Cari berdasarkan NIM/NIP" class="px-4 py-2 border rounded-lg w-64"
            value="{{ request('keyword') }}">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 ml-2 rounded-lg">Cari</button>
    </form>

    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
        role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Penting!</span> Pastikan Untuk Set pembimbing 2 sebelum acc bimbingan.
        </div>
    </div>

    <!-- Tabel Pengajuan Skripsi -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">No.</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Judul Skripsi</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIM</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Mahasiswa</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Dosen Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIP Dosen Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Dosen Pembimbing 2</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">NIP Dosen Pembimbing 2</th>
                    <th scope="col" class="px-6 py-3 text-center">Keterangan</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaSkripsi->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->dosenPembimbing1->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($item->dosenPembimbing2)
                                {{ $item->dosenPembimbing2->nip }}
                            @else
                                <span class="text-gray-500">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($item->dosenPembimbing2)
                                {{ $item->dosenPembimbing2->nama }}
                            @else
                                <span class="text-gray-500">Belum ditentukan</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                            @if ($item->dosenPembimbing2)
                                <!-- Only show "Acc Bimbingan" if Pembimbing 2 is set -->
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
                            @else
                                <span class="text-gray-500">Pembimbing 2 belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap ">
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

                    <!-- Modal -->
                @endforeach
            </tbody>



        </table>

        <div class="mt-6">
            {{ $skripsi->links('pagination::tailwind') }}
        </div>
        <!-- Pagination -->

    </div>
@endsection
