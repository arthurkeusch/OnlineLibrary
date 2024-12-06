<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WrittenBy extends Model
{
    use HasFactory;

    protected $table = 'WrittenBy';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_book',
        'id_author',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class, 'id_book');
    }

    public function author()
    {
        return $this->belongsTo(Authors::class, 'id_author');
    }
}
