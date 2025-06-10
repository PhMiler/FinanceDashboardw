<nav class="navbar navbar-expand-lg navbar-light bg-white shadow mb-4">
    <div class="container">
        {{-- Logo do sistema com destaque na palavra "Dash" --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Finance<span class="text-primary">Dash</span>
        </a>
        <!-- Botão hamburger para abrir o menu em telas pequenas (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Itens do menu de navegação -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-semibold text-dark">
                <li class="nav-item">
                    {{-- Link para Home --}}
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    {{-- Link para o Dashboard financeiro --}}
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    {{-- Link para a listagem de contas --}}
                    <a class="nav-link" href="{{ route('contas.index') }}">Contas</a>
                </li>
                <li class="nav-item">
                    {{-- Link para a listagem de receitas --}}
                    <a class="nav-link" href="{{ route('receitas.index') }}">Receitas</a>
                </li>
                <li class="nav-item">
                    {{-- Formulário de logout (para sair do sistema) --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="color: inherit; text-decoration: none;">
                            Sair
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
