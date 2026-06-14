<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'member_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];

    /**
     * Relasi ke Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke Book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relasi ke Fine (Denda)
     */
    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    /**
     * Scope helper untuk transaksi aktif (status = dipinjam)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope helper untuk transaksi terlambat (status = dipinjam dan melewati due_date)
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'dipinjam')
                     ->where('due_date', '<', now()->toDateString());
    }
}
