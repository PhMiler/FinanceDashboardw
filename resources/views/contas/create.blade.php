@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-3">Nova Conta</h3>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('contas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor') }}" required>
                </div>
                <div class="mb-3">
                    <label for="vencimento" class="form-label">Vencimento</label>
                    <input type="date" name="vencimento" id="vencimento" class="form-control" value="{{ old('vencimento') }}" required>
                </div>
                <div class="mb-3">
                    <label for="situacao" class="form-label">Situação</label>
                    <select name="situacao" id="situacao" class="form-select" required>
                        <option value="Pendente" {{ old('situacao') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Pago" {{ old('situacao') == 'Pago' ? 'selected' : '' }}>Pago</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('contas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
