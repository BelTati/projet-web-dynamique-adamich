<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProviderRepository
{
    public function updateProfile(User $user, array $data)
    {
        // 1. Mise à jour des infos de base
        $user->fill([
            'nom' => $data['nom'],
            'description' => $data['description'],
            'tva' => $data['tva'],
            'telephone' => $data['telephone'],
            'site_web' => $data['site_web'],
        ]);

       /*
        // 2. Gestion du Logo
        if (isset($data['logo'])) {
            $user->logo = $data['logo']->store('logos', 'public');
        }
*/
        // 3. Gestion du Mot de passe (uniquement si rempli)
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
/*
        // 4. Gestion des Photos (Slider)
        if (isset($data['photos'])) {
            foreach ($data['photos'] as $photo) {
                // Ici, on suppose une relation 'photos' dans ton modèle User
                $path = $photo->store('provider_photos', 'public');
                $user->photos()->create(['path' => $path]);
            }
                
        }
*/
        return $user->save();
    }
}