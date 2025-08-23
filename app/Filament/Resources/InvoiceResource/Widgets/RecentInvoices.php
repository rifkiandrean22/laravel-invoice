<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RecentInvoices extends BaseWidget
{
    protected int | string | array $columnSpan = 'full'; // biar lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Invoice::query()->latest()->limit(5) // tampilkan 5 terakhir
            )
            ->columns([
                TextColumn::make('invoice_number')->label('No.'),
                TextColumn::make('invoice_date')->date(),
				TextColumn::make('customer_name')->label('Customer'),
                TextColumn::make('status')->badge(),
				TextColumn::make('total')
                    ->label('Total')
					->money('IDR', true), // true = include decimals
                
            ]);
    }
}
