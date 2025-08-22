<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

protected static function booted()
{
    static::creating(function ($invoice) {
        if (empty($invoice->invoice_number)) {
            $year = now()->format('Y');

            $lastInvoice = self::whereYear('created_at', $year)
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = $lastInvoice
                ? intval(substr($lastInvoice->invoice_number, -4)) + 1
                : 1;

            $invoice->invoice_number = 'INV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }
    });
}


    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'customer_name',
        'category',
        'amount',
        'status',
    ];
protected $casts = [
        'invoice_date' => 'date',
    ];


    // kalau ada relasi item
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);

    }
}


