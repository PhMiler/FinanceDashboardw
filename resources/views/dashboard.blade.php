@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Título + Filtro --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-6 col-12 d-flex align-items-center">
            <h2 class="fw-bold text-primary mb-0">Dashboard Financeiro</h2>
        </div>
        <div class="col-lg-6 col-12 d-flex justify-content-lg-end justify-content-start mt-3 mt-lg-0">
            <form class="d-flex flex-wrap align-items-end gap-2" method="GET" action="{{ route('dashboard') }}">
                <div>
                    <label for="data_inicio" class="form-label mb-0 me-1">De:</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control"
                           style="min-width: 140px;"
                           value="{{ request('data_inicio') }}">
                </div>
                <div>
                    <label for="data_fim" class="form-label mb-0 me-1">Até:</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control"
                           style="min-width: 140px;"
                           value="{{ request('data_fim') }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary px-4 mt-3 mt-md-0">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Cards do resumo --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-primary shadow">
                <div class="card-body text-center">
                    <h6>Total de Contas</h6>
                    <p class="h4 fw-bold text-danger">R$ {{ number_format($totalContas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success shadow">
                <div class="card-body text-center">
                    <h6>Total de Receitas</h6>
                    <p class="h4 fw-bold text-success">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info shadow">
                <div class="card-body text-center">
                    <h6>Saldo Atual</h6>
                    <p class="h4 fw-bold {{ $saldo < 0 ? 'text-danger' : 'text-info' }}">
                        R$ {{ number_format($saldo, 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning shadow">
                <div class="card-body text-center">
                    <h6>Contas Pendentes</h6>
                    <p class="h4 fw-bold text-warning">{{ $contasPendentes }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TABELA DE CONTAS --}}
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">
            Minhas Contas
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contas as $conta)
                        <tr>
                            <td>{{ $conta->nome }}</td>
                            <td>R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($conta->vencimento)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $conta->situacao == 'Pendente' ? 'warning' : 'success' }}">
                                    {{ $conta->situacao }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma conta cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABELA DE RECEITAS --}}
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Minhas Receitas
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data de Recebimento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receitas as $receita)
                        <tr>
                            <td>{{ $receita->descricao }}</td>
                            <td>R$ {{ number_format($receita->valor, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($receita->data_recebimento)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma receita cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
