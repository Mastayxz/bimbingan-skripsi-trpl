@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Proposal yang Diajukan</h1>

    <!-- Pesan sukses -->
    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50
           dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('proposal.search') }}" method="GET" class="flex items-center mb-6">
        <input type="text" name="keyword" placeholder="Cari berdasarkan NIM" class="px-4 py-2 border rounded-lg w-64"
            value="{{ request('keyword') }}">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 ml-2 rounded-lg">Cari</button>
    </form>
    <!-- Tabel Daftar Proposal -->
    <form action="{{ route('admin.proposal.deleteSelected') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <input type="checkbox" id="select-all" class="select-all">
                        </th>
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
                    @foreach ($proposal as $index => $proposals)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" name="selected_ids[]" value="{{ $proposals->id_proposal }}"
                                    class="select-item">
                            </td>
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $proposals->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proposals->mahasiswaProposal->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proposals->mahasiswaProposal->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proposals->dosenPembimbing1Proposal->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $proposals->dosenPembimbing1Proposal->nip }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><a
                                    href="{{ route('proposal.detail', $proposals->id_proposal) }}"
                                    class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600">
                                    Detail
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <!-- Status -->
                                <span
                                    class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                                    @if ($proposals->status == 'disetujui') bg-green-200 text-green-800 
                                    @elseif($proposals->status == 'ditolak') bg-red-200 text-red-800 
                                    @else bg-yellow-200 @endif">
                                    {{ ucfirst($proposals->status) }}
                                </span>
                            </td>
                            @if ($proposals->status == 'ditolak')
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.proposal.edit', $proposals->id_proposal) }}"
                                        class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                        Edit
                                    </a>
                                </td>
                            @else
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block py-1 px-3 text-sm font-semibold rounded-full bg-gray-200 text-gray-800">
                                        <i class="fas fa-lock w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    </span>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="mt-4 bg-red-500 text-white px-4  py-2 rounded">Hapus yang Dipilih</button>
        </div>
    </form>
    <!-- Pagination -->
    <div class="mt-6">
        {{ $proposal->links('pagination::tailwind') }}
    </div>
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
