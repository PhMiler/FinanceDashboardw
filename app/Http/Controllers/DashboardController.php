<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Receita;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Filtro de datas
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        // Filtro para Contas
        $contasQuery = Conta::where('user_id', $userId);
        if ($dataInicio && $dataFim) {
            $contasQuery->whereBetween('vencimento', [$dataInicio, $dataFim]);
        }
        $contas = $contasQuery->orderBy('vencimento')->get();

        // Filtro para Receitas
        $receitasQuery = Receita::where('user_id', $userId);
        if ($dataInicio && $dataFim) {
            $receitasQuery->whereBetween('data_recebimento', [$dataInicio, $dataFim]);
        }
        $receitas = $receitasQuery->orderBy('data_recebimento', 'desc')->get();

        $totalContas = $contas->sum('valor');
        $totalReceitas = $receitas->sum('valor');
        $saldo = $totalReceitas - $totalContas;
        $contasPendentes = $contas->where('situacao', 'Pendente')->count();

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
