    @extends('layouts.app')
    @section('breadcrumb')
        <x-breadcrumb :links="[
            'Dashboard' => route('dashboard.dosen'),
            'Daftar Skripsi' => route('skripsi.index'),
        ]" />
    @endsection
    @section('content')
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Skripsi Bimbingan</h1>

            <!-- Pesan sukses -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Daftar Mahasiswa -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Judul Skripsi</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Pembimbing 1</th>
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Pembimbing 2</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skripsi as $index => $item)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $item->judul_skripsi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaSkripsi->nim }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->mahasiswaSkripsi->nama }}</td>
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
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <!-- Status -->
                                    <span
                                        class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                                    @if ($item->status == 'disetujui') bg-green-200 text-green-800 
                                    @elseif($item->status == 'ditolak') bg-red-200 text-red-800 
                                    @else bg-yellow-200 text-yellow-800 @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{-- <div class="mt-6">
                {{ $mahasiswa->links('pagination::tailwind') }}
            </div> --}}
        </div>
    @endsection
