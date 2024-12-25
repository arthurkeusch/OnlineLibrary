<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'Categories';
    protected $primaryKey = 'id_category';

    protected $fillable = [
        'name_category',
    ];

    public $timestamps = false;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Books::class, 'BookCategory', 'id_category', 'id_book');
    }
}
