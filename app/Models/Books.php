<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $table = 'Books'; // Nom de la table
    protected $primaryKey = 'id_book'; // Clé primaire

    // Attributs modifiables en masse
    protected $fillable = [
        'image_book',
        'publication_date_book',
        'name_book',
        'description_book',
    ];

    // Désactive les timestamps si la table ne les contient pas
    public $timestamps = false;

    // Relation avec les auteurs
    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'WrittenBy', 'id_book', 'id_author');
    }
}
