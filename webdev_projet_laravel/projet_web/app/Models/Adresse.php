<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adresse extends Model
{
    use HasFactory;
        protected $fillable = [
        'rue',
        'numéro',
        'ville',
        'cp',
        'pays',
        'boîte'
    ];
}
