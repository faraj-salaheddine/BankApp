<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Virement extends Model
{
    protected $fillable = [
        'compte_source',
        'compte_destination',
        'montant'
    ];

    public function source() {
        return $this->belongsTo(Compte::class, 'compte_source');
    }

    public function destination() {
        return $this->belongsTo(Compte::class, 'compte_destination');
    }
}
