<?php

namespace App\Filament\Resources\VendorResource\Pages;

use App\Filament\Resources\VendorResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListVendors extends ListRecords
{
    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // <- ini yang munculkan tombol "Create"
        ];
    }
}
