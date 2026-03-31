<?php
namespace App\Repositories;

use App\Models\Categorie;

class CategorieRepository
{
    // Récupérer toutes les catégories pour l'admin
    public function getAll()
    {
        return Categorie::all();
    }

    // Créer une catégorie
    public function create(array $data)
    {
        return Categorie::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'mise_en_avant' => isset($data['mise_en_avant']),
            'validé' => isset($data['validé']),
        ]);
    }

    // Mettre à jour une catégorie
    public function update($id, array $data)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->update([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'mise_en_avant' => isset($data['mise_en_avant']),
            'validé' => isset($data['validé']),
        ]);
        return $categorie;
    }

    // Supprimer une catégorie
    public function delete($id)
    {
        $categorie = Categorie::findOrFail($id);
        return $categorie->delete();
    }
}