<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Menampilkan pesan kesalahan umum (jika ada) -->
    {{-- @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif --}}

    <!-- Form Login -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Identifier (NIM/NIP) -->
        <div>
            <x-input-label for="identifier" :value="__('NIM / NIP')" />
            <x-text-input id="identifier" class="block mt-1 w-full" type="text" name="identifier" :value="old('identifier')" required autofocus />
            <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot password') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Menampilkan countdown jika waktu lockout ada -->
    @if(session('lockout_time'))
        <div id="lockout-message" class="mt-4 text-sm text-red-600">
            <p>{{ __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => session('lockout_time')]) }}</p>
            <p id="countdown-timer"></p>
        </div>

        <script>
            let countdownTime = {{ session('lockout_time') }};
            const countdownElement = document.getElementById('countdown-timer');

            function updateCountdown() {
                if (countdownTime > 0) {
                    countdownElement.innerHTML = `Remaining time: ${countdownTime} seconds`;
                    countdownTime--;
                } else {
                    countdownElement.innerHTML = "You can try logging in again now.";
                    clearInterval(countdownInterval); // Hentikan interval saat countdown selesai
                }
            }

            // Update setiap detik
            const countdownInterval = setInterval(updateCountdown, 1000);
        </script>
    @endif
</x-guest-layout>
