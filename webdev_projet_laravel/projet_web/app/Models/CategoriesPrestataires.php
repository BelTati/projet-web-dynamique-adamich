<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriesPrestataires extends Model
{
     // Indiquez le nom exact de votre table si elle n'est pas standard
    protected $table = 'categorie_prestataire';

    // Comme vous utilisez une clé primaire composite (PK/FK), 
    // on désactive l'incrémentation automatique
    public $incrementing = false;

    protected $fillable = [
        'prestataire_id',
        'categorie_id'
    ];

}
