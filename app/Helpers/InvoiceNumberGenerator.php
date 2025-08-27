<?php

namespace App\Helpers;

use App\Models\AccountsPayable;

class InvoiceNumberGenerator
{
    public static function generate(): string
    {
        $year = date('Y');
        $lastInvoice = AccountsPayable::whereYear('created_at', $year)
            ->latest('id')
            ->first();

        $lastNumber = $lastInvoice
            ? intval(substr($lastInvoice->invoice_number, -4))
            : 0;

        return 'INV-' . $year . '-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
