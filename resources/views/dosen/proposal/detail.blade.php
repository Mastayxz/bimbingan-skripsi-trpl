@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Detail Proposal</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Detail Proposal -->
    <div class="bg-white border border-gray-300 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Judul Proposal</h2>
        <p class="text-gray-700 mb-6">{{ $proposal->judul }}</p>

        <h3 class="text-xl font-semibold mb-2">Nama Mahasiswa</h3>
        <p class="text-gray-700 mb-4">{{ $proposal->mahasiswaProposal->nama }}</p>

        <h3 class="text-xl font-semibold mb-2">Pembimbing 1</h3>
        <p class="text-gray-700 mb-4">{{ $proposal->dosenPembimbing1Proposal->nama }}</p>

        <h3 class="text-xl font-semibold mb-2">File Proposal</h3>
        <p class="text-gray-700 mb-4">
            @if($proposal->file_proposal)
                <a href="{{ asset('storage/' . $proposal->file_proposal) }}" 
                   target="_blank" 
                   class="text-blue-500 hover:underline">
                   Unduh Proposal
                </a>
            @else
                <span class="text-gray-500">File belum diunggah</span>
            @endif
        </p>

        <h3 class="text-xl font-semibold mb-2">Status</h3>
        <p class="text-gray-700 mb-4">
            <span class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                @if($proposal->status == 'disetujui') bg-green-200 text-green-800 
                @elseif($proposal->status == 'ditolak') bg-red-200 text-red-800 
                @else bg-yellow-200 text-yellow-800 @endif">
                {{ ucfirst($proposal->status) }}
            </span>
        </p>

        <h3 class="text-xl font-semibold mb-2">Komentar</h3>
        <p class="text-gray-700 mb-6">{{ $proposal->komentar ?? 'Belum ada komentar' }}</p>

        <!-- Aksi -->
        <div class="mt-4 space-x-2">
            @if($proposal->status == 'diajukan')
                <form action="{{ route('dosen.proposal.approve', $proposal->id_proposal) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">
                        Setujui
                    </button>
                </form>
                <form action="{{ route('dosen.proposal.reject', $proposal->id_proposal) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">
                        Tolak
                    </button>
                </form>
            @endif
            @if($proposal->status == 'disetujui')
                <form action="{{ route('dosen.proposal.ujian', $proposal->id_proposal) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Ikut Ujian
                    </button>
                </form>
            @elseif($proposal->izin_ujian)
                <span class="text-blue-600 font-semibold">Izin Ujian Diberikan</span>
            @endif
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="{{ route('dosen.proposal.index') }}" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600">
            Kembali ke Daftar Proposal
        </a>
    </div>
</div>

@endsection
