@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Daftar Dosen</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Dosen -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No.</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">NIP</th>
                    <th class="px-4 py-3 text-left">Jurusan</th>
                    <th class="px-4 py-3 text-left">Prodi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach ($dosen as $dsn)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $dsn->nama }}</td>
                        <td class="px-4 py-3">{{ $dsn->nip }}</td>
                        <td class="px-4 py-3">{{ $dsn->jurusan }}</td>
                        <td class="px-4 py-3">{{ $dsn->prodi }}</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.dosen.edit', $dsn->id) }}" 
                               class="inline-block py-2 px-4 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition duration-200 ease-in-out">
                               Edit
                            </a>
                            <!-- Delete Button -->
                            <a href="{{ route('admin.dosen.delete', $dsn->id) }}" 
                               class="inline-block py-2 px-4 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition duration-200 ease-in-out"
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data dosen ini?')">
                               Delete
                            </a>
                            <!-- Make Admin Button -->
                            <form action="{{ route('dosen.makeAdmin', $dsn->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="py-2 px-4 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition duration-200 ease-in-out">
                                    Jadikan Admin
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $dosen->links('pagination::tailwind') }}
    </div>
</div>
@endsection