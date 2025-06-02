<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Receita;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    $contas = Conta::where('user_id', $userId)->orderBy('vencimento')->get();
    $receitas = Receita::where('user_id', $userId)->orderBy('data_recebimento', 'desc')->get();

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
        'contasPendentes'
    ));
}

}
