@extends('layouts.app')

@section('content')
<div>
    <h1>Daftar Bimbingan</h1>

    @if ($bimbingans->isEmpty())
        <div>
            <p>Tidak ada bimbingan.</p>
        </div>
    @else
        <div>
            @foreach ($bimbingans as $bimbingan)
                <div>
                    <a href="{{ route('bimbingans.show', ['bimbingan_id' => $bimbingan->id_bimbingan]) }}">
                        {{ $bimbingan->skripsi->judul_skripsi }}
                    </a>
                    @role('dosen')
                    <p>Nama Mahasiswa: {{ $bimbingan->mahasiswaBimbingan->nama }}</p>
                    <p>Email: {{ $bimbingan->mahasiswaBimbingan->email }}</p>
                    @endrole
                    
                    @role('mahasiswa')
                    <p>Nama Pembimbing 1: {{ $bimbingan->dosenPembimbing1->nama }}</p>
                    <p>Email Pembimbing 1: {{ $bimbingan->dosenPembimbing1->email }}</p>
                    <p>Nama Pembimbing 2: {{ $bimbingan->dosenPembimbing2->nama }}</p>
                    <p>Email Pembimbing 2: {{ $bimbingan->dosenPembimbing2->email }}</p>
                    @endrole
                    <div>
                        <span>Bimbingan ini sedang berlangsung</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
