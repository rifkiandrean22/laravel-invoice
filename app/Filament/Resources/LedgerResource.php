<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LedgerResource\Pages;
use App\Filament\Resources\LedgerResource\RelationManagers;
use App\Models\Ledger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LedgerResource extends Resource
{
    protected static ?string $model = Ledger::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 4; // General Ledger
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\DatePicker::make('entry_date')
            ->required(),
            Forms\Components\Select::make('account_id')
            ->relationship('ChartOfAccountResource', 'name')
            ->required(),
            Forms\Components\TextInput::make('debit')
            ->numeric()
            ->default(0)
            ->prefix('Rp'),
            Forms\Components\TextInput::make('credit')
            ->numeric()
            ->default(0)
            ->prefix('Rp'),
            Forms\Components\Textarea::make('description'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('entry_date')->date(),
            Tables\Columns\TextColumn::make('account.name')->sortable(),
            Tables\Columns\TextColumn::make('debit')->money('idr'),
            Tables\Columns\TextColumn::make('credit')->money('idr'),
            Tables\Columns\TextColumn::make('description')->limit(30),
        ])
        ->filters([])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            'index' => Pages\ListLedgers::route('/'),
            'create' => Pages\CreateLedger::route('/create'),
            'edit' => Pages\EditLedger::route('/{record}/edit'),
        ];
    }
}
