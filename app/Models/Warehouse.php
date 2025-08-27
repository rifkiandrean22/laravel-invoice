<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{   
    protected $fillable = [
        'id', 
        'code', 
        'name', 
        'location', 
        'created_at',
        'updated_at'
        
    ];

    public function goodsReceipts()
{
    return $this->hasMany(GoodsReceipt::class);
}
}
