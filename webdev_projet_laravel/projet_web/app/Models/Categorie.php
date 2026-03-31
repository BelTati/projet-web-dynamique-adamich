<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Categorie extends Model
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
        'categorie_prestataires', 
        'categorie_id', 
        'prestataire_id'
    )
     ->using(CategoriePrestataire::class);

    }
    
    public function users() {
        return $this->belongsToMany(User::class, 'categorie_prestataires', 'categorie_id', 'prestataire_id');
    }
}
