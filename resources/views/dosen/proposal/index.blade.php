@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb :links="[
        'Dashboard' => route('dashboard.dosen'),
        'Daftar Proposal' => route('dosen.proposal.index'),
    ]" />
@endsection


@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-semibold mb-6 dark:text-white  ">Daftar Proposal yang Diajukan</h1>

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
                            <td class="px-6 py-4 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
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
                                    <span class="px-2 py-1 bg-blue-500 text-white rounded">Diajukan</span>
                                @elseif ($proposal->status === 'revisi')
                                    <span class="px-2 py-1 bg-yellow-500 text-white rounded">Revisi</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-gray-500 text-white rounded">{{ ucfirst($proposal->status) }}</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $proposals->links('pagination::tailwind') }}
    </div> --}}
    </div>
@endsection
