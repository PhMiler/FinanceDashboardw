@extends('layouts.app') {{-- Usa o layout base da aplicação --}}

@section('content')
<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    {{-- Card centralizado com fundo branco semi-transparente --}}
    <div style="
        background: rgba(255,255,255,0.93);
        border-radius: 18px;
        padding: 42px 32px;
        box-shadow: 0 4px 24px 0 rgba(0,0,0,0.10);
        max-width: 720px;
        width: 100%;
        margin: auto;
    ">
        <div class="text-center">
            {{-- Título de boas-vindas --}}
            <h1 class="display-4 fw-bold">
                Bem-vindo ao <span class="text-primary">Finance Dashboard</span>!
            </h1>
            {{-- Descrição sobre as funcionalidades do dashboard --}}
            <p class="lead mt-3 fw-semibold text-dark">
                Este é um dashboard de finanças que permite que você visualize e analise suas transações financeiras de forma fácil e intuitiva.
                Você pode adicionar, editar e excluir transações, bem como visualizar relatórios para entender melhor seus gastos e receitas.
            </p>
        </div>
    </div>
</div>
@endsection
