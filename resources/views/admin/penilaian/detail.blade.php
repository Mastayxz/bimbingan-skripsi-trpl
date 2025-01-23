@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Penilaian Bimbingan</h1>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50
                dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Daftar Penilaian -->


        <form action="{{ route('admin.penilaian.lockSelected') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex justify-end">
                <button type="submit" class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">
                    Kunci
                </button>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <input type="checkbox" id="select-all" class="select-all">
                            </th>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">NIP Dosen</th>
                            <th scope="col" class="px-6 py-3">Nama Dosen</th>
                            <th scope="col" class="px-6 py-3">Motivasi</th>
                            <th scope="col" class="px-6 py-3">Kreativitas</th>
                            <th scope="col" class="px-6 py-3">Disiplin</th>
                            <th scope="col" class="px-6 py-3">Metodologi</th>
                            <th scope="col" class="px-6 py-3">Perencanaan</th>
                            <th scope="col" class="px-6 py-3">Rancangan</th>
                            <th scope="col" class="px-6 py-3">Kesesuaian Rancangan</th>
                            <th scope="col" class="px-6 py-3">Keberfungsian</th>
                            <th scope="col" class="px-6 py-3">Total Nilai</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penilaian as $nilai)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="selected_ids[]" value="{{ $nilai->id }}"
                                        class="select-item">
                                </td>
                                <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->dosen->nip }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->dosen->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->motivasi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->kreativitas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->disiplin }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->metodologi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->perencanaan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->rancangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->kesesuaian_rancangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->keberfungsian }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->jumlah_skor }}</td>
                                <td class="px-6 py-4">
                                    @if ($nilai->status == 'Terbuka')
                                        <a href="{{ route('admin.penilaian.lock', $nilai->id) }}"
                                            class="inline-block py-2 px-4 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                            Kunci
                                        </a>
                                    @elseif($nilai->status == 'Terkunci')
                                        <span class="text-red-600 font-semibold">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </form>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.penilaian.index') }}"
            class="inline-block py-2 px-4 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600">
            Kembali
        </a>
    </div>
    </div>
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection
