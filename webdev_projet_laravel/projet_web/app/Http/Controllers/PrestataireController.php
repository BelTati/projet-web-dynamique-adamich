<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Adresse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactPrestataireMail;
use App\Repositories\CategorieRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProviderRepository;
use App\Http\Controllers\AuthController;

class PrestataireController extends Controller
{
    
    protected $categoryRepo;

    public function __construct(CategorieRepository $repo)
    {
        $this->categoryRepo = $repo;
    }
    public function index() {
        
        
       $categories = $this->categoryRepo->getAll();
        return view('provider.dashboard', compact('categories'));
    }
    
    public function listProviders()
{
    // On récupère tous les utilisateurs ayant le rôle 'PROVIDER' et non bannis
    $prestataires = User::where('role', 'PROVIDER')
                        ->where('est_banni', false)
                        ->paginate(10);

    return view('provider.index', compact('prestataires'));
}

    



    public function showProviderProfile(User $prestataire)
{
    // On vérifie que c'est bien un prestataire et qu'il n'est pas banni
    if ($prestataire->role !== 'PROVIDER' || $prestataire->est_banni) {
        abort(404);
    }

    return view('provider.show', compact('prestataire'));
}

public function providerContact(User $prestataire)
    {
        return view('provider.contact', compact('prestataire'));
    }

    // Traite l'envoi du mail (POST)
    public function send(Request $request, User $prestataire)
    {
        $validated = $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email',
            'sujet'   => 'required|string|max:150',
            'message' => 'required|string|min:10',
        ]);

         // On peut ajouter l'info "Authentifié" dans les data envoyées au Mail
            $validated['is_authenticated'] = auth()->check();
        
            try {
            // Envoi réel au mail du prestataire stocké en DB
            Mail::to($prestataire->email)->send(new ContactPrestataireMail($validated));

            // Postcondition : Retour sur la fiche signalétique avec succès
            return redirect()->route('provider.show', $prestataire->id)
                             ->with('status', 'Votre message a été envoyé avec succès.');
                             
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "L'envoi a échoué. Vérifiez votre configuration Mailpit."])->withInput();
             //dd($e->getMessage());
        }
    }


 public function searchProvider(Request $request){

// 1. Recherche filtrée (Résultats)
    $query = User::where('role', 'PROVIDER')
                 ->where('est_banni', false) // Sécurité : on cache les bannis
                 ->with(['categories', 'adresses']);

    $query->when($request->search, function ($q, $search) {
        $q->where(function($sub) use ($search) {
            $sub->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhereHas('adresses', function ($attr) use ($search) {
                    $attr->where('ville', 'like', "%{$search}%")
                         ->orWhere('cp', 'like', "%{$search}%");
                })
                ->orWhereHas('categories', function ($attr) use ($search) {
                    $attr->where('nom', 'like', "%{$search}%");
                });
        });
    });
    $prestataires = $query->paginate(10)->withQueryString();

    return view('provider.search', compact('prestataires'));

 }

 public function edit()
    {
       
        // On récupère l'utilisateur connecté avec ses relations
        $user = auth()->user()->load('categories');
        
        // On récupère toutes les catégories validées pour le choix multiple
        $categories = Categorie::where('valide', true)->get();

        // On retourne la vue située dans resources/views/prestataire/edit.blade.php
        return view('provider.fiche.edit', compact('user', 'categories'));
    
    }


public function update(Request $request)
{
   
$prestataire = auth()->user();

    // 1. Validation rigoureuse
    $validated = $request->validate([
        'nom'            => 'required|string|max:255',
        'tva'            => 'required|string|max:20',
        'site_web'       => 'nullable|url',
        'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'categories'     => 'array', 
        'categories.*'   => 'exists:categories,id',
        'new_category'   => 'nullable|string|max:50', // La suggestion
        //'new_category_description' => 'required_with:new_category|string|max:500', 
    ]);

    // 2. Gestion du Logo (Stockage Docker/Laravel)
    if ($request->hasFile('logo')) {
        // Supprime l'ancien logo si nécessaire avant d'en mettre un nouveau
        $path = $request->file('logo')->store('logos', 'public');
        $prestataire->logo = $path; 
    }

    // 3. Mise à jour des infos de base
    $prestataire->update([
        'nom'      => $validated['nom'],
        'tva'      => $validated['tva'],
        'site_web' => $validated['site_web'],
    ]);

    // 4. Synchronisation des catégories (Table Pivot)
    // On utilise sync() pour correspondre exactement au choix de l'utilisateur
    $prestataire->categories()->sync($request->categories ?? []);

    // 5. Traitement de la suggestion (Modération)
    if ($request->filled('new_category')) {
        \App\Models\Categorie::create([
            'nom'          => $request->new_category,
            'description' => '', // On envoie une chaîne vide pour éviter l'erreur 1364
           // 'description' => $data['new_category_description'], // On envoie la description saisie
            'valide' => false,
            'user_id'      => $prestataire->id

        ]);
    }

    // Postcondition : Uniquement en cas de succès
    return redirect()->route('provider.dashboard')
        ->with('success', 'Fiche signalétique mise à jour avec succès.');



    }
}
