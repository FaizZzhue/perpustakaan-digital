<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'member_code',
        'name',
        'nik',
        'address',
        'phone',
        'email',
        'photo',
        'qr_code',
        'status',
    ];

    /**
     * Relasi ke Transaction
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
