<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InvoiceResource;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getRedirectUrl(): string
    {
        // Setelah create, langsung ke list
        return $this->getResource()::getUrl('index');
    }
	
}