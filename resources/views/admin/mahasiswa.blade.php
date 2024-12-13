@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Daftar Mahasiswa</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Mahasiswa -->
    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-3 text-left">No.</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">NIM</th>
                <th class="px-4 py-3 text-left">Jurusan</th>
                {{-- <th class="px-4 py-3 text-left">Email</th> --}}
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($mahasiswa as $mhs)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $mhs->nama }}</td>
                    <td class="px-4 py-3">{{ $mhs->nim }}</td>
                    <td class="px-4 py-3">{{ $mhs->jurusan }}</td>
                    {{-- <td class="px-4 py-3">{{ $mhs->email }}</td> --}}
                    <td class="px-4 py-3 text-center space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" 
                           class="inline-block py-2 px-4 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition duration-200 ease-in-out">
                           Edit
                        </a>
                    
                        <!-- Delete Button -->
                        <a href="{{ route('admin.mahasiswa.delete', $mhs->id) }}" 
                           class="inline-block py-2 px-4 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition duration-200 ease-in-out"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?')">
                           Delete
                        </a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $mahasiswa->links('pagination::tailwind') }}
    </div>
</div>
@endsection
