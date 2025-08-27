<?php

namespace App\Filament\Resources\GoodsReceiptResource\Pages;

use App\Filament\Resources\GoodsReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Item;
class CreateGoodsReceipt extends CreateRecord
{
    protected static string $resource = GoodsReceiptResource::class;

    protected function afterCreate(): void
    {
        $item = Item::find($this->record->item_id);
        if ($item) {
            $item->stock += $this->record->quantity;
            $item->save();
        }
    }
}
