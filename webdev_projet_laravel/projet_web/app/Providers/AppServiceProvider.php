<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Categorie; // Assurez-vous que le modèle est le bon

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partage les catégories avec le fichier aside uniquement
        View::composer('include.aside', function ($view) {
        $view->with('categories', Categorie::where('valide', true)
        ->orderBy('nom')
        ->get());
        
    });
    }
}
