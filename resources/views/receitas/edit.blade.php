@extends('layouts.app') {{-- Usa o layout principal da aplicação --}}

@section('content')
<div class="container mt-4">
    {{-- Título da página --}}
    <h3 class="fw-bold mb-3">Editar Receita</h3>
    <div class="card shadow">
        <div class="card-body">
            {{-- Formulário para edição de uma receita existente --}}
            <form action="{{ route('receitas.update', $receita) }}" method="POST">
                @csrf {{-- Token CSRF obrigatório para segurança --}}
                @method('PUT') {{-- Define o método HTTP como PUT para atualização da receita --}}
                
                {{-- Campo Descrição da Receita --}}
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ old('descricao', $receita->descricao) }}" 
                    required maxlength="100">
                    @error('descricao')
                        {{-- Exibe mensagem de erro de validação para o campo descrição --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Valor da Receita --}}
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor', $receita->valor) }}" 
                    required min="0" max="9999999.99">
                    @error('valor')
                        {{-- Exibe mensagem de erro de validação para o campo valor --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Data de Recebimento --}}
                <div class="mb-3">
                    <label for="data_recebimento" class="form-label">Data de Recebimento</label>
                    <input type="date" name="data_recebimento" id="data_recebimento" class="form-control" value="{{ old('data_recebimento', $receita->data_recebimento) }}" 
                    required max="2100-12-31" min="{{ date('Y-m-d') }}" max="2100-12-31">
                    @error('data_recebimento')
                        {{-- Exibe mensagem de erro de validação para o campo data de recebimento --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botões de ação --}}
                <div class="d-flex justify-content-end gap-2">
                    {{-- Botão para cancelar e voltar para a listagem de receitas --}}
                    <a href="{{ route('receitas.index') }}" class="btn btn-secondary">Cancelar</a>
                    {{-- Botão para salvar as alterações da receita --}}
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
