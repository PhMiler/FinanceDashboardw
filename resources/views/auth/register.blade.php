<x-guest-layout> {{-- Layout para usuários não autenticados --}}

    {{-- Formulário de registro de novo usuário --}}
    <form method="POST" action="{{ route('register') }}">
        @csrf {{-- Proteção contra CSRF (obrigatório em POST) --}}

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="'Nome'" /> {{-- Label do campo nome --}}
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" /> {{-- Input para nome --}}
            <x-input-error :messages="$errors->get('name')" class="mt-2" /> {{-- Exibe erros relacionados ao campo nome --}}
        </div>

        <!-- Endereço de Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="'E-mail'" /> {{-- Label do campo email --}}
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" /> {{-- Input para e-mail --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" /> {{-- Exibe erros relacionados ao campo email --}}
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Senha'" /> {{-- Label do campo senha --}}

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" /> {{-- Input para senha --}}

            <x-input-error :messages="$errors->get('password')" class="mt-2" /> {{-- Exibe erros relacionados ao campo senha --}}
        </div>

        <!-- Confirmar Senha -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Confirme a Senha'" /> {{-- Label do campo confirmação de senha --}}

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" /> {{-- Input para confirmação de senha --}}

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> {{-- Exibe erros relacionados ao campo confirmação de senha --}}
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- Link para a tela de login, caso já tenha cadastro --}}
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Já possui cadastro?') }}
            </a>

            {{-- Botão para registrar o usuário --}}
            <x-primary-button class="ml-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
