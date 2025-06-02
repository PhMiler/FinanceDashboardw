@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Minhas Contas</h3>
        <a href="{{ route('contas.create') }}" class="btn btn-primary">
            + Nova Conta
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Situação</th>
                        <th>Ações</th>
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
                        <td>
                            <a href="{{ route('contas.edit', $conta) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('contas.destroy', $conta) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta conta?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma conta cadastrada.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
