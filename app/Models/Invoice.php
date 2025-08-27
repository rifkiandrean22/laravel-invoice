<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	
	public function getTotalFormattedAttribute()
{
    return 'Rp ' . number_format($this->total, 2, ',', '.');
}
public function items()
{
    return $this->hasMany(InvoiceItem::class);
}

public function updateTotal()
    {
        $this->total = $this->items()->sum('total');
        $this->save();
    }


    protected $fillable = [
        'invoice_number',
		'description',
        'invoice_date',
        'customer_name',
		'payment_description',
		'payment_note',
        'category',
		'payment_proof',
		'total',
        'status',
    ];
protected $casts = [
        'invoice_date' => 'date',
    ];

public static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $lastInvoice = self::orderBy('id', 'desc')->first();
                $nextNumber = $lastInvoice ? ((int) $lastInvoice->id + 1) : 1;
                $invoice->invoice_number = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }
    // kalau ada relasi item
    
}


