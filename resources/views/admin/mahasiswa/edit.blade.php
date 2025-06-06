@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Edit Dosen</h2>
        <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nip" class="block text-gray-700 text-sm font-bold mb-2">NIP:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="nip" name="nim" value="{{ $mahasiswa->nim }}" readonly>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="nama" name="nama" value="{{ $mahasiswa->nama }}">
            </div>

            <div class="mb-4">
                <label for="nidn" class="block text-gray-700 text-sm font-bold mb-2">NIDN:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="nidn" name="tahun_masuk" value="{{ $mahasiswa->tahun_masuk }}" required>
            </div>
            <div class="mb-4">
                <label for="nidn" class="block text-gray-700 text-sm font-bold mb-2">NIDN:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="nidn" name="telepon" value="{{ $mahasiswa->telepon }}">
            </div>


            <div class="mb-4">
                <label for="jurusan" class="block text-gray-700 text-sm font-bold mb-2">Jurusan:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="jurusan" name="jurusan" value="{{ $mahasiswa->jurusan }}">
            </div>

            <div class="mb-4">
                <label for="prodi" class="block text-gray-700 text-sm font-bold mb-2">Prodi:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="prodi" name="prodi" value="{{ $mahasiswa->prodi }}">
            </div>
            <div class="mb-4">
                <label for="prodi" class="block text-gray-700 text-sm font-bold mb-2">email:</label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="prodi" name="email" value="{{ $mahasiswa->email }}">
            </div>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
        </form>
    </div>
@endsection
