<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;

    protected $table = 'Authors';
    protected $primaryKey = 'id_author';

    public $timestamps = false;

    // Relation avec les livres
    public function books()
    {
        return $this->belongsToMany(Books::class, 'WrittenBy', 'id_author', 'id_book');
    }
}
