<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Receita;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável por exibir o painel (dashboard) financeiro do usuário.
 * O painel mostra o resumo das contas, receitas, saldo, e quantidade de contas pendentes.
 */
class DashboardController extends Controller
{
    /**
     * Exibe a página do dashboard, com dados filtrados por período se informado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtém o ID do usuário autenticado.
        $userId = Auth::id();

        // Recebe filtros de data inicial e final via request (úteis para relatórios customizados).
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        // --- Consulta de contas a pagar/receber ---
        $contasQuery = Conta::where('user_id', $userId); // Apenas contas do usuário logado.
        if ($dataInicio && $dataFim) {
            // Aplica filtro de período caso informado.
            $contasQuery->whereBetween('vencimento', [$dataInicio, $dataFim]);
        }
        // Ordena as contas por data de vencimento.
        $contas = $contasQuery->orderBy('vencimento')->get();

        // --- Consulta de receitas ---
        $receitasQuery = Receita::where('user_id', $userId); // Apenas receitas do usuário logado.
        if ($dataInicio && $dataFim) {
            // Aplica filtro de período caso informado.
            $receitasQuery->whereBetween('data_recebimento', [$dataInicio, $dataFim]);
        }
        // Ordena as receitas da mais recente para a mais antiga.
        $receitas = $receitasQuery->orderBy('data_recebimento', 'desc')->get();

        // --- Cálculos de totais e indicadores do dashboard ---
        $totalContas = $contas->sum('valor');          // Soma o valor total das contas no período.
        $totalReceitas = $receitas->sum('valor');      // Soma o valor total das receitas no período.
        $saldo = $totalReceitas - $totalContas;        // Calcula o saldo: receitas menos contas.
        $contasPendentes = $contas->where('situacao', 'Pendente')->count(); // Conta quantas contas estão pendentes.

        // Retorna a view 'dashboard' com todos os dados necessários para exibição.
        return view('dashboard', compact(
            'contas',
            'receitas',
            'totalContas',
            'totalReceitas',
            'saldo',
            'contasPendentes',
            'dataInicio',
            'dataFim'
        ));
    }
}
