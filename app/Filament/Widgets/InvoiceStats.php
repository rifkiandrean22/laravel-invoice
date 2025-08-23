<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InvoiceStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Invoices', Invoice::count()),
            Stat::make('Unpaid', Invoice::where('status', 'unpaid')->count()),
            Stat::make('Paid', Invoice::where('status', 'paid')->count()),
        ];
    }
}
