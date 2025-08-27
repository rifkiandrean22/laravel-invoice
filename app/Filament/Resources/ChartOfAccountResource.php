<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChartOfAccountResource\Pages;
use App\Models\ChartOfAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ChartOfAccountResource extends Resource
{
    protected static ?string $model = ChartOfAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Chart of Accounts';
    protected static ?int $navigationSort = 8; // Chart
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')->required()->unique(ignoreRecord: true),
                TextInput::make('name')->required(),
                Select::make('type')
                    ->options([
                        'asset' => 'Asset',
                        'liability' => 'Liability',
                        'equity' => 'Equity',
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                BadgeColumn::make('type')->colors([
                    'success' => 'asset',
                    'danger' => 'liability',
                    'info' => 'equity',
                    'warning' => 'income',
                    'primary' => 'expense',
                ]),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChartOfAccounts::route('/'),
            'create' => Pages\CreateChartOfAccount::route('/create'),
            'edit' => Pages\EditChartOfAccount::route('/{record}/edit'),
        ];
    }
}
