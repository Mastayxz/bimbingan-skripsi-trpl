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
                <a href="{{ $proposal->file_proposal }}" 
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
        @if ($proposal->status === 'disetujui' || $proposal->status === 'bimbingan')
            <form action="{{ route('proposals.addComment', $proposal->id_proposal) }}" method="POST" class="bg-gray-100 p-4 rounded-lg shadow-md">
            @csrf
            <div class="mb-3">
                <label for="comment" class="block text-sm font-medium text-gray-700">Tambahkan Komentar</label>
                <textarea name="komentar" id="comment" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah Komentar</button>
            </div>
            </form>
        @endif


        <!-- Aksi -->
        <div class="mt-4 space-x-2">
            @if($proposal->status == 'diajukan')
                <button onclick="openApproveModal({{ $proposal->id_proposal }})" class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">
                    Setujui
                </button>
                <button onclick="openRejectModal({{ $proposal->id_proposal }})" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">
                    Tolak
                </button>
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

<!-- Modal Approve -->
<div id="approveModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <form id="approveForm" method="POST">
            @csrf
            @method('PUT')

            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Setujui Proposal</h2>
                <textarea name="komentar" class="w-full border-gray-300 rounded p-2" rows="3" placeholder="Masukkan komentar..." required></textarea>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeModal('approveModal')" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                    <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">Setujui</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')

            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Tolak Proposal</h2>
                <textarea name="komentar" class="w-full border-gray-300 rounded p-2" rows="3" placeholder="Masukkan komentar..." required></textarea>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeModal('rejectModal')" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                    <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">Tolak</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(id) {
        const modal = document.getElementById('approveModal');
        const form = document.getElementById('approveForm');
        form.action = `/dosen/proposal/approve/${id}`; // Atur action sesuai ID proposal
        modal.classList.remove('hidden');
    }

    function openRejectModal(id) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/dosen/proposal/reject/${id}`; // Atur action sesuai ID proposal
        modal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>

@endsection
