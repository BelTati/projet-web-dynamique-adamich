<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Repositories\CategorieRepository;
use App\Http\Controllers\CategorieController;

class AdminController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategorieRepository $repo)
    {
        $this->categoryRepo = $repo;
    }

    public function index() {
        
          
        // On récupère toutes les catégories via le Repo
    $categories = $this->categoryRepo->getAll();
    
    // On sépare pour l'affichage (optionnel mais plus clair pour l'admin)
    $pending = $categories->where('valide', false);
    $validated = $categories->where('valide', true);

    return view('admin.dashboard', compact('pending', 'validated'));
        
      
        }
 public function listPrestataires()
{
    // On récupère uniquement les PROVIDER (prestataires)
    $prestataires = User::where('role', 'PROVIDER')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    return view('admin.providers.index', compact('prestataires'));
}

        /**
     * Exemple : Valider une catégorie suggérée
     */
    public function validateCategory(Categorie $categorie)
    {
        $categorie->update(['valide' => true]);

        // Postcondition : Retour sur l'écran d'accueil admin
        return redirect()->route('admin.dashboard')
                         ->with('status', "La catégorie {$categorie->nom} a été validée.");
    }
   
}
