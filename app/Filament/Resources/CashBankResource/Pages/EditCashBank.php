<?php

namespace App\Filament\Resources\CashBankResource\Pages;

use App\Filament\Resources\CashBankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCashBank extends EditRecord
{
    protected static string $resource = CashBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
