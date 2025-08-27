<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'nomor_po', 
        'nama_vendor', 
        'tanggal_po', 
        'total', 
        'status' , 
        'dibuat_oleh', 
        'created_at', 
        'updated_at',
        'payment_proof',

    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
	
	protected static function booted()
	{
    static::creating(function ($po) {
        if (empty($po->nomor_po)) {
            $count = self::count() + 1;
            $po->nomor_po = 'PO-' . now()->format('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        }
    });
	}
    // app/Models/PurchaseOrder.php
public function vendor()
{
    return $this->belongsTo(Vendor::class, 'nama_vendor');
}
public function goodsReceipts()
{
    return $this->hasMany(GoodsReceipt::class);
}
}
