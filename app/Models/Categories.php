<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'BookCategory';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_book',
        'id_category',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class, 'id_book');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'id_category');
    }
}
