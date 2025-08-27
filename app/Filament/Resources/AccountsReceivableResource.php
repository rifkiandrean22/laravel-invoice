<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountsReceivableResource\Pages;
use App\Filament\Resources\AccountsReceivableResource\RelationManagers;
use App\Models\AccountsReceivable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountsReceivableResource extends Resource
{   

        public static function canViewAny(): bool
    {
        return in_array(auth()->user()->kategori, ['admin', 'direktur', 'manager']);
    }
    public static function canCreate(): bool
    {
        return auth()->user()->kategori === 'admin';
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->kategori === 'admin';
    }
    protected static ?string $model = AccountsReceivable::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 2; // Accounts Receivable
    
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('invoice_number')->required()->unique(),
            DatePicker::make('invoice_date')->required(),
            DatePicker::make('due_date'),
            TextInput::make('customer_name')->required(),
            TextInput::make('amount')->numeric()->required()->prefix('Rp'),
            Select::make('status')
                ->options([
                    'unpaid' => 'Unpaid',
                    'partial' => 'Partial',
                    'paid' => 'Paid',
                ])->default('unpaid'),
            Textarea::make('notes'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('invoice_number')->sortable()->searchable(),
            TextColumn::make('customer_name')->sortable()->searchable(),
            TextColumn::make('invoice_date')->date(),
            TextColumn::make('due_date')->date(),
            TextColumn::make('amount')->money('idr'),
            BadgeColumn::make('status')->colors([
                'danger' => 'unpaid',
                'warning' => 'partial',
                'success' => 'paid',
            ]),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')->options([
                'unpaid' => 'Unpaid',
                'partial' => 'Partial',
                'paid' => 'Paid',
            ]),
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
            'index' => Pages\ListAccountsReceivables::route('/'),
            'create' => Pages\CreateAccountsReceivable::route('/create'),
            'edit' => Pages\EditAccountsReceivable::route('/{record}/edit'),
        ];
    }
}
