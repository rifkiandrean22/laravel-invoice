<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{	

	protected static function booted()
    {
        static::saving(function ($item) {
            $item->total = $item->quantity * $item->price;
        });

        // Update invoice total setiap kali item dibuat/diubah/hapus
        static::saved(fn($item) => $item->invoice->updateTotal());
        static::deleted(fn($item) => $item->invoice->updateTotal());
    }

	public function invoice()
{
    return $this->belongsTo(Invoice::class);
}
protected $fillable = ['invoice_id', 'name', 'quantity', 'price', 'total'];
}
