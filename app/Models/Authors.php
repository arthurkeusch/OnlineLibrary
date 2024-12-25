<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Authors extends Model
{
    use HasFactory;

    protected $table = 'Authors';
    protected $primaryKey = 'id_author';

    public $timestamps = false;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Books::class, 'WrittenBy', 'id_author', 'id_book');
    }
}
