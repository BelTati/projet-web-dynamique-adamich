<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adresse;

class AdresseController extends Controller
{
    /**
     * Cette méthode peut être appelée en interne par d'autres contrôleurs
     * ou via une route API/AJAX.
     */
    public function storeOrUpdate(Request $request, $adresseId = null)
    {
        // 1. Validation des champs spécifiques à l'adresse
        $validatedData = $request->validate([
            'rue'    => 'required|string|max:255',
            'numéro' => 'required|string|max:10',
            'ville'  => 'required|string|max:100',
            'cp'     => 'required|string|max:10',
            'pays'   => 'required|string|max:100',
            'boîte'  => 'nullable|string|max:10',
        ]);

        // 2. Mise à jour si l'ID existe, sinon création
        return Adresse::updateOrCreate(
            ['id' => $adresseId],
            $validatedData
        );
    }
}
