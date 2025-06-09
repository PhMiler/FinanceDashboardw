<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável pelo gerenciamento das receitas dos usuários.
 */
class ReceitaController extends Controller
{
    /**
     * Exibe a lista de receitas do usuário autenticado,
     * ordenadas pela data de recebimento (mais recentes primeiro).
     */
    public function index()
    {
        // Busca todas as receitas do usuário logado, ordenando da mais recente para a mais antiga.
        $receitas = Receita::where('user_id', Auth::id())
            ->orderBy('data_recebimento', 'desc')
            ->get();

        return view('receitas.index', compact('receitas'));
    }

    /**
     * Exibe o formulário para cadastro de uma nova receita.
     */
    public function create()
    {
        return view('receitas.create');
    }

    /**
     * Salva uma nova receita após validar os dados enviados pelo formulário.
     */
    public function store(Request $request)
    {
        // Validação dos campos do formulário.
        $request->validate([
            'descricao' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0.01|max:999999.99',
            'data_recebimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
        ], [
            // Mensagens de erro personalizadas.
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'Máximo de caracteres: 100',
            'valor.min' => 'O valor deve ser maior que zero',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O valor deve ser menor que 999.999,99',
            'valor.numeric' => 'O valor deve ser um número válido',
            'data_recebimento.required' => 'O campo data de recebimento é obrigatório',
            'data_recebimento.date' => 'A data de recebimento deve ser uma data válida',
            'data_recebimento.before_or_equal' => 'A data de recebimento não pode ser posterior a 31/12/2100',
            'data_recebimento.after_or_equal' => 'A data de recebimento não pode ser anterior a hoje',
        ]);

        // Cria a nova receita vinculada ao usuário autenticado.
        Receita::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_recebimento' => $request->data_recebimento,
            'user_id' => Auth::id(), // Relaciona com o usuário logado.
        ]);

        // Redireciona para a listagem com mensagem de sucesso.
        return redirect()->route('receitas.index')->with('success', 'Receita cadastrada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma receita específica do usuário.
     */
    public function show($id)
    {
        // Busca a receita pelo ID, garantindo que pertença ao usuário logado.
        $receita = Receita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('receitas.show', compact('receita'));
    }

    /**
     * Exibe o formulário de edição de uma receita já cadastrada.
     */
    public function edit($id)
    {
        // Busca a receita pelo ID e usuário, garantindo acesso apenas ao dono.
        $receita = Receita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('receitas.edit', compact('receita'));
    }

    /**
     * Atualiza os dados de uma receita existente após validação.
     */
    public function update(Request $request, $id)
    {
        // Busca a receita do usuário logado.
        $receita = Receita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Valida os campos atualizados.
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
            'data_recebimento.before_or_equal' => 'A data de recebimento não pode ser posterior a 31/12/2100',
            'data_recebimento.after_or_equal' => 'A data de recebimento não pode ser anterior a hoje',
        ]);

        // Atualiza os dados da receita.
        $receita->update([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_recebimento' => $request->data_recebimento,
        ]);

        // Redireciona para a lista com mensagem de sucesso.
        return redirect()->route('receitas.index')->with('success', 'Receita atualizada com sucesso!');
    }

    /**
     * Remove uma receita do banco de dados.
     */
    public function destroy($id)
    {
        // Busca a receita do usuário logado e exclui.
        $receita = Receita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $receita->delete();

        // Redireciona para a listagem com mensagem de sucesso.
        return redirect()->route('receitas.index')->with('success', 'Receita excluída com sucesso!');
    }
}
