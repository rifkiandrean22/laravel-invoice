<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;

class RecentInvoices extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery()
    {
        return Invoice::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('invoice_number')->label('No.'),
            TextColumn::make('customer_name')->label('Customer'),
            TextColumn::make('amount')->formatStateUsing(fn ($state) => number_format((int)$state, 0, ',', '.')),
            BadgeColumn::make('status')->colors([
                'danger' => 'unpaid',
                'success' => 'paid',
                'danger' => 'cancelled',
            ]),
            TextColumn::make('invoice_date')->date(),
        ];
    }
}
