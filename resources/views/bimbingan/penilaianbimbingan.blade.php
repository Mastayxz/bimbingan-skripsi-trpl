@extends('layouts.app')

@section('content')
<form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="judul_proposal" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Judul Skripsi</label>
        <input type="text" value="{{ $bimbingan->skripsi->judul_skripsi }}" id="judul_proposal" name="judul_proposal" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" readonly>
    </div>
    <div class="mb-4">
        <label for="motivasi" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Motivasi</label>
        <input type="number" id="motivasi" name="motivasi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="kreativitas" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kreativitas</label>
        <input type="number" id="kreativitas" name="kreativitas" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="disiplin" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Disiplin</label>
        <input type="number" id="disiplin" name="disiplin" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="metodologi" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Metodologi</label>
        <input type="number" id="metodologi" name="metodologi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="perencanaan" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Perencanaan</label>
        <input type="number" id="perencanaan" name="perencanaan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="rancangan" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Rancangan</label>
        <input type="number" id="rancangan" name="rancangan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="kesesuaian_rancangan" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kesesuaian Rancangan</label>
        <input type="number" id="kesesuaian_rancangan" name="kesesuaian_rancangan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <div class="mb-4">
        <label for="keberfungsian" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Keberfungsian</label>
        <input type="number" id="keberfungsian" name="keberfungsian" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Submit</button>
</form>
@endsection