<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{ __("Welcome, Admin!") }}
            </div>

            <!-- Tabel Daftar Mahasiswa -->
            <div class="mt-6 bg-white overflow-hidden shadow sm:rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900">Daftar Mahasiswa</h3>

                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">NIM</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Jurusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($mahasiswa as $mhs)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $mhs->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $mhs->nim }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $mhs->jurusan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>