<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type',
        'account',
        'amount',
        'currency',
        'description',
        'created_at',
        'update_at',
        'debit',
        'credit',
        'transaction_date', // ← tambahkan ini
        // kolom lain sesuai kebutuhan
    ];
}
