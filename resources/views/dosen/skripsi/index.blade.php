<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="mt-6">
        <h3 class="text-lg font-semibold">Data Skripsi yang Disetujui</h3>

        <table class="min-w-full mt-4 table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Judul Skripsi</th>
                    <th class="px-4 py-2 border">Mahasiswa</th>
                    <th class="px-4 py-2 border">Dosen Pembimbing Lainnya</th>
                    <th class="px-4 py-2 border">Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($skripsi as $index => $s)
                    <tr>
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $s->judul_skripsi }}</td>
                        <td class="px-4 py-2 border">{{ $s->mahasiswa->nama }}</td>
                        <td class="px-4 py-2 border">
                            @if ($s->dosen_pembimbing_1_id == Auth::id())
                                {{ $s->dosenPembimbing2->nama }}
                            @else
                                {{ $s->dosenPembimbing1->nama }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border">{{ $s->tanggal_pengajuan->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
