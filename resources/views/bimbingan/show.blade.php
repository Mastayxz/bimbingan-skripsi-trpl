@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 dark:text-white">Detail Bimbingan</h1>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="w-full bg-gray-700 rounded-full h-4 relative">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
                    <span
                        class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-gray-100">{{ number_format($progress, 2) }}%</span>
                </div>
                <p class="text-sm text-gray-400 mt-2">Progress: {{ number_format($progress, 2) }}%</p>
            </div>

            <!-- Daftar Task -->
            <h2 class="text-xl font-semibold mb-4">Daftar Tugas</h2>
            @if ($tasks->isEmpty())
                <p class="text-gray-400">Belum ada tugas yang diunggah mahasiswa.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($tasks as $task)
                        <li class="border p-4 rounded-lg shadow-sm bg-gray-700">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('tasks.show', $task->id_task) }}"
                                    class="font-semibold text-blue-400 hover:underline">
                                    {{ $task->nama_tugas }}
                                </a>
                                <span
                                    class="px-3 py-1 rounded-full text-sm text-white 
                        {{ $task->status == 'selesai' ? 'bg-green-500' : ($task->status == 'dikerjakan' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-300 mt-2">{{ $task->deskripsi }}</p>

                            <!-- File dan Komentar -->
                            <div class="mt-3">
                                @if ($task->file_mahasiswa)
                                    <p class="text-sm">File Tugas:
                                        <a href="{{ asset('storage/' . $task->file_mahasiswa) }}" target="_blank"
                                            class="text-blue-400 hover:text-blue-600">Lihat</a>
                                    </p>
                                @endif

                                @if ($task->komentar_dosen)
                                    <p class="text-sm mt-2">Komentar Dosen: <span
                                            class="italic text-gray-300">{{ $task->komentar_dosen }}</span></p>
                                @endif

                                @if ($task->file_feedback_dosen)
                                    <p class="text-sm mt-2">Feedback Dosen:
                                        <a href="{{ asset('storage/' . $task->file_feedback_dosen) }}" target="_blank"
                                            class="text-blue-400 hover:text-blue-600">Lihat</a>
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @role('dosen')
                <!-- Menampilkan Pembimbing 1 -->
                <h3 class="font-semibold text-lg mt-4   ">Pembimbing 1:</h3>
                <p class="text-sm">
                    @if ($bimbingan->dosen_pembimbing_1 == Auth::user()->dosen->id)
                        Anda adalah Pembimbing 1.
                    @else
                        Pembimbing 1 adalah {{ $bimbingan->dosenPembimbing1->nama }}
                    @endif
                </p>
                <p>Status:
                    @if ($bimbingan->status_pembimbing_1 === 'selesai')
                        <span class="text-green-500">Selesai</span>
                    @else
                        <span class="text-yellow-500">Belum Selesai</span>
                    @endif
                </p>

                <!-- Tombol Pembimbing 1 -->
                @if (Auth::user()->dosen->id == $bimbingan->dosen_pembimbing_1 && $bimbingan->status_pembimbing_1 !== 'selesai')
                    <form
                        action="{{ route('bimbingan.setStatusSelesai', ['id_bimbingan' => $bimbingan->id_bimbingan, 'pembimbing' => 1]) }}"
                        method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-800">
                            Tandai Bimbingan Selesai Pembimbing 1
                        </button>
                    </form>
                @elseif ($bimbingan->status_pembimbing_1 === 'selesai')
                    <p class="text-sm text-green-500">Bimbingan Selesai oleh Pembimbing 1</p>
                @endif

                <!-- Menampilkan Pembimbing 2 -->
                <h3 class="font-semibold text-lg mt-4">Pembimbing 2:</h3>
                <p class="text-sm">
                    @if ($bimbingan->dosen_pembimbing_2 == Auth::user()->dosen->id)
                        Anda adalah Pembimbing 2.
                    @else
                        Pembimbing 2 adalah {{ $bimbingan->dosenPembimbing2->nama }}
                    @endif
                </p>
                <p>Status:
                    @if ($bimbingan->status_pembimbing_2 === 'selesai')
                        <span class="text-green-500">Selesai</span>
                    @else
                        <span class="text-yellow-500">Belum Selesai</span>
                    @endif
                </p>

                <!-- Tombol Pembimbing 2 -->
                @if (Auth::user()->dosen->id == $bimbingan->dosen_pembimbing_2 && $bimbingan->status_pembimbing_2 !== 'selesai')
                    <form
                        action="{{ route('bimbingan.setStatusSelesai', ['id_bimbingan' => $bimbingan->id_bimbingan, 'pembimbing' => 2]) }}"
                        method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-800">
                            Tandai Bimbingan Selesai Pembimbing 2
                        </button>
                    </form>
                @elseif ($bimbingan->status_pembimbing_2 === 'selesai')
                    <p class="text-sm text-green-500">Bimbingan Selesai oleh Pembimbing 2</p>
                @endif

                <!-- Jika kedua pembimbing sudah selesai, status bimbingan dianggap selesai -->
                @if ($bimbingan->status_bimbingan == 'selesai')
                    <p class="text-lg font-semibold text-blue-500 mt-4">Bimbingan Selesai</p>
                    <div class="mt-6">
                        <a href="{{ route('penilaian.createFromBimbingan', $bimbingan->id_bimbingan) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-800">
                            Form Penilaian
                        </a>
                    </div>
                @endif
            @endrole
            <!-- Tombol Tambah Task untuk Mahasiswa -->
            @role('mahasiswa')
                <div class="mt-6">
                    <a href="{{ route('tasks.create', $bimbingan->id_bimbingan) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-800">
                        Tambah Tugas Baru
                    </a>
                </div>
            @endrole
        </div>
        <div class="mt-6">
            <a href="{{ route('bimbingan.index') }}" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali ke Daftar Bimbingan
            </a>
        </div>
    </div>
@endsection
