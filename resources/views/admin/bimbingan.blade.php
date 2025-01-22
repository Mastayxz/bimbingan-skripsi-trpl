@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List Bimbingan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Judul Skripsi</th>
                    <th>Dosen Pembimbing</th>
                    <th>Tanggal Bimbingan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bimbingan as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->nama_mahasiswa }}</td>
                        <td>{{ $item->judul_skripsi }}</td>
                        <td>{{ $item->dosen_pembimbing }}</td>
                        <td>{{ $item->tanggal_bimbingan }}</td>
                        <td>
                            <a href="{{ route('bimbingan.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('bimbingan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
