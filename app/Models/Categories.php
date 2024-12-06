<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'Categories'; // Nom de la table des catégories
    protected $primaryKey = 'id_category'; // Clé primaire

    // Attributs modifiables en masse
    protected $fillable = [
        'name_category',
    ];

    public $timestamps = false;

    // Relation avec les livres via la table pivot
    public function books()
    {
        return $this->belongsToMany(Books::class, 'BookCategory', 'id_category', 'id_book');
    }
}
