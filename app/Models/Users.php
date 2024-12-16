<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'Users';
    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'first_name_user',
        'last_name_user',
        'isAdmin',
    ];

    protected $hidden = [
        'password', // Ne pas exposer le mot de passe dans les résultats JSON
    ];

    // Méthode pour utiliser le bon champ d'identification (username ici)
    public function getAuthIdentifierName()
    {
        return 'username';
    }

}
