<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utilisateurs extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'adresse_id',
        'tva',
        'telephone_mobile',
        'site_web',
        'langue',
        'role',
        'nombre_tentatives_connexion',
        'est_banni',
        'newsletter',
        'inscription_confirmation_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'inscription_confirmation_at' => 'datetime',
        'password' => 'hashed',
        'est_banni' => 'boolean',
        'newsletter' => 'boolean',
        'nombre_tentatives_connexion' => 'integer',
    ];

    
    public function adresse(): BelongsTo
    {
        return $this->belongsTo(Adresse::class);
    }

    
    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isProvider(): bool
    {
        return $this->role === 'PROVIDER';
    }

    public function categories()
    {
        
        return $this->belongsToMany(
            Categories::class, 
            'categorie_prestataire', // Nom de votre table
            'prestataire_id',         // FK de cette table
            'categorie_id'           // FK de la table cible
        );
    }
}
