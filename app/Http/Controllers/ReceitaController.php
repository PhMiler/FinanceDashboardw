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
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_recebimento' => 'required|date',
        ]);

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
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_recebimento' => 'required|date',
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
