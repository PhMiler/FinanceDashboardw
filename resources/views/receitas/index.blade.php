@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Minhas Receitas</h3>
        <a href="{{ route('receitas.create') }}" class="btn btn-success">
            + Nova Receita
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
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data Recebimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($receitas as $receita)
                    <tr>
                        <td>{{ $receita->descricao }}</td>
                        <td>R$ {{ number_format($receita->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($receita->data_recebimento)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('receitas.edit', $receita) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('receitas.destroy', $receita) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta receita?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma receita cadastrada.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
