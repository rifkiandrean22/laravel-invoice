<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseOrderResource extends Resource
{

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

    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 2; // Cash & Bank
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nomor_po')
                ->label('Nomor PO')
                ->disabled()
                ->dehydrated(true)
                ->default(function () {
                    $count = \App\Models\PurchaseOrder::count() + 1;
                    return 'PO-' . now()->format('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
                }),

            Forms\Components\DatePicker::make('tanggal_po')
                ->default(now())
                ->disabled()
                ->dehydrated(true)
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'no paid' => 'No Paid',
                    'Paid' => 'Paid',
                ])
                ->default('No Paid'),

            Forms\Components\Select::make('vendor_id')
                ->label('Pilih Vendor')
                ->relationship('vendor', 'nama_vendor') // relasi ke model Vendor, tampilkan nama_vendor
                ->searchable()
                ->required(),

            Forms\Components\HasManyRepeater::make('items')
                ->relationship('items')
                ->schema([
                    Forms\Components\TextInput::make('nama_item')
                    ->required()
                    ->dehydrated(true)
                    ->disabled(),
                    Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                    Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                    Forms\Components\TextInput::make('total')
                        ->disabled()
                        ->dehydrated(true)
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $set('total', (float)$get('jumlah') * (float)$get('harga'));
                        }),
                    
                ])
                ->disabled()
                ->dehydrated(true)
                ->columns(4),
            Forms\Components\FileUpload::make('payment_proof')
                        ->label('Upload Pembayaran')
                        ->image() // jika ingin membatasi hanya gambar
                        ->directory('bukti_trf_ke_vendor') // folder simpan file di storage/app/public
                        ->maxSize(720) // maksimal 1MB
                        ->nullable()
                        ->downloadable()         // bisa download
                        ->openable(),            // bisa langsung buka (view)
            
            Forms\Components\TextInput::make('dibuat_oleh')
                ->label('Dibuat Oleh')
                ->default(fn () => auth()->user()->name)
                ->disabled()
                ->dehydrated(true)
                ->required(),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('nomor_po')
			->label('Nomor PO')
			->searchable()
			->sortable(),
            Tables\Columns\TextColumn::make('tanggal_po')
				->date()
				->label('Tanggal PO')
				->sortable(),
			Tables\Columns\TextColumn::make('nama_vendor')
			->label('Vendor')
            ->getStateUsing(fn (PurchaseOrder $record) => $record->vendor ? $record->vendor->nama_vendor : '-')
			->searchable()
			->sortable(),
                
            Tables\Columns\TextColumn::make('items_count')->counts('items')->label('Item'),
            Tables\Columns\TextColumn::make('items_sum_total')->sum('items', 'total')->money('idr')->label('Total'),
            Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'No Paid',
                        'success' => 'Paid',
                    ]),
            Tables\Columns\TextColumn::make('payment_proof')
    ->label('')
        ->formatStateUsing(fn ($state) => $state ? 'Lihat' : '-')
    ->html()
    ->url(null) // biar ga buka new tab
    
    ->action(
        Action::make('preview-payment-proof')
            ->modalContent(function ($record) {
    $file = $record->payment_proof
        ? asset('storage/' . $record->payment_proof)
        : null;

    return view('components.preview-file', [
        'file' => $file,
    ]);
})

    )
      ->state(fn ($record) => $record->payment_proof ? '👁' : '-'), // tampilkan icon mata // hanya tampil nama file
			
			])
            
            ->bulkActions([
                //
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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
    protected function afterCreate(): void
{
    // Ambil ID PO terbaru
    $po = $this->record;

    // Redirect ke Goods Receipt page
    $this->redirect(route('filament.resources.goods-receipts.create', ['purchase_order_id' => $po->id]));
}

}
