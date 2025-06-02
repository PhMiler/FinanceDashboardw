<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    Conta::class => ContaPolicy::class,
    Receita::class => ReceitaPolicy::class,];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function update(User $user, Conta $conta)
{
    return $conta->user_id === $user->id;
}

}
