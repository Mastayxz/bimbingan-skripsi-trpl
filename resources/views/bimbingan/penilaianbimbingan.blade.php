@extends('layouts.app')

@section('content')
<form action="">
    <h1 class="block text-2xl text-gray-700 dark:text-gray-300 font-bold mb-2">Form Penilaian</h1>
    <div class="mb-4">
        <label for="judul_proposal" class="block text-gray-700 dark:text-gray-300 font-bold mb-2 text-xl">Judul Skripsi</label>
        <input type="text" value="{{ $bimbingan->skripsi->judul_skripsi }}" id="judul_proposal" name="judul_proposal" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" readonly style="white-space: normal;">
    </div>
</form>
<form action="{{ route('penilaian.store', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data" class="max-w-lg ">
    @csrf
    @foreach(['motivasi', 'kreativitas', 'disiplin', 'metodologi', 'perencanaan', 'rancangan', 'kesesuaian_rancangan', 'keberfungsian'] as $field)
        <div class="mb-4">
            <label for="{{ $field }}" class="block text-gray-700 dark:text-gray-300 font-bold mb-2 text-sm">{{ ucfirst($field) }}</label>
            <div class="flex items-center">
                <button type="button" onclick="decrement('{{ $field }}', 10)" class="px-3 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-l-lg">-10</button>
                <button type="button" onclick="decrement('{{ $field }}', 1)" class="px-3 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300">-1</button>
                <input type="number" id="{{ $field }}" name="{{ $field }}" max="100" class="w-full px-3 py-2 border-t border-b border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 text-center" readonly>
                <button type="button" onclick="increment('{{ $field }}', 1)" class="px-3 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300">+1</button>
                <button type="button" onclick="increment('{{ $field }}', 10)" class="px-3 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-r-lg">+10</button>
            </div>
        </div>
    @endforeach
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Submit</button>
</form>

<script>
    function increment(field, amount) {
        var input = document.getElementById(field);
        var value = parseInt(input.value) || 0;
        if (value + amount <= 100) {
            input.value = value + amount;
        } else {
            input.value = 100;
        }
    }

    function decrement(field, amount) {
        var input = document.getElementById(field);
        var value = parseInt(input.value) || 0;
        if (value - amount >= 0) {
            input.value = value - amount;
        } else {
            input.value = 0;
        }
    }
</script>
@endsection