<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class FinanceReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 7; // Reports
    protected static ?string $navigationGroup = 'Finance';
    protected static string $view = 'filament.pages.finance-reports';
}
