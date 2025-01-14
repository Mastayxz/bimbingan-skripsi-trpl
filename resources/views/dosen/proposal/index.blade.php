@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Daftar Proposal yang Diajukan</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Proposal -->
    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-3 text-left">No.</th>
                <th class="px-4 py-3 text-left">Judul Proposal</th>
                <th class="px-4 py-3 text-left">Nama Mahasiswa</th>
                <th class="px-4 py-3 text-left">Pembimbing 1</th>
                <th class="px-4 py-3 text-left">Detail</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($proposals as $index => $proposal)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $proposal->judul }}</td>
                    <td class="px-4 py-3">{{ $proposal->mahasiswaProposal->nama }}</td>
                    <td class="px-4 py-3">{{ $proposal->dosenPembimbing1Proposal->nama }}</td>
                    <td class="px-4 py-3"><a href="{{ route('dosen.proposal.detail', $proposal->id_proposal) }}" 
                        class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                         Lihat Detail
                     </a>
                 </td>
                    <td class="px-4 py-3 text-center">
                        <!-- Status -->
                        <span class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                            @if($proposal->status == 'disetujui') bg-green-200 text-green-800 
                            @elseif($proposal->status == 'ditolak') bg-red-200 text-red-800 
                            @else bg-yellow-200 text-yellow-800 @endif">
                            {{ ucfirst($proposal->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <!-- Tombol Lihat Detail -->
                        
                        <!-- Aksi untuk pengajuan yang masih pending -->
                        @if($proposal->status == 'diajukan')
                            <!-- Tombol Setujui dengan Modal -->
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <!-- Tombol dengan Icon -->
                                <button @click="open = !open" class="inline-block p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none">
                                    <!-- Icon tiga titik -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <circle cx="12" cy="5" r="1" />
                                        <circle cx="12" cy="12" r="1" />
                                        <circle cx="12" cy="19" r="1" />
                                    </svg>
                                </button>
                            
                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-gray-800 text-white ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <button onclick="openApproveModal({{ $proposal->id_proposal }})" 
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                            Setujui
                                        </button>
                                        <button onclick="openRejectModal({{ $proposal->id_proposal }})" 
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                            Tolak
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        @elseif($proposal->status == 'disetujui')
                            <span class="text-green-600 font-semibold">Disetujui</span>
                        @elseif($proposal->status == 'ditolak')
                            <span class="text-red-600 font-semibold">Ditolak</span>
                        @elseif($proposal->status == 'ikut ujian')
                            <span class="text-yellow-600 font-semibold">ikut ujian</span>
                        @endif
                        <!-- Tombol Aksi dengan Modal -->
                        
                    </td>

                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $proposals->links('pagination::tailwind') }}
    </div> --}}
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
