<nav class="bg-gray-800 text-white shadow-lg sticky top-0 ">
    <div class="flex items-center justify-between p-4">
        <!-- Logo dan Judul Sistem -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded">
                <span class="text-lg font-bold">Politeknik Negeri Bali</span>
            </a>
        </div>

        <!-- Informasi Pengguna -->
        @auth
        <div class="flex items-center space-x-4">
            <!-- Foto Profil dan Nama -->
            <div class="flex items-center space-x-3">
                <img src="https://via.placeholder.com/40" alt="Profile Picture" class="h-10 w-10 rounded-full border-2 border-white">
                <div class="text-right">
                    <h3 class="font-medium text-sm">{{ Auth::user()->name }}</h3>
                    <span class="text-green-400 text-xs font-semibold">● ONLINE</span>
                </div>
            </div>
            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md text-sm">
                    Log Out
                </button>
            </form>
        </div>
        @endauth
    </div>
</nav>
