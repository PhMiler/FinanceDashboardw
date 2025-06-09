<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContaController extends Controller
{
    public function index()
    {
        $contas = Conta::where('user_id', Auth::id())->orderBy('vencimento', 'asc')->get();
        return view('contas.index', compact('contas'));
    }

    public function create()
    {
        return view('contas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0,01|max:999999.99',
            'vencimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
            'situacao' => 'required|string|max:50',
        ], [
            'nome.max' => 'Máximo de caracteres: 100',
            'nome.required' => 'O campo nome é obrigatório',
            'valor.min' => 'O valor deve ser maior que zero',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O valor deve ser menor que 999.999,99',
            'vencimento.required' => 'O campo vencimento é obrigatório',
            'vencimento.date' => 'O campo vencimento deve ser uma data válida',
            'vencimento.before_or_equal' => 'A data de vencimento não pode ser posterior a 31/12/2100',
            'vencimento.after_or_equal' => 'A data de vencimento não pode ser anterior a hoje',
            'situacao.required' => 'O campo situação é obrigatório',
            'situacao.max' => 'Máximo de caracteres: 50',
            'valor.numeric' => 'Somente valores positivos ou Valor inválido',
        ]);

        Conta::create([
            'user_id' => Auth::id(),
            'nome' => $request->nome,
            'valor' => $request->valor,
            'vencimento' => $request->vencimento,
            'situacao' => $request->situacao,
        ]);

        return redirect()->route('contas.index')->with('success', 'Conta cadastrada com sucesso!');
    }

    public function edit(Conta $conta)
    {
        $this->authorize('update', $conta);

        return view('contas.edit', compact('conta'));
    }

    public function update(Request $request, Conta $conta)
    {
        $this->authorize('update', $conta);

        $request->validate([
            'nome' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0,01|max:999999.99',
            'vencimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
            'situacao' => 'required|string|max:50',
        ], [
            'nome.max' => 'Máximo de caracteres: 100',
            'nome.required' => 'O campo nome é obrigatório',
            'valor.min' => 'O valor deve ser maior que zero',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O valor deve ser menor que 999.999,99',
            'vencimento.required' => 'O campo vencimento é obrigatório',
            'vencimento.date' => 'O campo vencimento deve ser uma data válida',
            'vencimento.before_or_equal' => 'A data de vencimento não pode ser posterior a 31/12/2100',
            'vencimento.after_or_equal' => 'A data de vencimento não pode ser anterior a hoje',
            'situacao.required' => 'O campo situação é obrigatório',
            'situacao.max' => 'Máximo de caracteres: 50',
            'valor.numeric' => 'Somente valores positivos ou Valor inválido',
        ]);

        $conta->update($request->only(['nome', 'valor', 'vencimento', 'situacao']));

        return redirect()->route('contas.index')->with('success', 'Conta atualizada com sucesso!');
    }

    public function destroy(Conta $conta)
    {
        $this->authorize('delete', $conta);
        $conta->delete();
        return redirect()->route('contas.index')->with('success', 'Conta removida!');
    }
}
