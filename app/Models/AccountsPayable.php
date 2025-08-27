<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsPayable extends Model
{
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'category', // Pilihan Kategori Utilities, Supplies, Maintenance, Payroll Related, Operational, Other Expenses 
        'vendor_name', // Pilihan Nama Vendor
        'coa_id',
        'coa', // Pilihan COA
        'name', // Nama Penerima dalam Vendor tersebut
        'description',
        'due_date',
        'total',
        'status',
        'payment_proof', // ← tambahkan ini
        'payment_date',
        'payment_note',
    ];

    public function vendor()
{
    return $this->belongsTo(Vendor::class, 'nama_vendor');
}

    public function ChartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'coa_id');
    }

protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil invoice terakhir
            $lastInvoice = self::orderBy('id', 'desc')->first();

            // Kalau belum ada, mulai dari 1
            $nextNumber = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;

            // Format nomor invoice (contoh: INV-2025-0001)
            $model->invoice_number = 'INV-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
