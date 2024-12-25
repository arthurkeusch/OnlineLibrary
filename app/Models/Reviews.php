<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'Reviews';
    public $incrementing = false;

    protected $primaryKey = ['id_book', 'id_user'];

    public $timestamps = false;

    protected $fillable = [
        'id_book',
        'id_user',
        'content_review',
        'date_review',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'id_book', 'id_book');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id_user', 'id_user');
    }

    /**
     * Surcharge de la méthode `getKeyName` pour gérer les clés composites.
     *
     * @return array
     */
    public function getKeyName(): array
    {
        return $this->primaryKey;
    }

    /**
     * Surcharge de la méthode `setKeysForSaveQuery` pour gérer les clés composites.
     *
     * @param Builder $query
     * @return Builder
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, $this->getAttribute($key));
        }

        return $query;
    }
}
