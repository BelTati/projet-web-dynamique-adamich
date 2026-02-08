<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    protected $fillable = [
        'nom', 'description', 'date_debut', 'date_fin', 
        'date_parution_debut', 'date_parution_fin', 
        'tarif', 'info_complementaire', 'user_id'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_parution_debut' => 'date',
        'date_parution_fin' => 'date',
    ];

    /**
     * Relation vers le prestataire
     */
    public function prestataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Filtre : Uniquement les stages dont la date de parution est valide
     * Utilisation : Stage::enLigne()->get();
     */
    public function scopeEnLigne($query)
    {
        $aujourdhui = Carbon::today();
        return $query->where('date_parution_debut', '<=', $aujourdhui)
                     ->where('date_parution_fin', '>=', $aujourdhui);
    }
}
