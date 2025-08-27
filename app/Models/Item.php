<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'id', 
        'code', 
        'name', 
        'category', 
        'unit',
        'stock',
        'created_at',
        'updated_at'
        
    ];

    public function goodsReceipts()
{
    return $this->hasMany(GoodsReceipt::class);
}
}
