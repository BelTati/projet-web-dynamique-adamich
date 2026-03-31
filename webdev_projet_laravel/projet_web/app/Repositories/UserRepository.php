<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Categorie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository
{
   
public function updateProfile(User $user, array $data)
{
    return DB::transaction(function () use ($user, $data) {
        
        // 1. Mise à jour ou Création de l'Adresse (Table liée)
        // On récupère l'adresse actuelle ou on en crée une nouvelle
        $adresse = $user->adresses ?: new \App\Models\Address();
        $adresse->rue    = $data['rue'] ?? $adresse->rue;
        $adresse->numero = $data['numéro'] ?? $adresse->numero;
        $adresse->boite  = $data['boîte'] ?? $adresse->boite; // Optionnel
        $adresse->cp     = $data['cp'] ?? $adresse->cp;
        $adresse->ville  = $data['ville'] ?? $adresse->ville;
        $adresse->pays   = $data['pays'] ?? $adresse->pays;
        $adresse->save();

        // 2. Préparation des données de l'utilisateur
        $updateData = [
            'nom'         => $data['nom'],
            'prenom'      => $data['prenom'] ?? $user->prenom,
            'adresse_id'  => $adresse->id, // Liaison cruciale
            'tva'         => $data['tva'] ?? $user->tva,
            'telephone_mobile' => $data['telephone'] ?? $user->telephone_mobile,
            'site_web'    => $data['site_web'] ?? $user->site_web,
            'description' => $data['description'] ?? $user->description,
        ];

        // 3. Gestion de l'Avatar / Logo (Stockage public)
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            if ($user->avatar) { Storage::disk('public')->delete($user->avatar); }
            $updateData['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        // 4. Gestion du Mot de passe
        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        // 5. Sauvegarde finale de l'utilisateur
        $user->update($updateData);

        // 6. Synchronisation des catégories (Table Pivot)
        if (isset($data['categories'])) {
            $user->categories()->sync($data['categories']);
        }

        // 7. Suggestion d'une nouvelle catégorie (Modération Admin)
        if (!empty($data['new_category'])) {
            \App\Models\Categorie::create([
                'nom' => $data['new_category'],
                'valide' => false, // Doit être validé par l'admin
                'user_id' => $user->id
            ]);
        }

        return true;
    });
}




/*
public function updateProfile(User $user, array $data)
    {
       

    // Gestion de l'avatar si une image est envoyée
        if (isset($data['avatar'])) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Stocker le nouveau
            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        return $user->update([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
           // 'avatar' => $data['avatar'] ?? $user->avatar,
        ]);
        



        return DB::transaction(function () use ($user, $data) {
            
            // 1. Préparation des données de base
            $updateData = [
                'nom'         => $data['nom'],
                'tva'         => $data['tva'] ?? $user->tva,
                'telephone'   => $data['telephone'] ?? $user->telephone,
                'site_web'    => $data['site_web'] ?? $user->site_web,
                'description' => $data['description'] ?? $user->description,
            ];
        


           
            // 2. Gestion du Logo (Stockage Docker)
            if (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
                // Supprimer l'ancien fichier si existant
                if ($user->logo) { Storage::disk('public')->delete($user->logo); }
                $updateData['logo'] = $data['logo']->store('logos', 'public');
            }

           
           
           
            // 3. Gestion du Mot de passe (Uniquement si rempli)
            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            // 4. Mise à jour de l'utilisateur
            $user->update($updateData);

            // 5. Synchronisation des catégories (Table Pivot)
            // On utilise sync pour correspondre exactement aux cases cochées
            $user->categories()->sync($data['categories'] ?? []);

            // 6. Suggestion d'une nouvelle catégorie (Modération)
            if (!empty($data['new_category'])) {
                Categorie::create([
                    'nom' => $data['new_category'],
                    'is_validated' => false, // Attente admin
                    'user_id' => $user->id   // Trace du demandeur
                ]);
            }

            return true;
        });
   
        // ... tes mises à jour (nom, tva, etc.) ...

    // 1. Synchronisation des catégories existantes cochées
    if (isset($data['categories'])) {
        $user->categories()->sync($data['categories']);
    }

    // 2. ACTION : Création de la suggestion (si le champ est rempli)
    if (!empty($data['new_category'])) {
        // On crée la catégorie en mode "non validé"
        \App\Models\Categorie::create([
            'nom' => $data['new_category'],
            'is_validated' => false, // Important : l'admin doit modérer
            'user_id' => $user->id   // On garde une trace de qui l'a proposée
        ]);
        }

    return true;
    }
    */  
}