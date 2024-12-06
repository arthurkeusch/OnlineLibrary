<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanHistory extends Model
{
    use HasFactory;

    protected $table = 'LoanHistory';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_copy',
        'id_user',
        'start_loan',
        'end_loan',
    ];

    public function copy()
    {
        return $this->belongsTo(Copies::class, 'id_copy');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }
}
