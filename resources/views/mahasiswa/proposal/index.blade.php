@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Proposal yang Anda Ajukan</h1>

    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Proposal -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Judul Proposal</th>
                    <th scope="col" class="px-6 py-3">Mahasiswa</th>
                    <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                    <th scope="col" class="px-6 py-3">Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3">NIP Pembimbing 1</th>
                    <th scope="col" class="px-6 py-3">Detail</th>
                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposals as $index => $proposal)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $proposal->judul }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $proposal->mahasiswaProposal->nim }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $proposal->mahasiswaProposal->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $proposal->dosenPembimbing1Proposal->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $proposal->dosenPembimbing1Proposal->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><a
                                href="{{ route('proposal.detail', $proposal->id_proposal) }}"
                                class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600">
                                Detail
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($proposal->status === 'diajukan')
                                <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded-xl">Diajukan</span>
                            @elseif ($proposal->status === 'revisi')
                                <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-xl">Revisi</span>
                            @elseif ($proposal->status === 'disetujui')
                                <span class="px-2 py-1 bg-green-200 text-green-800 rounded-xl">Disetujui</span>
                            @elseif ($proposal->status === 'ikut ujian')
                                <span class="px-2 py-1 bg-orange-200 text-orange-800 rounded-xl">Ikut Ujian</span>
                            @else
                                <span
                                    class="px-2 py-1 bg-gray-500 text-white rounded xl">{{ ucfirst($proposal->status) }}</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $proposals->links('pagination::tailwind') }}
    </div>
@endsection
