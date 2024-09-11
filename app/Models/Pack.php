<?php

namespace App\Models;

use App\Models\Compte;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pack extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'montant', 'benefice','icon'];

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
