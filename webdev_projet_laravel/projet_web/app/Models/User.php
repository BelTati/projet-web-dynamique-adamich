<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail; // Import indispensable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importez ceci

class User extends Authenticatable   implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = "users";
    /**
     * The attributes that are mass assignable.
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
        'email_verified_at',
        'inscription_confirmation_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'est_banni' => 'boolean',
        'newsletter' => 'boolean',
        'nombre_tentatives_connexion' => 'integer',
    ];

    public function hasVerifiedEmail()
{
    return ! is_null($this->email_verified_at);
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
            Categorie::class, 
            'categorie_prestataires', // Nom de votre table
            'prestataire_id',         // FK de cette table
            'categorie_id'           // FK de la table cible
        );
    }
    public function stages()
    {
         return $this->hasMany(Stage::class, 'prestataire_id');
    }

    public function adresses()
    {
        // 'user_id' doit être le nom de la FK dans votre table 'adresses'
        return $this->belongsTo(Adresse::class, 'adresse_id', 'id');
    }

}   
