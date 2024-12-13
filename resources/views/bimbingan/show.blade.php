@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Bimbingan Skripsi</h1>

    <div class="card">
        <div class="card-header">
            <h3>Task Bimbingan: {{ $bimbingan->task_name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Status Task:</strong> {{ ucfirst($bimbingan->status_task) }}</p>

            @if($bimbingan->status_task == 'selesai')
                <p><strong>Task ini sudah selesai.</strong></p>
            @elseif($bimbingan->status_task == 'sedang_dikerjakan')
                <p><strong>Task sedang dikerjakan.</strong></p>
            @else
                <form action="{{ route('bimbingan.uploadLink', $bimbingan->id_bimbingan) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="link_file">Link File</label>
                        <input type="url" name="link_file" class="form-control" value="{{ old('link_file') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="task_name">Nama Task</label>
                        <input type="text" name="task_name" class="form-control" value="{{ $bimbingan->task_name }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload Link File</button>
                </form>
            @endif
        </div>
    </div>

    <hr>

    <h3>Tanggapan Dosen</h3>
    <div class="card">
        <div class="card-body">
            @if($bimbingan->tanggapan_dosen)
                <p><strong>{{ $bimbingan->tanggapan_dosen }}</strong></p>
            @else
                <p><i>Dosen belum memberikan tanggapan.</i></p>
            @endif
        </div>
    </div>

    <hr>

    <h3>Update Status Bimbingan</h3>
    <form action="{{ route('bimbingan.update', $bimbingan->id_bimbingan) }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="status_bimbingan">Status Bimbingan</label>
            <select name="status_bimbingan" class="form-control">
                <option value="sedang berjalan" {{ $bimbingan->status_bimbingan == 'sedang berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                <option value="selesai" {{ $bimbingan->status_bimbingan == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status_task">Status Task</label>
            <select name="status_task" class="form-control">
                <option value="belum_dikerjakan" {{ $bimbingan->status_task == 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                <option value="sedang_dikerjakan" {{ $bimbingan->status_task == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="selesai" {{ $bimbingan->status_task == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update Status</button>
    </form>
</div>
@endsection
