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

    public function book()
    {
        return $this->belongsTo(Books::class, 'id_book');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }
}
