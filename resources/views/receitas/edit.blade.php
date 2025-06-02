@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-3">Editar Receita</h3>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('receitas.update', $receita) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ old('descricao', $receita->descricao) }}" required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor', $receita->valor) }}" required>
                </div>
                <div class="mb-3">
                    <label for="data_recebimento" class="form-label">Data de Recebimento</label>
                    <input type="date" name="data_recebimento" id="data_recebimento" class="form-control" value="{{ old('data_recebimento', $receita->data_recebimento) }}" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('receitas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
