<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanHistory extends Model
{
    use HasFactory;

    protected $table = 'LoanHistory';

    protected $primaryKey = 'id_loanhistory';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_copy',
        'id_user',
        'start_loan',
        'end_loan',
    ];

    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copies::class, 'id_copy');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id_user');
    }
}
