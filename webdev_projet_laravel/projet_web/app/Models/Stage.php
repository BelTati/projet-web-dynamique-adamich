<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stage extends Model
{
     protected $fillable = [
        'nom', 'description', 'date_debut', 'date_fin', 
        'date_parution_debut', 'date_parution_fin', 
        'tarif', 'prestataire_id', 'info_complementaire'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_parution_debut' => 'date',
        'date_parution_fin' => 'date',
        'tarif' => 'decimal:2',
    ];

    // Relation inverse : Le stage appartient à un prestataire
    public function prestataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }
}
