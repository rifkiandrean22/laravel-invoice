<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
    Forms\Components\TextInput::make('invoice_number')
    ->label('Invoice Number')
    ->default(function () {
        $year = now()->format('Y');
        $lastInvoice = \App\Models\Invoice::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastInvoice
            ? intval(substr($lastInvoice->invoice_number, -4)) + 1
            : 1;

        return 'INV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    })
    ->disabled()        // supaya user tidak bisa edit
    ->dehydrated(false), // jangan ikut mass-assign
   


            DatePicker::make('invoice_date')
                ->label('Invoice Date')
                ->required(),

            TextInput::make('customer_name')
                ->label('Customer Name')
                ->required(),

            TextInput::make('amount')
                ->label('Amount')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            Select::make('status')
                ->options([
                    'unpaid' => 'Unpaid',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ])
                ->default('unpaid')
                ->required(),
Forms\Components\Select::make('category')
    ->label('Kategori')
    ->options([
        'Rental' => 'Rental',
        'Sparepart' => 'Sparepart',
        'Maintenance' => 'Maintenance',
        'Lainnya' => 'Lainnya',
    ])
    ->required(),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('invoice_number')
                ->label('Invoice Number')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false),

            TextColumn::make('invoice_date')
                ->label('Invoice Date')
                ->sortable()
                ->date(),

            TextColumn::make('customer_name')
                ->label('Customer')
                ->sortable()
                ->searchable(),

            TextColumn::make('category')
                ->label('Category')
                ->sortable()
                ->sortable(),

            TextColumn::make('amount')
                ->label('Amount')
                ->money('IDR'),

            BadgeColumn::make('status')
                ->label('Status')
                ->sortable()
                ->colors([
                    'danger' => 'unpaid',
                    'success' => 'paid',
                    'secondary' => 'cancelled',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('download')
                ->label('Download PDF')
                ->url(fn ($record) => route('invoice.download', $record->id))
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-down-tray'),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
