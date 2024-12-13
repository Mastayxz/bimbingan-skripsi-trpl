@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Dashboard Dosen</h1>
    <p>Selamat datang, Dosen. Anda dapat melihat skripsi yang dibimbing oleh Anda di sini.</p>

    <div class="mt-6">
        <h2 class="font-bold text-xl">Skripsi yang Dibimbing</h2>
        <ul class="mt-4">
            {{-- @foreach ($skripsi as $skripsiItem)
                <li>{{ $skripsiItem->judul }}</li>
            @endforeach --}}
        </ul>
    </div>
@endsection
