<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Copies extends Model
{
    use HasFactory;

    protected $table = 'Copies';
    protected $primaryKey = 'id_copy';

    public $timestamps = false;

    protected $fillable = [
        'isAvailable',
        'id_book',
        'id_state',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'id_book');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(States::class, 'id_state');
    }
}
