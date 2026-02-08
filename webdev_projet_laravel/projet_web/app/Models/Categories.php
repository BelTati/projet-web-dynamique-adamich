<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['nom', 'description', 'mise_en_avant', 'valide'];
    protected $casts = [
        'mise_en_avant' => 'boolean',
        'valide' => 'boolean',
    ];
   
    public function prestataires()

    {
    return $this->belongsToMany(
        User::class, 
        'categorie_prestataire', 
        'categorie_id', 
        'prestataire_id'
    );

    }
}
