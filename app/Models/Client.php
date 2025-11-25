<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

protected $fillable = [
    'nom',
    'prenom',
    'cin',
    'adresse',
    'email',
];



    // Relation : 1 client → plusieurs comptes
    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
