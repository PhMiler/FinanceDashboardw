<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável por gerenciar as contas dos usuários.
 */
class ContaController extends Controller
{
    /**
     * Exibe a lista de contas do usuário autenticado,
     * ordenadas pela data de vencimento (mais próximas primeiro).
     */
    public function index()
    {
        // Busca as contas do usuário logado, ordenando pelo vencimento.
        $contas = Conta::where('user_id', Auth::id())->orderBy('vencimento', 'asc')->get();
        return view('contas.index', compact('contas'));
    }

    /**
     * Exibe o formulário para cadastro de uma nova conta.
     */
    public function create()
    {
        return view('contas.create');
    }

    /**
     * Salva uma nova conta no banco de dados após validação.
     * Valida os campos obrigatórios e suas regras.
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados pelo formulário.
        $request->validate([
            'nome' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0,01|max:999999.99',
            'vencimento' => 'required|date|before_or_equal:2100-12-31|after_or_equal:today',
            'situacao' => 'required|string|max:50',
        ], [
            // Mensagens de erro personalizadas.
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
        ]);

        // Cria a conta associando ao usuário autenticado.
        Conta::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'vencimento' => $request->vencimento,
            'situacao' => $request->situacao,
            'user_id' => Auth::id(), // Garante vínculo com o usuário logado.
        ]);

        // Redireciona para a lista de contas com mensagem de sucesso.
        return redirect()->route('contas.index')->with('success', 'Conta cadastrada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma conta específica.
     */
    public function show($id)
    {
        // Busca a conta pelo ID, garantindo que pertença ao usuário logado.
        $conta = Conta::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('contas.show', compact('conta'));
    }

    /**
     * Exibe o formulário para edição de uma conta existente.
     */
    public function edit($id)
    {
        // Busca a conta pelo ID e usuário, garantindo acesso apenas do dono.
        $conta = Conta::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('contas.edit', compact('conta'));
    }

    /**
     * Atualiza os dados de uma conta após validação.
     */
    public function update(Request $request, $id)
    {
        // Busca a conta do usuário logado.
        $conta = Conta::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Validação dos dados atualizados.
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
        ]);

        // Atualiza os dados da conta.
        $conta->update([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'vencimento' => $request->vencimento,
            'situacao' => $request->situacao,
        ]);

        // Redireciona com mensagem de sucesso.
        return redirect()->route('contas.index')->with('success', 'Conta atualizada com sucesso!');
    }

    /**
     * Remove uma conta do banco de dados.
     */
    public function destroy($id)
    {
        // Busca a conta do usuário logado e exclui.
        $conta = Conta::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $conta->delete();

        // Redireciona para a lista de contas com confirmação.
        return redirect()->route('contas.index')->with('success', 'Conta excluída com sucesso!');
    }
}
