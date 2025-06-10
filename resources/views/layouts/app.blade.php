<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    {{-- Título dinâmico, com valor padrão "Dashboard Financeiro" --}}
    <title>@yield('title', 'Dashboard Financeiro')</title>
    {{-- Inclusão do Bootstrap 5 via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            /* Imagem de fundo customizada para o dashboard */
            background-image: url('{{ asset('imagens/FinanceDashboardImage.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
        }
        body::before {
            /* Sobreposição branca translúcida para melhorar contraste */
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.73);
            z-index: -1;
        }
    </style>
</head>
<body>
    {{-- Inclusão da barra de navegação --}}
    @include('layouts.navigation')

    <main>
        {{-- Seção de conteúdo dinâmico das páginas --}}
        @yield('content')
    </main>

    {{-- Inclusão dos scripts do Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
