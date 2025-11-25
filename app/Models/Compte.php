<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'rib',
        'solde',
        'client_id'
    ];

    // Relation : un compte appartient à un seul client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
