<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BudgetResource\Pages;
use App\Filament\Resources\BudgetResource\RelationManagers;
use App\Models\Budget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 6; // Budgeting
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Select::make('account_id')
                ->relationship('account', 'name')
                ->required(),
            TextInput::make('year')->numeric()->minValue(2000)->maxValue(2100)->required(),
            Select::make('month')->options([
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
            ])->required(),
            TextInput::make('amount')->numeric()->required()->prefix('Rp'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('account.name')->sortable(),
            TextColumn::make('year'),
            TextColumn::make('month'),
            TextColumn::make('amount')->money('idr'),
        ])
        ->filters([
            Tables\Filters\Filter::make('current_year')
                ->query(fn ($query) => $query->where('year', date('Y'))),
        ])
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
            'index' => Pages\ListBudgets::route('/'),
            'create' => Pages\CreateBudget::route('/create'),
            'edit' => Pages\EditBudget::route('/{record}/edit'),
        ];
    }
}
