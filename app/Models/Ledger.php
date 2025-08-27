<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
     // Relasi ke ChartOfAccountResource
    public function ChartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

}
