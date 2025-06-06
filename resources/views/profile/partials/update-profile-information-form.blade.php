<section class="dark:bg-gray-800 dark:text-gray-100">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- NIM/NIP (Read-only) -->
        <div>
            <x-input-label for="nim" :value="__('NIM/NIP')" />
            <x-text-input id="nim" name="nim" type="text"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('nim', $user->mahasiswa->nim ?? ($user->dosen->nip ?? 'Belum diisi'))"
                disabled />
        </div>

        <!-- Name (Editable) -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('name', $user->mahasiswa->nama ?? $user->dosen->nama)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email (Editable) -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('email', $user->mahasiswa->email ?? ($user->dosen->email ?? 'Belum diisi'))"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-400">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone (Editable) -->
        <div>
            <x-input-label for="telepon" :value="__('telepon')" />
            <x-text-input id="telepon" name="telepon" type="text"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('telepon', $user->mahasiswa->telepon ?? 'Belum diisi')" />
            <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
        </div>

        <!-- Jurusan (Read-only) -->
        <div>
            <x-input-label for="jurusan" :value="__('Jurusan')" />
            <x-text-input id="jurusan" name="jurusan" type="text"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('jurusan', $user->mahasiswa->jurusan ?? ($user->dosen->jurusan ?? 'Belum diisi'))"
                disabled />
        </div>

        <!-- Prodi (Read-only) -->
        <div>
            <x-input-label for="prodi" :value="__('Prodi')" />
            <x-text-input id="prodi" name="prodi" type="text"
                class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :value="old('prodi', $user->mahasiswa->prodi ?? 'Belum diisi')"
                disabled />
        </div>

        <div class="flex items-center gap-4 ">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
