<?php

namespace App\Filament\Resources;
use Livewire\Component;
use App\Filament\Resources\AccountsPayableResource\Pages;
use App\Filament\Resources\AccountsPayableResource\RelationManagers;
use App\Models\AccountsPayable;
use App\Helpers\InvoiceNumberGenerator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountsPayableResource extends Resource
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
    protected static ?string $model = AccountsPayable::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 2; // Accounts Receivable
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->default(fn () => InvoiceNumberGenerator::generate())
                    ->disabled()
                    ->dehydrated()
                    ->unique()
                    ->required(),

                Forms\Components\DatePicker::make('invoice_date')
                    ->required(),

                Forms\Components\Select::make('nama_vendor')
                    ->label('Pilih Vendor')
                    ->relationship('vendor', 'nama_vendor') // relasi ke model Vendor, tampilkan nama_vendor
                    ->searchable()
                    ->required()
                    ->dehydrated(false), // jangan ikut mass-assign
                
                Forms\Components\Select::make('coa')
                    ->label('Chart of Accounts')
                    ->relationship('ChartOfAccount', 'name') // relasi ke model COA, tampilkan name
                    ->searchable()
                    ->required()
                    ->dehydrated(false), // jangan ikut mass-assign
                

                Forms\Components\TextInput::make('name')
                    ->label('Nama Penerima')
                    ->maxLength(50),
                
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Unpaid' => 'Unpaid',
                        'Paid' => 'Paid',
                        'Partial' => 'Partial',
                    ])
                    ->required()
                    ->default('Unpaid'),
                Forms\Components\Textarea::make('payment_note')
                    ->label('Keterangan')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Utilities' => 'Utilities',
                        'Maintenance' => 'Maintenance',
                        'Payroll' => 'Payroll',
                        'Operational' => 'Operational',
                        'Other Expenses' => 'Other Expenses',
                    ])
                    ->required()
                    ->default('Unpaid'),
                
                Forms\Components\TextInput::make('total')
                    ->maxLength(255),

                Forms\Components\FileUpload::make('payment_proof')
                    ->label('Payment Proof')
                    ->image()
                    ->directory('bukti_trf_ke_vendor') // folder di storage/app/public
                    ->disk('public') // pastikan disk nya public
                    ->preserveFilenames() // opsional, biar nama asli dipakai
                    ->maxSize(2048), // maksimal 2 MB
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('invoice_date')
                    ->date()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vendor.nama_vendor')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('ChartOfAccount.name')
                    ->label('COA')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->colors([
                        'success' => 'Paid',
                        'danger' => 'Unpaid',
                    ]),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            
                Tables\Columns\TextColumn::make('total')
                    ->searchable(),
                
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
            'index' => Pages\ListAccountsPayables::route('/'),
            'create' => Pages\CreateAccountsPayable::route('/create'),
            'edit' => Pages\EditAccountsPayable::route('/{record}/edit'),
        ];
    }
}
