@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-primary">Dashboard Financeiro</h2>
        </div>
    </div>
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
