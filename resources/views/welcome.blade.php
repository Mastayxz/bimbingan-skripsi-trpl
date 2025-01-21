<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700 shadow-lg">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo Sistem" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SIBIMOLI TRPL</span>
            </a>
            <button data-collapse-toggle="navbar-multi-level" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-multi-level" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto " id="navbar-multi-level">
                <ul
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    @guest
                        <li>
                            <a href="{{ route('login') }}"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
                        </li>
                    @else
                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                                {{ Auth::user()->name }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownNavbar"
                                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownLargeButton">
                                    @role('admin')
                                        <li>
                                            <a href="{{ route('dashboard.admin') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                        </li>
                                    @endrole
                                    @role('mahasiswa')
                                        <li>
                                            <a href="{{ route('dashboard.mahasiswa') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                        </li>
                                    @endrole
                                    @role('dosen')
                                        <li>
                                            <a href="{{ route('dashboard.dosen') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                        </li>
                                    @endrole
                                </ul>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endguest
                    <li>
                        <button id="theme-toggle"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            <i id="theme-toggle-icon" class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                SIBIMOLI TRPL - Mendampingi Langkah Anda Menuju Kelulusan</h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Di
                SIBIMOLI TRPL, kami hadir untuk memudahkan proses bimbingan skripsi Anda. Dengan teknologi yang
                inovatif, kami membantu Anda merancang, mengelola, dan menyelesaikan skripsi secara efisien, hingga
                mencapai kesuksesan akademik..</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="#"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Mulai
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
                <a href="#"
                    class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Pelajari lebih lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Hero and Carousel Section -->
    <section class="py-10 z-0">
        <div class="w-full h-full">
            <div id="animation-carousel" class="relative w-full" data-carousel="static">
                <!-- Carousel wrapper -->
                <div class="relative h-[600px] overflow-hidden md:h-[700px]">
                    <!-- Item 1 -->
                    <div class="hidden duration-200 ease-linear" data-carousel-item>
                        <img src="{{ asset('images/foto_login.jpg') }}"
                            class="absolute block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-200 ease-linear" data-carousel-item>
                        <img src="{{ asset('images/foto_login.jpg') }}"
                            class="absolute block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-200 ease-linear" data-carousel-item="active">
                        <img src="{{ asset('images/foto_login.jpg') }}"
                            class="absolute block w-full h-full object-cover" alt="...">
                    </div>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </section>



    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Fitur Unggulan</h2>
                <p class="text-gray-600">Berikut adalah beberapa fitur unggulan yang kami tawarkan</p>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-chalkboard-teacher text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Bimbingan Online</h3>
                        <p class="text-gray-600">Dapatkan bimbingan secara online dari dosen pembimbing Anda kapan saja
                            dan di mana saja.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-file-alt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Manajemen Dokumen</h3>
                        <p class="text-gray-600">Kelola dokumen skripsi Anda dengan mudah dan terorganisir.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-calendar-alt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Jadwal Bimbingan</h3>
                        <p class="text-gray-600">Atur jadwal bimbingan dengan dosen pembimbing Anda secara efisien.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Panduan Singkat</h2>
                <div class="text-gray-600 flex flex-row justify-center p-4">
                    <div class="border-b-2 border-transparent hover:border-b-2 hover:border-blue-500 pl-4 pr-4 transition-all duration-200"><a href="javascript:void(0)" onclick="showSection('mendapatkanAkun')">Masuk Sistem</a></div>
                    <div class="border-b-2 border-transparent hover:border-b-2 hover:border-blue-500 pl-4 pr-4 transition-all duration-200"><a href="javascript:void(0)" onclick="showSection('masukSistem')">Manajemen Profile</a></div>
                    <div class="border-b-2 border-transparent hover:border-b-2 hover:border-blue-500 pl-4 pr-4 transition-all duration-200"><a href="javascrript:void(0)" onclick="showSection('bukuPanduan')">Buku Panduan</a></div>
                </div>
                <hr class="border-t-2 border-gray-200 my-4">
            </div>
                <div id="mendapatkanAkun" class="content-section hidden opacity-0 transform -translate-x-full transition-all duration-500 ease-in-out mt-5 p-6 ">
                      <div class="bg-white rounded shadow">
                        <div class="flex items-center">
                            <div class="w-1 md:h-40 bg-blue-400 md:ml-10"></div>
                            <div class="block w-full">
                                <div class="rounded-b-lg w-full max-w-4xl shadow-lg mb-8 mx-auto mt-8 px-6 md:px-12 lg:mx-20">
                                    <div class="h-10 bg-blue-400 text-white flex items-center pl-6">
                                        <h1 class="font-bold text-lg md:text-xl">Pilih menu Login</h1>
                                    </div>
                                    <p class="text-gray-600 p-6 md:p-8 text-base md:text-lg">
                                        Buka Website Sibimoli dan klik 
                                        <a href="{{ route('login') }}" 
                                        class="border border-blue-400 bg-blue-400 px-4 py-2 text-white rounded shadow hover:bg-blue-500 transition-all duration-200 block md:inline">
                                        Login
                                        </a>
                                    </p>
                                </div>
                                <div class="rounded-b-lg w-full max-w-4xl shadow-lg mb-8 mx-auto mt-8 px-6 md:px-12 lg:mx-20">
                                        <div class="h-12 bg-blue-400 text-white flex items-center pl-6">
                                            <h1 class="font-bold text-lg md:text-xl">Isi data sesuai dengan role</h1>
                                        </div>
                                        <ul class="list-disc list-inside text-gray-600 p-6 md:p-8 text-base md:text-lg leading-relaxed">
                                            <li>Untuk <span class="font-bold text-blue-600">Mahasiswa</span>, masukkan NIM dan Password dimana password sesuai dengan NIM.</li>
                                            <li>Untuk <span class="font-bold text-blue-600">Dosen</span>, masukkan NIP dan Password dimana password sesuai dengan NIP.</li>
                                            <li>Kemudian klik tombol <span class="font-bold text-blue-600">Login</span>.</li>
                                        </ul>
                                </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div id="masukSistem" class="content-section hidden opacity-0 transform -translate-x-full transition-all duration-500 ease-in-out mt-5 p-6 ">
                   <div class="bg-white rounded shadow">
                        <div class="flex items-center">
                            <div class="w-1 md:h-40 bg-blue-400 ml-10"></div>
                            <div class="block w-full">

                                <div class="rounded-b-lg w-full max-w-4xl shadow-lg mb-8 mx-auto mt-8 px-6 md:px-12 lg:mx-20">
                                    <div class="h-10 bg-blue-400 text-white flex items-center pl-6">
                                        <h1 class="font-bold text-lg md:text-xl">Pilih Nama User</h1>
                                    </div>
                                    <p class="text-gray-600 p-6 md:p-8 text-base md:text-lg">
                                        Pilih Nama User pada dashboard, akan muncul halaman editing profile.
                                    </p>
                                </div>

                                <div class="rounded-b-lg w-full max-w-4xl shadow-lg mb-8 mx-auto mt-8 px-6 md:px-12 lg:mx-20">
                                    <div class="h-10 bg-blue-400 text-white flex items-center pl-6">
                                        <h1 class="font-bold text-lg md:text-xl">Updite Profile User</h1>
                                    </div>
                                        <ul class="list-disc list-inside text-gray-600 p-6 md:p-8 text-base md:text-lg leading-relaxed">
                                            <li>Untuk <span class="font-bold text-blue-600">Mahasiswa</span>, ganti sesuai dengan data pribadi mahasiswa.</li>
                                            <li>Untuk <span class="font-bold text-blue-600">Dosen</span>, ganti sesuai dengan data pribadi dosen.</li>
                                            <li>Kemudian klik tombol <span class="font-bold text-blue-600">Save</span>.</li>
                                        </ul>
                                    </p>
                                </div>

                                <div class="rounded-b-lg w-full max-w-4xl shadow-lg mb-8 mx-auto mt-8 px-6 md:px-12 lg:mx-20">
                                    <div class="h-12 bg-blue-400 text-white flex items-center pl-6">
                                        <h1 class="font-bold text-lg md:text-xl">Updite Password</h1>
                                    </div>
                                        <ul class="list-disc list-inside text-gray-600 p-6 md:p-8 text-base md:text-lg leading-relaxed">
                                            <li>Inpukan Password Lama.</li>
                                            <li>Inputkan Password Baru.</li>
                                            <li>Inputkan Password yang Baru Untuk Melakukan Confrim Password.</li>
                                            <li>Kemudian klik tombol <span class="font-bold text-blue-600">Updite</span>.</li>
                                        </ul>
                                </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div id="bukuPanduan" class="content-section hidden opacity-0 transform -translate-x-full transition-all duration-500 ease-in-out mt-5 p-6 ">
                    <div class="bg-white rounded shadow">
                        pdf
                    </div>
                </div>
            
            
        </div>
    </section>

        
</body>
<script>
            function showSection(sectionId){
                // Sembunyikan semua section
                document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden','opacity-0', 'translate-x-full');
                section.classList.remove('opacity-100','translate-x-ful')
            });
            // Tampilkan section yang sesuai dengan id yang diklik
                const section = document.getElementById(sectionId)
                section.classList.remove('hidden')
                setTimeout(()=>{
                    section.classList.remove('opacity-0','translate-x-full')
                    section.classList.add('opacity-100','translate-x-0')
                },50);
            }
</script>
<style>
    .hidden{
        display: none;
    }
</style>
</html>
