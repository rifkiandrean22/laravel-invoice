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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;




class InvoiceResource extends Resource
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
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 1; // Cash & Bank
    
    public static function form(Form $form): Form
{
    return $form
        ->schema([
    Forms\Components\TextInput::make('invoice_number')
    ->label('Faktur')
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
        ->label('Tanggal')
        ->required(),
    
    TextInput::make('name')
        ->label('Pelanggan')
        ->required(),

		Repeater::make('invoice_items')
			->label('Item Invoice')
			->relationship('items')
			->schema([
						TextInput::make('description')->label('Nama Item'),
						TextInput::make('quantity')->label('Jumlah')->numeric()->required(),
						TextInput::make('price')->label('Harga')->numeric()->required(),
						TextInput::make('total')
            ->label('Total')
            ->numeric()
            ->disabled()
            ->dehydrated()// pastikan disimpan
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, $get) {
                $set('total', $get('quantity') * $get('price'));
            }),
    ])
				->columnSpan('full'),

            TextInput::make('customer_name')
                ->label('Dibuat Oleh')
                ->default(fn () => auth()->user()->name) // otomatis terisi nama login
                ->disabled() // opsional, kalau tidak mau user ubah
                ->required(),

            Select::make('status')
                ->options([
                    'unpaid' => 'Unpaid',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ])
                ->default('unpaid')
                ->required(),

            Forms\Components\TextInput::make('payment_note')
                ->label('Keterangan Pembayaran')
                ->placeholder('Misal: Transfer Bank BCA'),				
			Forms\Components\Select::make('category')
				->label('Kategori')
				->options([
							'Rental' => 'Rental',
							'Sparepart' => 'Sparepart',
							'Maintenance' => 'Maintenance',
							'Lainnya' => 'Lainnya',
    ])
    ->required(),
	
	Forms\Components\FileUpload::make('payment_proof')
    ->label('Pembayaran')
    ->image() // jika ingin membatasi hanya gambar
    ->directory('payment-proofs') // folder simpan file di storage/app/public
    ->maxSize(720) // maksimal 1MB
    ->nullable()
	->columns(2),        
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('invoice_number')
                ->label('No Invoice')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false),

            TextColumn::make('invoice_date')
                ->label('Tanggal')
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

			Tables\Columns\TextColumn::make('payment_note')
            ->label('Pembayaran')
            ->limit(50),
            
            IconColumn::make('payment_proof')
                ->label('Bukti')
                ->boolean() // true/false sesuai ada/tidak
                ->trueIcon('heroicon-o-check') // icon ketika ada bukti
                ->falseIcon('heroicon-o-x')   // icon ketika kosong
                ->colors([
                    'success' => true,  // warna hijau kalau ada
                    'danger' => false,  // warna merah kalau kosong
                ])
                ->tooltip(fn ($state) => $state ? 'Bukti tersedia' : 'Belum ada bukti'),

			
            BadgeColumn::make('status')
                ->label('Status')
                ->sortable()
                ->colors([
                    'danger' => 'unpaid',
                    'success' => 'paid',
                    'secondary' => 'cancelled',
                ]),
			
			Tables\Columns\TextColumn::make('total')
                ->label('Total')
                ->money('IDR', true) // otomatis format ke Rupiah
                ->sortable(),
				
        ])
        ->actions([
         
            Tables\Actions\Action::make('download')
                ->url(fn ($record)=> route('invoice.download', $record->id))
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
