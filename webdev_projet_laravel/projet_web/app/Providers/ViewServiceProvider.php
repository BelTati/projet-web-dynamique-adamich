<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Categorie; // Assurez-vous que le modèle est le bon

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Partage la variable $categories avec TOUTES les vues qui utilisent 'layouts.app'
        // Ou plus spécifiquement avec 'partials.aside' si vous avez un fichier dédié
       
       /*
        View::composer(['layouts.app', 'include.aside', 'home','provider_dashboard','admin_dashboard','profile.edit'], function ($view) {
            $view->with('categories', Categorie::where('valide', true)->get());
        });
*/
        // Cible uniquement le fichier de l'aside
        View::composer('include.aside', function ($view) {
            // On récupère les catégories validées
            $view->with('categories', Categorie::where('valide', true)->get());
           // $view->with('categories', $categories);
        });
    }
}
