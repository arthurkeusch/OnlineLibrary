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

    // Relation avec les catégories via la table pivot
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'BookCategory', 'id_book', 'id_category');
    }

    // Relation avec les copies
    public function copies()
    {
        return $this->hasMany(Copies::class, 'id_book', 'id_book');
    }

    // Relation avec les reviews
    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'id_book', 'id_book');
    }
}
