<x-guest-layout>
    <x-slot name="logo">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </x-slot>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Your account has been locked due to too many failed login attempts. Please try again later.') }}
    </div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please wait :seconds seconds before trying again.', ['seconds' => $seconds]) }}
    </div>
    <div class="mb-4 text-sm text-gray-600" id="countdown">
        {{ __('Time remaining: :seconds seconds', ['seconds' => $seconds]) }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var seconds = {{ $seconds }};
            var countdownElement = document.getElementById('countdown');

            function updateCountdown() {
                if (seconds > 0) {
                    seconds--;
                    countdownElement.textContent = 'Time remaining: ' + seconds + ' seconds';
                } else {
                    countdownElement.textContent = 'You can try logging in now.';
                }
            }

            setInterval(updateCountdown, 1000);
        });
    </script>
</x-guest-layout>