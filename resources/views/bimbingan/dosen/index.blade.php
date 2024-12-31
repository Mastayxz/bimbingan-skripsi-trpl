@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Bimbingan Anda</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Judul Skripsi</th>
                <th>Mahasiswa</th>
                <th>Tanggal Bimbingan</th>
                <th>Status</th>
                <th>Task</th> <!-- Kolom untuk link ke halaman task -->
            </tr>
        </thead>
        <tbody>
            @foreach ($bimbingans as $bimbingan)
                <tr>
                    <td>{{ $bimbingan->skripsi->judul_skripsi }}</td>
                    <td>{{ $bimbingan->mahasiswa->nama }}</td>
                    <td>{{ $bimbingan->tanggal_bimbingan }}</td>
                    <td>{{ $bimbingan->status_bimbingan }}</td>
                    <!-- Link menuju halaman task untuk bimbingan tertentu -->
                    <td><a href="{{ route('tasks.index', $bimbingan->id_bimbingan) }}">Lihat Task</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
