<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = 'chart_of_accounts';

    protected $fillable = [
    'id',
    'code',
    'name',
    'type',
    'is_active',
    // kolom lain kalau ada
    ];
}
