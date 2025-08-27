<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;
protected $table = 'purchase_requests'; // sesuaikan dengan nama tabel baru
    // Masukkan semua kolom yang ingin diisi massal
    protected $fillable = [
        'item',
        'nama_item',
        'quantity',
        'nomor_purchase_request',
        'nama_purchase_request',
		'keterangan',
        'price',
        'total',
        'reviewed_by',
        'status',   // pastikan ada
        'urgensi', // kolom urgensi baru
        'created_at',
        'updated_at',
    ];

    // Relasi ke items
    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    // Relasi ke PO
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    // Otomatis buat nomor pengajuan saat create
   protected static function booted()
{
    static::creating(function ($purchaseRequest) {
        if (!$purchaseRequest->nomor_purchase_request) {
            $latest = self::latest('id')->first();
            $number = $latest ? $latest->id + 1 : 1;
            $purchaseRequest->nomor_purchase_request = 'PR-' . date('Ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }
    });
}
}

