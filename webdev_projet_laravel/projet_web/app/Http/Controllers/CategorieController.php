<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\User;
use App\Http\Controllers\PrestataireController;
use App\Mail\CategoryTransferredMail;
use Illuminate\Support\Facades\Mail;

class CategorieController extends Controller
{
     public function index()
    {
      
         $categories = Categorie::where('valide', true)
        ->orderBy('nom')
        ->get();

        // Récupère les 4 derniers prestataires (rôle 'PROVIDER')
    $prestataires = User::where('role', 'PROVIDER')
                        ->where('est_banni', false) // Optionnel: uniquement les non bannis
                        ->latest() // Trie par created_at DESC
                        ->take(4)
                        ->get();

    return view('home', compact('categories','prestataires'));
       
    // On ne récupère que les catégories approuvées par l'admin
   
    // On récupère toutes les catégories avec le compte des utilisateurs liés
    /*
    $categories = Categorie::withCount('users')->orderBy('nom')->get();

  return view('home', compact('categories'));
       

    
       
        $categories = Categorie::all();
        // Passer la variable à la vue [1]
        return view('home', compact('categories'));

       
        */
    }
    
    // Pour l'admin (Gestion)
public function adminIndex() {

    $categories = Categorie::withCount('users')->orderBy('nom')->get();
    $pending = $categories->where('valide', false);
    $validated = $categories->where('valide', true);
    return view('admin.categories.index', compact('categories', 'pending', 'validated'));
}

public function providerIndex() {

    $categories = Categorie::withCount('users')->orderBy('nom')->get();
    $pending = $categories->where('valide', false);
    $validated = $categories->where('valide', true);
    return view('provider.categories.index', compact('categories', 'pending', 'validated'));
}
/*
    public function serviceDescription($id)
    {
        
         //$categories = Categories:: where('id',$id)->update(['status' => Status::COMPLETED]);
        //$categories = Categories::findOrFail($id);
        $categories = Categorie::find($id);
       //$categories = Categories::all();
        // Passer la variable à la vue [1]
        // return view('pages.service_description',['categories' => Categories::find($id)]);
        return view('pages.service', compact('categories'));
        
    }
        */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
         return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|unique:categories,nom|max:255',
        'description' => 'nullable|string',
        //'mise_en_avant' => 'boolean',
    ]);
     // ... MAIS on force une chaîne vide si le champ est absent pour éviter l'erreur SQL
    $validated['description'] = $request->input('description', 'Aucune description fournie');

    $validated['mise_en_avant'] = $request->has('mise_en_avant');
    $categorie = new Categorie($validated);

    if (auth()->user()->role === 'ADMIN') {
        $categorie->valide = true;
        $categorie->save();
        
        // Postcondition : Retour sur l'écran d'accueil de l'administrateur
        return redirect()->route('admin.dashboard')->with('status', 'Catégorie officielle créée.');
    }

    // Cas du Prestataire (Suggestion)
    $categorie->valide = false;
    $categorie->user_id = auth()->id(); // On garde trace de l'auteur
    $categorie->save();

    return back()->with('status', 'Votre suggestion est en attente de modération.');
}

    /**
     * Display the specified resource.
     */
    
    public function show($id) // <-- Assure-toi que $id est bien ici
{
    // Ligne 64 : Utilisation de la variable
    //$categories = Categorie::find($id);
    $categories = Categorie::findOrFail($id); 
    return view('categories.show', compact('categories'));
}
    
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Categorie $categorie)
    {
        /*
        // SÉCURITÉ : Seul l'Admin OU le Propriétaire peut modifier
    if (auth()->user()->role !== 'ADMIN' && $categorie->_id !== auth()->id()) {
        abort(403, "Vous n'avez pas le droit de modifier cette catégorie.");
    }
*/
    $request->validate([
        'nom' => 'required|unique:categories,nom,' . $categorie->id,
    ]);

    // On force une chaîne vide si la description est absente pour éviter l'erreur 1048
    $categorie->nom = $request->nom;
    $categorie->description = $request->input('description') ?? ''; 
   $categorie->valide = $request->has('valide');
   $categorie->mise_en_avant = $request->has('mise_en_avant');

    $categorie->save();

    $route = auth()->user()->role === 'ADMIN' ? 'admin.dashboard' : 'provider.dashboard';

    return redirect()->route($route)
    ->with('success', 'Catégorie mise à jour.');
    
    }

  /*
   public function update(Request $request, Categorie $categorie)
{
    // SÉCURITÉ : Seul l'Admin OU le Propriétaire peut modifier
    if (auth()->user()->role !== 'ADMIN' && $categorie->user_id !== auth()->id()) {
        abort(403, "Vous n'avez pas le droit de modifier cette catégorie.");
    }

    $validated = $request->validate([
        'nom' => 'required|unique:categories,nom,' . $categorie->id,
        'description' => 'nullable',
        'validé' => 'boolean', // Seul l'admin devrait pouvoir changer ça
    ]);

    // Protection supplémentaire : Seul l'admin peut valider une catégorie
    if (auth()->user()->role !== 'ADMIN') {
        unset($validated['valide']); 
    }

    $categorie->update($validated);

    // Redirection dynamique selon le rôle
    $route = auth()->user()->role === 'ADMIN' ? 'admin.dashboard' : 'provider.dashboard';
    
    return redirect()->route($route)->with('success', 'Catégorie mise à jour.');
}

*/


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id) // On reçoit l'ID (ex: 5)
{
        $category = Categorie::findOrFail($id);

    // Si la catégorie contient des prestataires, on gère le transfert
    if ($category->users()->exists()) {
        $request->validate([
            'transfer_to' => 'required|exists:categories,id|different:'.$id
        ]);

        $newCategory = Categorie::find($request->transfer_to);

        foreach ($category->users as $user) {
            // Transfert vers la nouvelle catégorie choisie
            $user->categories()->detach($category->id);
            $user->categories()->syncWithoutDetaching([$newCategory->id]);
            
            // Notification automatique optionnelle ici
        }
    }

    // Suppression physique de la catégorie
    $category->delete();

    // Postcondition : Retour à l'accueil administrateur
    $route = auth()->user()->role === 'ADMIN' ? 'admin.dashboard' : 'provider.dashboard';

    return redirect()->route($route)
    ->with('success', 'Catégorie supprimée et prestataires transférés avec succès.');

}
}