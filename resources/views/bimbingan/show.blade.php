@extends('layouts.app')

@section('content')
<div>
    <h1>Detail Bimbingan</h1>

    <!-- Progress Bar -->
    <div>
        <div>
            <div style="width: {{ $progress }}%;"></div>
            <span>{{ number_format($progress, 2) }}%</span>
        </div>
        <p>Progress: {{ number_format($progress, 2) }}%</p>
    </div>

    <!-- Daftar Task -->
    <h2>Daftar Task</h2>
    @if ($tasks->isEmpty())
        <p>Belum ada tugas yang ditambahkan.</p>
    @else
        <ul>
            @foreach ($tasks as $task)
            <li>
                <div>
                    <a href="{{ route('tasks.show', $task->id_task) }}">
                        {{ $task->nama_tugas }}
                    </a>
                    <span>
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
                <p>{{ $task->deskripsi }}</p>

                <!-- File dan Komentar -->
                <div>
                    @if ($task->file_mahasiswa)
                        <p>File Tugas: 
                            <a href="{{ asset('storage/' . $task->file_mahasiswa) }}" target="_blank">Lihat</a>
                        </p>
                    @endif

                    @if ($task->komentar_dosen)
                        <p>Komentar Dosen: <span>{{ $task->komentar_dosen }}</span></p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    @endif

    <!-- Form Tambah Task untuk Mahasiswa -->
    @role('mahasiswa')
    <h2>Tambah Task Baru</h2>
    <form action="{{ route('tasks.store', $bimbingan->id_bimbingan) }}" method="POST" enctype="multipart/form-data">
        @csrf
       {{-- buatin form tambah task, untuk routenya sudah ada tinggal buat formnya, untuk value dan name ada di TaskController --}}
    </form>
    @endrole
</div>
@endsection
