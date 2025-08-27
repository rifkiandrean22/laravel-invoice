<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoodsReceiptResource\Pages;
use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class GoodsReceiptResource extends Resource
{
    protected static ?string $model = GoodsReceipt::class;

    protected static ?string $navigationLabel = 'Goods Receipts';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 3; // Cash & Bank
            public static function canViewAny(): bool
        {
            return in_array(auth()->user()->kategori, ['admin', 'direktur', 'manager', 'purchasing', 'accounting', 'staff']);
        }
        public static function canCreate(): bool
        {
            return auth()->user()->kategori === 'admin';
        }
        public static function canEdit($record): bool
        {
            return auth()->user()->kategori === 'admin';
        }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('purchase_order_id')
                    ->label('Purchase Order')
                    ->relationship('purchaseOrder', 'nomor_po')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('vendor_id')
                    ->label('Vendor')
                    ->relationship('vendor', 'nama_vendor')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('gr_number')
                    ->label('GR Number')
                    ->disabled(), // auto-generate

                Forms\Components\DatePicker::make('received_date')
                    ->label('Received Date')
                    ->required(),

                Forms\Components\Select::make('item_id')
                ->label('Item')
                ->options(Item::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

                Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required(),

                Forms\Components\Select::make('warehouse_id')
                ->label('Warehouse')
                ->relationship('warehouse', 'name')
                ->searchable()
                ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gr_number')->label('GR Number')->sortable(),
                Tables\Columns\TextColumn::make('purchaseOrder.nomor_po')->label('PO Number')->sortable(),
                Tables\Columns\TextColumn::make('vendor.nama_vendor')->label('Vendor')->sortable(),
                Tables\Columns\TextColumn::make('received_date')->date()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGoodsReceipts::route('/'),
            'create' => Pages\CreateGoodsReceipt::route('/create'),
            'edit' => Pages\EditGoodsReceipt::route('/{record}/edit'),
        ];
    }
}
