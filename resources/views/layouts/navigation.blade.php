<nav class="bg-gray-800 text-white shadow-lg sticky top-0 z-50">
    <div class="flex justify-between items-center px-6 py-3">
        <!-- Logo dan Judul Sistem -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10">
            <span class="text-lg font-bold">SIBIMOLI Politeknik Negeri Bali</span>
        </div>

        <!-- Informasi Pengguna -->
        <div class="flex items-center space-x-6">
            <!-- Avatar dan Nama Pengguna -->
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-700 text-white font-bold text-sm border-2 border-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="text-sm">
                    <h3 class="font-medium">{{ Auth::user()->name }}</h3>
                    <span class="text-green-400 font-semibold">● ONLINE</span>
                </div>
            </div>

            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-sm font-medium py-2 px-4 rounded-md flex items-center space-x-2">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</nav>
