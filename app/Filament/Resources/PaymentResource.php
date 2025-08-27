<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Invoice;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 5; // Payment
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('payment_number')->required()->unique(),
            DatePicker::make('payment_date')->required(),
            Select::make('method')->options([
                'cash' => 'Cash',
                'bank_transfer' => 'Bank Transfer',
                'credit_card' => 'Credit Card',
                'other' => 'Other',
            ])->required(),
            TextInput::make('amount')->numeric()->required()->prefix('Rp'),
            Select::make('status')->options([
                'pending' => 'Pending',
                'completed' => 'Completed',
                'failed' => 'Failed',
            ])->default('completed'),
            Textarea::make('notes'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('payment_number')->sortable()->searchable(),
            TextColumn::make('payment_date')->date(),
            TextColumn::make('method'),
            TextColumn::make('amount')->money('idr'),
            BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'completed',
                    'danger' => 'failed',
                ]),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('method')
                ->options([
                    'cash' => 'Cash',
                    'bank_transfer' => 'Bank Transfer',
                    'credit_card' => 'Credit Card',
                    'other' => 'Other',
                ]),
        ])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
}


    public static function getPages(): array
    {
        return ['index' => Pages\ManagePayments::route('/')];
    }
}
