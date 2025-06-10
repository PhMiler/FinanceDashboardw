<?php

// Importação dos controllers utilizados nas rotas
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\ReceitaController;

// Redireciona a rota raiz (/) para a tela de login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rota para a tela "Home" (protegida: só usuários autenticados e com e-mail verificado)
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

// Rota para o dashboard principal (protegida: autenticado e verificado)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas do perfil do usuário, agrupadas e protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Formulário de edição do perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Atualização dos dados do perfil (PATCH)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Exclusão da conta/perfil do usuário
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de contas e receitas, protegidas por autenticação e verificação de e-mail
Route::middleware(['auth', 'verified'])->group(function () {
    // CRUD de contas (resource = todas as rotas RESTful)
    Route::resource('contas', ContaController::class);
    // CRUD de receitas (resource = todas as rotas RESTful)
    Route::resource('receitas', ReceitaController::class);
});

// Importa as rotas de autenticação padrão (login, registro, etc)
require __DIR__.'/auth.php';
