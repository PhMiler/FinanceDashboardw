@extends('layouts.app') {{-- Usa o layout principal da aplicação --}}

@section('content')
<div class="container mt-4">
    {{-- Título e botão para cadastrar nova receita --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Minhas Receitas</h3>
        <a href="{{ route('receitas.create') }}" class="btn btn-success">
            + Nova Receita
        </a>
    </div>
    {{-- Exibe mensagem de sucesso ao cadastrar/editar/excluir uma receita --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            {{-- Tabela com listagem das receitas --}}
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
                {{-- Loop pelas receitas cadastradas --}}
                @forelse($receitas as $receita)
                    <tr>
                        <td>{{ $receita->descricao }}</td>
                        <td>R$ {{ number_format($receita->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($receita->data_recebimento)->format('d/m/Y') }}</td>
                        <td>
                            {{-- Botão de edição --}}
                            <a href="{{ route('receitas.edit', $receita) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            {{-- Formulário e botão de exclusão (com confirmação) --}}
                            <form action="{{ route('receitas.destroy', $receita) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta receita?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Caso não haja receitas cadastradas --}}
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
