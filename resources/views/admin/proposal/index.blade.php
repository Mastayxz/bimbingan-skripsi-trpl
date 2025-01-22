@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold mb-6">Daftar Proposal yang Diajukan</h1>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('proposal.search') }}" method="GET" class="flex items-center mb-6">
            <input type="text" name="keyword" placeholder="Cari berdasarkan NIM" class="px-4 py-2 border rounded-lg w-64"
                value="{{ request('keyword') }}">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 ml-2 rounded-lg">Cari</button>
        </form>
        <!-- Tabel Daftar Proposal -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">No.</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Judul Proposal</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nim Mahasiswa</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Mahasiswa</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">NIP Pembimbing 1</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Pembimbing 1</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Detail</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal as $index => $proposal)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $proposal->judul }}</td>
                            <td class="px-6 py-4">{{ $proposal->mahasiswaProposal->nim }}</td>
                            <td class="px-6 py-4">{{ $proposal->mahasiswaProposal->nama }}</td>
                            <td class="px-6 py-4">{{ $proposal->dosenPembimbing1Proposal->nama }}</td>
                            <td class="px-6 py-4">{{ $proposal->dosenPembimbing1Proposal->nip }}</td>
                            <td class="px-6 py-4"><a href="{{ route('proposal.detail', $proposal->id_proposal) }}"
                                    class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600">
                                    Detail
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <!-- Status -->
                                <span
                                    class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                                    @if ($proposal->status == 'disetujui') bg-green-200 text-green-800 
                                    @elseif($proposal->status == 'ditolak') bg-red-200 text-red-800 
                                    @else bg-yellow-200 text-yellow-800 @endif">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.proposal.edit', $proposal->id_proposal) }}"
                                    class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                    Edit
                                </a>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $proposals->links('pagination::tailwind') }}
    </div> --}}
@endsection
