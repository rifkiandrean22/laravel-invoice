<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    // Tambahkan semua kolom yang akan diisi massal
    protected $fillable = [
        'purchase_request_id',
        'nama_item',
        'jumlah',
        'harga',
        'total',
    ];
	
	protected static function booted()
    {
        static::saving(function ($item) {
            $item->total = $item->jumlah * $item->harga;
        });
    }
	
    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    
}

