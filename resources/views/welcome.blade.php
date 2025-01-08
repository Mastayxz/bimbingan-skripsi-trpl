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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo dan Nama Sistem -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sistem" class="w-12 h-12">
                <span class="text-xl font-semibold text-gray-700">Sistem Bimbingan Skripsi PNB</span>
            </div>
            <!-- Login & Register -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium py-2 px-4 rounded">
                    Register
                </a>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <section class="bg-blue-500 py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Selamat Datang di Sistem Bimbingan Skripsi PNB
            </h1>
            <p class="text-lg md:text-xl text-gray-600 mb-6">
                Sistem ini bertujuan untuk mempermudah mahasiswa dan dosen dalam proses bimbingan skripsi. Dengan sistem ini,
                mahasiswa dapat mengajukan topik, mengatur jadwal bimbingan, dan memonitor perkembangan skripsi mereka secara mudah dan efisien.
            </p>
            <a href="{{ route('login') }}" class="text-white bg-red-600 hover:bg-blue-700 font-medium py-3 px-6 rounded-lg shadow-md">
                Mulai Bimbingan
            </a>
        </div>
    </section>

    <!-- About System Section -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: About Info -->
            <div class="flex flex-col justify-center">
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-4">Tentang Sistem</h2>
                <p class="text-lg text-gray-600 mb-4">
                    Sistem Bimbingan Skripsi PNB dirancang untuk memudahkan proses komunikasi dan pengelolaan bimbingan antara
                    mahasiswa dan dosen. Dengan fitur-fitur seperti penjadwalan otomatis, pengajuan topik, dan pengiriman laporan,
                    sistem ini diharapkan dapat meningkatkan efektivitas dan efisiensi bimbingan skripsi.
                </p>
                <ul class="list-disc pl-6 text-lg text-gray-600">
                    <li>Pengajuan topik skripsi yang lebih cepat</li>
                    <li>Penjadwalan bimbingan yang fleksibel</li>
                    <li>Pengiriman laporan progres secara berkala</li>
                    <li>Feedback langsung dari dosen pembimbing</li>
                </ul>
            </div>
            <!-- Right: Image of Mentoring -->
            <div class="flex justify-center items-center">
                <!-- Gambar Unsplash dengan ukuran lebih besar -->
                <img src="{{ asset('images/Dosen-pembimbing-skripsi.jpg') }}" alt="Logo" class="h-100 w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Menu Section -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Menu Utama</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Menu 1: Cara Masuk Sistem -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 relative overflow-hidden transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-700 opacity-30"></div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-4 cursor-pointer flex items-center justify-between relative z-10" onclick="toggleMenu('menu1')">
                    Cara Masuk Sistem <i class="fas fa-chevron-down text-xl"></i>
                </h3>
                <div id="menu1" class="hidden transition-all duration-300 ease-in-out relative z-10">
                    <ul class="list-disc pl-6 text-gray-600 mb-4 text-left">
                        <li>Untuk mahasiswa, login dengan NIM dan password adalah NIM.</li>
                        <li>Untuk dosen, login dengan NIP dan password adalah NIP.</li>
                    </ul>
                    <a href="{{ route('login') }}" class="inline-block text-white bg-blue-600 hover:bg-blue-700 font-medium py-3 px-6 rounded-lg shadow-md transition-colors duration-300">
                        Masuk
                    </a>
                </div>
            </div>
<!-- Menu 2: Panduan -->
<div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-green-700 opacity-25"></div>
    <h3 class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer flex items-center justify-between relative z-10" onclick="toggleMenu('menu2')">
        Panduan <i class="fas fa-chevron-down"></i>
    </h3>
    <div id="menu2" class="hidden transition-all duration-300 ease-in-out relative z-10">
        <div class="bg-gray-100 p-4 rounded-md shadow-inner">
            <!-- PDF Viewer -->
            <iframe 
                src="{{ asset('files/panduan.pdf') }}" 
                class="w-full h-[400px] border border-gray-300 rounded-md" 
                frameborder="0">
            </iframe>

            <!-- Download Button -->
            <div class="mt-4">
                <a 
                    href="{{ asset('files/panduan.pdf') }}" 
                    download="Panduan Sistem"
                    class="inline-block text-white bg-green-600 hover:bg-green-700 font-medium py-2 px-4 rounded">
                    Unduh Panduan
                </a>
            </div>
        </div>
    </div>
</div>



            <!-- Menu 3: Edit Profil -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 relative overflow-hidden transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-red-700 opacity-30"></div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-4 cursor-pointer flex items-center justify-between relative z-10" onclick="toggleMenu('menu3')">
                    Edit Profil <i class="fas fa-chevron-down text-xl"></i>
                </h3>
                <div id="menu3" class="hidden transition-all duration-300 ease-in-out relative z-10">
                    <ul class="list-disc pl-6 text-gray-600 mb-4 text-left">
                        <li>Edit profil Anda untuk memperbarui informasi pribadi.</li>
                        <li>Perbarui password dan email Anda.</li>
                    </ul>
                    <a href="{{ route('profile.edit') }}" class="inline-block text-white bg-red-600 hover:bg-red-700 font-medium py-3 px-6 rounded-lg shadow-md transition-colors duration-300">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Script to toggle menu visibility -->
<script>
    function toggleMenu(menuId) {
        const menu = document.getElementById(menuId);
        menu.classList.toggle('hidden');
    }
    const url = "{{ asset('files/panduan.pdf') }}"; // Ganti dengan path file PDF Anda

// Inisialisasi PDF.js
pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
    const pdfDoc = pdfDoc_;
    const pdfContainer = document.getElementById('pdf-container');
    let currentPage = 1;
    
    // Fungsi untuk merender halaman PDF
    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(function(page) {
            const scale = 1.5;
            const viewport = page.getViewport({ scale: scale });

            // Membuat canvas untuk menampilkan halaman PDF
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Menampilkan halaman pada canvas
            page.render({ canvasContext: context, viewport: viewport }).promise.then(function() {
                pdfContainer.innerHTML = ''; // Kosongkan kontainer sebelum merender halaman baru
                pdfContainer.appendChild(canvas); // Tambahkan canvas ke dalam kontainer
            });
        });
    }

    // Render halaman pertama
    renderPage(currentPage);
});
</script>




    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Sistem Bimbingan Skripsi PNB. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu(menuId) {
            var menu = document.getElementById(menuId);
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.style.maxHeight = menu.scrollHeight + "px";
            } else {
                menu.style.maxHeight = null;
                menu.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
