<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashBankResource\Pages;
use App\Filament\Resources\CashBankResource\RelationManagers;
use App\Models\CashBank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashBankResource extends Resource
{
    protected static ?string $model = CashBank::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 3; // Cash & Bank
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\DatePicker::make('transaction_date')->required(),
            Forms\Components\Select::make('type')->options([
                'cash_in' => 'Cash In',
                'cash_out' => 'Cash Out',
                'bank_in' => 'Bank In',
                'bank_out' => 'Bank Out',
            ])->required(),
            Forms\Components\TextInput::make('amount')->numeric()->required()->prefix('Rp'),
            Forms\Components\Textarea::make('description'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('transaction_date')->date(),
            Tables\Columns\TextColumn::make('type')->badge()->colors([
                'success' => 'cash_in',
                'danger' => 'cash_out',
                'info' => 'bank_in',
                'warning' => 'bank_out',
            ]),
            Tables\Columns\TextColumn::make('amount')->money('idr'),
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
            'index' => Pages\ListCashBanks::route('/'),
            'create' => Pages\CreateCashBank::route('/create'),
            'edit' => Pages\EditCashBank::route('/{record}/edit'),
        ];
    }
}
