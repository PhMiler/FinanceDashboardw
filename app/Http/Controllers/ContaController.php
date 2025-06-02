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
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'vencimento' => 'required|date',
            'situacao' => 'required|string|max:50',
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
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'vencimento' => 'required|date',
            'situacao' => 'required|string|max:50',
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
