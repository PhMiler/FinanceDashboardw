<x-guest-layout> {{-- Layout usado para páginas públicas (visitante, não autenticado) --}}

    <!-- Status da sessão (mensagem de sucesso ou erro após login, logout, etc) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Formulário de login --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf {{-- Token de segurança CSRF obrigatório em formulários POST --}}

        <!-- Campo de e-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" /> {{-- Label do campo --}}
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> {{-- Input para e-mail --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" /> {{-- Exibe erros de validação do e-mail --}}
        </div>

        <!-- Campo de senha -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" /> {{-- Label do campo --}}
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" /> {{-- Input para senha --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" /> {{-- Exibe erros de validação da senha --}}
        </div>

        <!-- Checkbox "Lembre de mim" -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Lembre de mim') }}</span>
            </label>
        </div>

        <!--
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                {{-- Link para recuperação de senha (opcional, está comentado) --}}
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif
        </div>
        -->

        <div class="flex items-center justify-end mt-4 gap-2">
            {{-- Botão para enviar o formulário de login --}}
            <x-primary-button>
                {{ __('Conecte-se') }}
            </x-primary-button>

            {{-- Botão para ir para a página de registro --}}
            <x-link-button href="{{ route('register') }}" class="bg-blue-700 hover:bg-blue-800 focus:ring-blue-500">
                {{ __('Registrar-se') }}
            </x-link-button>
        </div>
    </form>
</x-guest-layout>
