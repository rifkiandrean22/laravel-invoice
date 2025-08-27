<?php

namespace App\Filament\Resources\CashBankResource\Pages;

use App\Filament\Resources\CashBankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashBanks extends ListRecords
{
    protected static string $resource = CashBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
