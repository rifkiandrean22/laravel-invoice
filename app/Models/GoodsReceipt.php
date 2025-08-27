<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_id' ,
        'warehouse_id',
        'quantity',
        'receipt_date',
        'reference',
        'vendor_id',
        'gr_number',
        'received_date',
        'notes',
    ];

    // Relasi ke Purchase Order
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    // Relasi ke Werehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Auto-generate GR number sebelum insert
    protected static function booted()
    {
        static::creating(function ($gr) {
            if (empty($gr->gr_number)) {
                $gr->gr_number = 'GR-' . str_pad(GoodsReceipt::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
