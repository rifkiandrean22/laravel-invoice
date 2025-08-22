<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use PDF;

class InvoiceController extends Controller
{
    public function downloadPdf($id)
    {
        $invoice = Invoice::findOrFail($id);

        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
