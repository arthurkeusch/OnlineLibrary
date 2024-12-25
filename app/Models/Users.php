<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'Users';
    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'first_name_user',
        'last_name_user',
        'isAdmin',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function hasBorrowedBook(int $id_book): bool
    {
        return LoanHistory::query()
            ->join('Copies', 'LoanHistory.id_copy', '=', 'Copies.id_copy')
            ->where('LoanHistory.id_user', $this->id_user)
            ->where('Copies.id_book', $id_book)
            ->exists();
    }
}
