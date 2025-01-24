@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6">Tambah Periode Pendaftaran</h2>
        <form action="{{ route('admin.periode.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label for="nama_periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                    Periode</label>
                <input type="text" name="nama_periode" id="nama_periode"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                    Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                    Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="tahun_masuk_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Masuk
                    Minimal</label>
                <input type="number" name="tahun_masuk_min" id="tahun_masuk_min"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="tahun_masuk_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Masuk
                    Maksimal</label>
                <input type="number" name="tahun_masuk_max" id="tahun_masuk_max"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                    Periode</label>
                <select name="status" id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                    <option value="dibuka">Dibuka</option>
                    <option value="ditutup">Ditutup</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-600">Simpan</button>
        </form>
    </div>
@endsection
