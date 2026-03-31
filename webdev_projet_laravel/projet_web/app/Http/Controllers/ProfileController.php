<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Adresse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

class ProfileController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function edit()

    {
        // On récupère l'utilisateur connecté
        $user = auth()->user()->load('adresses');

        // On retourne la vue en lui passant l'utilisateur
        return view('profile.user_edit', compact('user'));
       // return view('profile.user_edit', ['user' => Auth::user()]);
    }


 public function update(Request $request)
{
    $user = auth()->user();

    // 1. Validation (utilisez les noms exacts de vos inputs HTML)
    $request->validate([
        'nom'    => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'rue'    => 'required|string',
        'numéro' => 'required|string|max:10', // Vérifiez que name="numéro" dans le HTML
        'ville'  => 'required|string',
        'cp'     => 'required|string',
        'pays'   => 'required|string|max:100',
        'boîte'  => 'nullable|string|max:10',
    ]);

    // 2. Mise à jour ou Création (Notez le 'adresses' avec un S)
    $adresse = $user->adresses ?: new \App\Models\Adresse();
    
    // On remplit les champs (Assurez-vous qu'ils sont dans le $fillable du modèle Adresse)
    $adresse->fill($request->only(['rue', 'numéro', 'ville', 'cp', 'pays', 'boîte']));
    $adresse->save();

    // 3. Mise à jour de l'utilisateur
    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->adresse_id = $adresse->id; // Liaison
    
    // Gestion de l'avatar si présent
    if ($request->hasFile('avatar')) {
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    }

    $user->save();

   
        // Redirection vers l'accueil avec un message flash
        return redirect()->route('home')->with('status', 'Votre profil a été mis à jour avec succès !');
         
}


    }
