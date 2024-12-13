@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Bimbingan Skripsi</h1>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Skripsi</th>
                <th>Status Bimbingan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bimbingans as $bimbingan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bimbingan->skripsi->judul_skripsi }}</td>
                    <td>{{ ucfirst($bimbingan->status_bimbingan) }}</td>
                    <td>
                        <a href="{{ route('bimbingan.show', $bimbingan->id_bimbingan) }}" class="btn btn-primary">Lihat Bimbingan</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
