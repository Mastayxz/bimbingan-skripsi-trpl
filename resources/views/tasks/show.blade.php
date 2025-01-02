@extends('layouts.app')

@section('content')
<div>
    <!-- Heading Section -->
    <div>
        <h1>Detail Tugas</h1>
        <p>Detail dan pengaturan untuk tugas: {{ $task->nama_tugas }}</p>
    </div>

    <!-- Task Details -->
    <div>
        <h2>Informasi Tugas</h2>
        <p>Deskripsi: {{ $task->deskripsi }}</p>
        <p>Status: {{ $task->status }}</p>
        <p>Komentar Dosen: {{ $task->komentar_dosen ?? 'Belum ada komentar' }}</p>
        <p>
            File Mahasiswa:
            @if ($task->file_mahasiswa)
                <a href="{{ Storage::url($task->file_mahasiswa) }}" target="_blank">Download</a>
            @else
                Belum ada file yang diunggah.
            @endif
        </p>
    </div>

    <!-- Revision History -->
    <div>
        <h2>Riwayat Revisi</h2>
        @if ($task->revisi ?? [])
            <ul>
                @foreach ($task->revisi as $revisi)
                    <li>
                        Status: {{ $revisi['status'] }} <br>
                        Komentar: {{ $revisi['komentar_dosen'] ?? 'Tidak ada' }} <br>
                        Waktu: {{ $revisi['updated_at'] }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Belum ada riwayat revisi.</p>
        @endif
    </div>

    <!-- Edit Form -->
    <div>
        <h2>Edit/Revisi Tugas</h2>
        <form method="POST" action="{{ route('tasks.update', $task->id_task) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Tugas -->
            <div>
                <label for="nama_tugas">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas" value="{{ $task->nama_tugas }}">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi">{{ $task->deskripsi }}</textarea>
            </div>

            @role('mahasiswa')
            <!-- Upload File -->
            <div>
                <label for="file_mahasiswa">Unggah File</label>
                <input type="file" id="file_mahasiswa" name="file_mahasiswa">
            </div>
            @endrole

            @role('dosen')
            <!-- Status -->
            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="menunggu persetujuan" {{ $task->status == 'menunggu persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ $task->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="sedang direvisi" {{ $task->status == 'sedang direvisi' ? 'selected' : '' }}>Sedang Direvisi</option>
                </select>
            </div>

            <!-- Komentar Dosen -->
            <div>
                <label for="komentar_dosen">Komentar Dosen</label>
                <textarea id="komentar_dosen" name="komentar_dosen">{{ $task->komentar_dosen }}</textarea>
            </div>
            @endrole

            <!-- Submit Button -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
