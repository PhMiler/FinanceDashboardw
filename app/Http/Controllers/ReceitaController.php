<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceitaController extends Controller
{
    public function index()
    {
        $receitas = Receita::where('user_id', Auth::id())->orderBy('data_recebimento', 'desc')->get();
        return view('receitas.index', compact('receitas'));
    }

    public function create()
    {
        return view('receitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0.01|max:999999.99',
            'data_recebimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
        ], [
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'Máximo de caracteres: 100',
            'valor.min' => 'O valor deve ser maior que zero',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O valor deve ser menor que 999.999,99',
            'valor.numeric' => 'O valor deve ser um número válido',
            'data_recebimento.required' => 'O campo data de recebimento é obrigatório',
            'data_recebimento.date' => 'A data de recebimento deve ser uma data válida',
            'data_recebimento.before_or_equal' => 'A data de vencimento não pode ser posterior a 31/12/2100',
            'data_recebimento.after_or_equal' => 'A data de vencimento não pode ser anterior a hoje',
        ]);

         // Cria a receita
           Receita::create([
            'user_id' => Auth::id(),
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_recebimento' => $request->data_recebimento,
        ]);

        return redirect()->route('receitas.index')->with('success', 'Receita cadastrada com sucesso!');
    }

    public function edit(Receita $receita)
    {
        $this->authorize('update', $receita);
        return view('receitas.edit', compact('receita'));
    }

    public function update(Request $request, Receita $receita)
    {
        $this->authorize('update', $receita);

        $request->validate([
            'descricao' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0.01|max:999999.99',
            'data_recebimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
        ], [
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'Máximo de caracteres: 100',
            'valor.min' => 'O valor deve ser maior que zero',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O valor deve ser menor que 999.999,99',
            'valor.numeric' => 'O valor deve ser um número válido',
            'data_recebimento.required' => 'O campo data de recebimento é obrigatório',
            'data_recebimento.date' => 'A data de recebimento deve ser uma data válida',
            'data_recebimento.before_or_equal' => 'A data de vencimento não pode ser posterior a 31/12/2100',
            'data_recebimento.after_or_equal' => 'A data de vencimento não pode ser anterior a hoje',
        ]);

        $receita->update($request->only(['descricao', 'valor', 'data_recebimento']));

        return redirect()->route('receitas.index')->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy(Receita $receita)
    {
        $this->authorize('delete', $receita);
        $receita->delete();
        return redirect()->route('receitas.index')->with('success', 'Receita removida!');
    }
}
