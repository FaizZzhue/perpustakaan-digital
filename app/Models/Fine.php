<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'transaction_id',
        'late_days',
        'fine_amount',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    /**
     * Relasi ke Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
