    @extends('layouts.app')

    @section('content')
        <h1 class="text-3xl font-semibold mb-6 dark:text-white">Daftar Mahasiswa</h1>

        <!-- Butt  on to trigger modal and search input -->
        <div class=" flex items-center space-x-4 my-6">
            <button type="button" onclick="toggleModal()"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sinkronisasi Data Mahasiswa
            </button>
            <form action="{{ route('mahasiswa.search') }}" method="GET" class="flex items-center ">
                <input type="text" name="keyword" placeholder="Cari berdasarkan NIM"
                    class="px-4 py-2 border rounded-lg w-64" value="{{ request('keyword') }}">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 ml-2 rounded-lg">Cari</button>
            </form>
        </div>


        <!-- Modal -->
        <div id="syncModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background Overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <!-- Modal Header -->
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    Sinkronisasi Data Mahasiswa
                                </h3>
                                <div class="mt-2">
                                    <!-- Form -->
                                    <form action="{{ route('sync.mahasiswa') }}" method="POST">
                                        @csrf
                                        <!-- Tahun Akademik Input -->
                                        <label for="tahunAkademik"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                                            Akademik:</label>
                                        <input type="text" name="tahunAkademik" id="tahunAkademik" required
                                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700">

                                        <!-- Buttons -->
                                        <div class="mt-4 flex justify-end">
                                            <!-- Submit Button -->
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Sinkronisasi
                                            </button>
                                            <!-- Cancel Button -->
                                            <button type="button" onclick="toggleModal()"
                                                class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Daftar Mahasiswa -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Tahun Masuk</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">NIM</th>
                        <th scope="col" class="px-6 py-3">Jurusan</th>
                        <th scope="col" class="px-6 py-3">Program studi</th>
                        <th scope="col" class="px-6 py-3">Jenjang</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Telepon</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $mhs)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->tahun_masuk }}</td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">{{ $mhs->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->jurusan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->prodi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->jenjang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->telepon }}</td>
                            <td class="px-6 py-4 text-center space-x-2 relative">
                                <button type="button" onclick="toggleActionModal({{ $mhs->id }})"
                                    class="inline-block py-2 px-4 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700 transition duration-200 ease-in-out">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <!-- Action Modal -->
                                <div id="actionModal-{{ $mhs->id }}"
                                    class="absolute z-10 hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 right-0 top-full mt-2">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                                        Pilih Aksi
                                    </h3>
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}"
                                        class="block py-2 px-4 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition duration-200 ease-in-out mb-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.mahasiswa.delete', $mhs->id) }}"
                                        class="block py-2 px-4 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition duration-200 ease-in-out mb-2"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <button type="button" onclick="toggleActionModal({{ $mhs->id }})"
                                        class="mt-4 w-full py-2 px-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200 ease-in-out">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <script>
                            function toggleActionModal(id) {
                                const modal = document.getElementById(`actionModal-${id}`);
                                modal.classList.toggle('hidden');
                            }
                        </script>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $mahasiswa->appends(['query' => request()->query('query')])->links() }}
        </div>
        </div>

        <script>
            function toggleModal() {
                const modal = document.getElementById('syncModal');
                modal.classList.toggle('hidden');
            }
        </script>
    @endsection
