@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Dashboard Mahasiswa</h1>
    <p>Selamat datang, Mahasiswa. Anda dapat mengakses informasi skripsi Anda di sini.</p>

    <div class="mt-6">
        <h2 class="font-bold text-xl">Skripsi Saya</h2>
        <p class="mt-4">Jika Anda sudah mengajukan skripsi, Anda dapat melanjutkan di sini.</p>
        <ul class="mt-4">
            {{-- @foreach ($skripsi as $skripsiItem)
                <li>{{ $skripsiItem->judul }} - {{ $skripsiItem->status }}</li>
            @endforeach --}}
        </ul>
    </div>
@endsection
