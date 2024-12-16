<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'Reviews';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_book',
        'id_user',
        'content_review',
        'date_review',
    ];

    // Relation avec le livre
    public function book()
    {
        return $this->belongsTo(Books::class, 'id_book', 'id_book');
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id_user');
    }
}
