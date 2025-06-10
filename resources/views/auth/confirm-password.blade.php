<x-guest-layout> {{-- Usa o layout para usuários não autenticados (visitantes) --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{-- Mensagem informando que a área é protegida e requer confirmação de senha --}}
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    {{-- Formulário de confirmação de senha --}}
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf {{-- Token CSRF para segurança --}}

        <!-- Campo de senha -->
        <div>
            {{-- Label do campo de senha --}}
            <x-input-label for="password" :value="__('Password')" />

            {{-- Campo de input para senha --}}
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            {{-- Exibe mensagens de erro relacionadas à senha --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            {{-- Botão para confirmar a senha --}}
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
