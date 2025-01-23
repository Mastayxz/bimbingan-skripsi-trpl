@extends('layouts.app')

@section('content')
    <div class=" dark:bg-gray-900 dark:text-gray-200">
        <h1 class="text-3xl font-semibold mb-6">Detail Proposal</h1>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4 dark:bg-green-900 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Detail Proposal -->
        <div class="bg-white border border-gray-300 shadow-lg rounded-lg p-6 dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-2xl font-semibold mb-4">Judul Proposal</h2>
            <p class="text-gray-700 mb-6 dark:text-gray-300">{{ $proposal->judul }}</p>

            <h3 class="text-xl font-semibold mb-2">Nama Mahasiswa</h3>
            <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $proposal->mahasiswaProposal->nama }}</p>

            <h3 class="text-xl font-semibold mb-2">Pembimbing 1</h3>
            <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $proposal->dosenPembimbing1Proposal->nama }}</p>

            <h3 class="text-xl font-semibold mb-2">File Proposal</h3>
            <p class="text-gray-700 mb-4 dark:text-gray-300">
                @if ($proposal->file_proposal)
                    <a href="{{ $proposal->file_proposal }}" target="_blank"
                        class="text-blue-500 hover:underline dark:text-blue-400">
                        Unduh Proposal
                    </a>
                @else
                    <span class="text-gray-500 dark:text-gray-400">File belum diunggah</span>
                @endif
            </p>

            <!-- Komentar -->
            <div
                class="bg-white border border-gray-300 shadow-lg rounded-lg p-6 mb-6 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4">Komentar</h2>

                @if (count($proposal->listKomentar) > 0)
                    <ul class="list-disc pl-5">
                        @foreach ($proposal->listKomentar as $komentar)
                            <li class="text-gray-700 mb-2 dark:text-gray-300">{{ $komentar }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
                @endif
            </div>

            <h3 class="text-xl font-semibold mb-2">Status</h3>
            <p class="text-gray-700 mb-4 dark:text-gray-300">
                <span
                    class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                @if ($proposal->status == 'disetujui') bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300
                @elseif($proposal->status == 'ditolak') bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-300
                @else bg-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif">
                    {{ ucfirst($proposal->status) }}
                </span>
            </p>

            <!-- Aksi Berdasarkan Peran -->
            @role('mahasiswa')
                @if ($proposal->status === 'revisi' || $proposal->status === 'diajukan')
                    <div class="mt-4">
                        <a href="{{ route('proposals.edit', $proposal->id_proposal) }}"
                            class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600">
                            Perbarui Proposal
                        </a>
                    </div>
                @endif
                <div class="mt-6">
                    <a href="{{ route('proposal.index') }}"
                        class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600">
                        Kembali ke Daftar Proposal
                    </a>
                </div>
            @endrole

            @role('dosen')
                @if ($proposal->status === 'diajukan')
                    <div class="mt-4 space-x-2">
                        <button onclick="openApproveModal({{ $proposal->id_proposal }})"
                            class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600">
                            Setujui
                        </button>
                        <button onclick="openRejectModal({{ $proposal->id_proposal }})"
                            class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600">
                            Tolak
                        </button>
                    </div>
                @elseif ($proposal->status === 'disetujui' || $proposal->status === 'revisi')
                    <button onclick="openRevisiModal({{ $proposal->id_proposal }})"
                        class="py-2 px-4 bg-yellow-500 text-white rounded hover:bg-green-600 dark:bg-yellow-700 dark:hover:bg-yellow-600">
                        Revisi
                    </button>
                    <form action="{{ route('dosen.proposal.ujian', $proposal->id_proposal) }}" method="POST"
                        class="inline-block">
                        @csrf
                        <button type="submit"
                            class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600">
                            Izin Ujian
                        </button>
                    </form>
                @endif
                <div class="mt-6">
                    <a href="{{ route('dosen.proposal.index') }}"
                        class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600">
                        Kembali ke Daftar Proposal
                    </a>
                </div>
            @endrole

            @role('admin')
                <div class="mt-6">
                    <a href="{{ route('admin.proposal.index') }}"
                        class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600">
                        Kembali ke Daftar Proposal Admin
                    </a>
                </div>
            @endrole
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
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('approveModal')"
                            class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                        <button type="submit"
                            class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">Setujui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Revisi -->
    <div id="revisiModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <form id="revisiForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-4">Setujui Proposal</h2>
                    <textarea name="komentar" class="w-full border-gray-300 rounded p-2" rows="3" placeholder="Masukkan komentar..."
                        required></textarea>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('revisiModal')"
                            class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                        <button type="submit"
                            class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">Revisi</button>
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
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('rejectModal')"
                            class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</button>
                        <button type="submit"
                            class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">Tolak</button>
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

        function openRevisiModal(id) {
            const modal = document.getElementById('revisiModal');
            const form = document.getElementById('revisiForm');
            form.action = `/dosen/proposal/${id}/revisi`;
            modal.classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
