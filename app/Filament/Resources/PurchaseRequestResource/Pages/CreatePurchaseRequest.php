<?php

namespace App\Filament\Resources\PurchaseRequestResource\Pages;

use App\Filament\Resources\PurchaseRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseRequest extends CreateRecord
{
    protected static string $resource = PurchaseRequestResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}

