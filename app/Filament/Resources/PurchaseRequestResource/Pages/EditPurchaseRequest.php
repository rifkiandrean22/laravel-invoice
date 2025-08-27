<?php

namespace App\Filament\Resources\PurchaseRequestResource\Pages;

use App\Filament\Resources\PurchaseRequestResource;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseRequest extends EditRecord
{
    protected static string $resource = PurchaseRequestResource::class;
protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}

