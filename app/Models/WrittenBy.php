<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function book(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'id_book');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Authors::class, 'id_author');
    }
}
