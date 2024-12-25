<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Books extends Model
{
    use HasFactory;

    protected $table = 'Books';
    protected $primaryKey = 'id_book';

    protected $fillable = [
        'image_book',
        'publication_date_book',
        'name_book',
        'description_book',
    ];

    public $timestamps = false;

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Authors::class, 'WrittenBy', 'id_book', 'id_author');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categories::class, 'BookCategory', 'id_book', 'id_category');
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copies::class, 'id_book', 'id_book');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Reviews::class, 'id_book', 'id_book');
    }
}
