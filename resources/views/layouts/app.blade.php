<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Financeiro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background-image: url('{{ asset('imagens/FinanceDashboardImage.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.73);
            z-index: -1;
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
