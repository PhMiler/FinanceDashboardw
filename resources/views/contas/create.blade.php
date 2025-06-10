@extends('layouts.app') {{-- Usa o layout principal da aplicação --}}

@section('content')
<div class="container mt-4">
    {{-- Título da página --}}
    <h3 class="fw-bold mb-3">Nova Conta</h3>
    <div class="card shadow">
        <div class="card-body">
            {{-- Formulário para cadastro de nova conta --}}
            <form action="{{ route('contas.store') }}" method="POST">
                @csrf {{-- Token CSRF obrigatório para segurança do formulário --}}

                {{-- Campo Nome --}}
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required maxlength="100", >
                    @error('nome')
                        {{-- Exibe mensagem de erro de validação para o campo nome --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Valor --}}
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" step = "0.01" name="valor" id="valor" class="form-control" value="{{ old('valor') }}" 
                    required min="0" max="9999999.99">
                    @error('valor')
                        {{-- Exibe mensagem de erro de validação para o campo valor --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Vencimento --}}
                <div class="mb-3">
                    <label for="vencimento" class="form-label">Vencimento</label>
                    <input type="date" name="vencimento" id="vencimento" class="form-control" value="{{ old('vencimento') }}" 
                    required max="2100-12-31" min="{{ date('Y-m-d') }}" max="2100-12-31">
                    @error('vencimento')
                        {{-- Exibe mensagem de erro de validação para o campo vencimento --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Situação --}}
                <div class="mb-3">
                    <label for="situacao" class="form-label">Situação</label>
                    <select name="situacao" id="situacao" class="form-select" required>
                        <option value="Pendente" {{ old('situacao') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Pago" {{ old('situacao') == 'Pago' ? 'selected' : '' }}>Pago</option>
                    </select>
                    @error('situacao')
                        {{-- Exibe mensagem de erro de validação para o campo situação --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botões de ação --}}
                <div class="d-flex justify-content-end gap-2">
                    {{-- Botão para cancelar e voltar para a listagem --}}
                    <a href="{{ route('contas.index') }}" class="btn btn-secondary">Cancelar</a>
                    {{-- Botão para enviar (salvar) o formulário --}}
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
