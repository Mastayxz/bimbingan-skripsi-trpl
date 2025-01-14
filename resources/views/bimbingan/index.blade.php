@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Bimbingan</h1>

    @if ($bimbingans->isEmpty())
        <div class="text-center text-gray-500">
            <p>Tidak ada bimbingan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($bimbingans as $bimbingan)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <a href="{{ route('bimbingans.show', ['bimbingan_id' => $bimbingan->id_bimbingan]) }}" class="block text-gray-800 hover:text-blue-800 font-semibold text-lg mb-2">
                        {{ $bimbingan->skripsi->judul_skripsi }}
                    </a>
                    @role('dosen')
                    <p class="text-gray-600 text-sm">Nama Mahasiswa: {{ $bimbingan->mahasiswaBimbingan->nama }}</p>
                    <p class="text-gray-600 text-sm">Email: {{ $bimbingan->mahasiswaBimbingan->email }}</p>
                    <p class="text-gray-600 text-sm">Telepon: {{ $bimbingan->mahasiswaBimbingan->telepon }}</p>

                    @endrole
                    @role('mahasiswa')
                    <p class="text-gray-600 text-sm">Nama Pembimbing 1: {{ $bimbingan->dosenPembimbing1->nama }}</p>
                    <p class="text-gray-600 text-sm">Email Pembimbing 1: {{ $bimbingan->dosenPembimbing1->email }}</p>
                    <p class="text-gray-600 text-sm">Nama Pembimbing 2: {{ $bimbingan->dosenPembimbing2->nama }}</p>
                    <p class="text-gray-600 text-sm">Email Pembimbing 2: {{ $bimbingan->dosenPembimbing2->email }}</p>
                    @endrole
                    <div class="mt-4">
                        <span class="text-xs text-gray-500">Bimbingan ini sedang berlangsung</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
