<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseRequestResource\Pages;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use Filament\Tables;
use Filament\Tables\Table;      // ✅ ini yang benar
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;


class PurchaseRequestResource extends Resource
{
    public static function canViewAny(): bool
{
    return in_array(auth()->user()->kategori, ['admin', 'direktur', 'manager', 'purchasing', 'accounting', 'staff']);
}
public static function canCreate(): bool
{
    return in_array(auth()->user()->kategori, ['admin', 'staff']);
}
public static function canEdit($record): bool
{
    return in_array(auth()->user()->kategori, ['admin', 'staff']);
}

    protected static ?string $model = PurchaseRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 1; // Cash & Bank

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_purchase_request')
                    ->label('Nomor PR')
                    ->disabled()
                    ->default(fn () => 'Otomatis saat submit')
                    ->required(),
                Forms\Components\TextInput::make('nama_purchase_request')
                    ->label('Pembuat PR')
                    ->default(fn () => auth()->user()->name)
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->disabled(fn ($record) => $record && $record->status !== 'pending'), // semua field terkunci

                Forms\Components\Select::make('urgensi')
                ->options([
                    'urgent' => 'Urgent',
                    'nonurgent' => 'Non Urgent',
                ])
                ->default('nonurgent')
                ->disabled(fn ($record) => $record && $record->status !== 'pending'), // semua field terkunci // semua field terkunci
                
                Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                ])
                ->default('Pending'),
                

                Forms\Components\HasManyRepeater::make('items')
                    ->disabled(fn ($record) => $record && $record->status !== 'pending') // semua field terkunci
                    ->deletable(fn ($record) => $record && $record->status !== 'pending') // tombol delete hilang kalau approved
                    ->addable(fn ($record) => $record && $record->status !== 'pending') // tombol add juga hilang
                    ->relationship('items')
                    ->label('Items')
                    ->schema([
                        Forms\Components\TextInput::make('nama_item')
                        ->required(),
                
                        Forms\Components\TextInput::make('jumlah')
                        ->numeric()
                        ->required(),
                        
                        Forms\Components\TextInput::make('harga')
                        ->numeric()
                        ->required(),
                        
                        Forms\Components\TextInput::make('total')
                            ->disabled()
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('total', (float)$get('jumlah') * (float)$get('harga'));
                            }),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('nomor_purchase_request')
                ->label('Nomor PR')
                ->searchable()
                ->sortable(),
                Tables\Columns\BadgeColumn::make('urgensi')
                    ->colors([
                        'warning' => 'urgent',
                        'primary' => 'nonurgent',
                    ]),    
                Tables\Columns\TextColumn::make('nama_purchase_request')
                ->label('Pembuat')
                ->searchable()
                ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('reviewed_by')
                ->label('Reviewed'),
            
            ])
            ->actions([
                // Approve
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                    $record->status = 'approved';
                    $record->reviewed_by = auth()->user()->name; // pastikan user login ada
                    $record->save(); // ⚠️ penting, jangan lupa save()

                        Notification::make()
                            ->title('Purchase Request Approved')
                            ->success()
                            ->body("PR {$record->nomor_purchase_request} berhasil di-approve oleh " . auth()->user()->name)
                            ->send();
                    }),

                // Reject
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                    $record->status = 'rejected';
                    $record->reviewed_by = auth()->user()->name; // pastikan user login ada
                    $record->save(); // ⚠️ penting, jangan lupa save()
 
                        Notification::make()
                            ->title('Purchase Request Rejected')
                            ->danger()
                            ->body("PR {$record->nomor_purchase_request} ditolak oleh " . auth()->user()->name)
                            ->send();
                    }),

                // Buat PO
                Action::make('createPO')
                    ->label('Buat PO')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    // tombol hanya muncul kalau status masih "pending"
                    ->visible(fn ($record) => $record->status === 'approved')
                    ->action(function ($record) {
                    // Update status PR agar tombol hilang
                        $record->update([
                            'status' => 'completed',
                        ]);
                        if ($record->items->isEmpty()) {
                            Notification::make()
                                ->title('Gagal membuat PO')
                                ->warning()
                                ->body('PR tidak memiliki item untuk dicopy.')
                                ->send();
                            return;
                        }

                        $po = PurchaseOrder::create([
                            'purchase_request_id' => $record->id,
                            'tanggal_po' => now(),
                            'status' => 'no paid',
                            'dibuat_oleh' => auth()->user()->name,
                            'total' => $record->items->sum('total'),
                        ]);

                        foreach ($record->items as $item) {
                            $po->items()->create([
                                'nama_item' => $item->nama_item,
                                'jumlah'    => $item->jumlah,
                                'harga'     => $item->harga,
                                'total'     => $item->jumlah * $item->harga,
                            ]);
                        }

                        Notification::make()
                            ->title('Purchase Order Created')
                            ->success('Berhasil')
                            ->body("PO berhasil dibuat dari PR {$record->nomor_purchase_request}.")
                            ->send();

                        return redirect()->to(
                            \App\Filament\Resources\PurchaseOrderResource::getUrl('edit', ['record' => $po])
                        );
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseRequests::route('/'),
            'create' => Pages\CreatePurchaseRequest::route('/create'),
            'edit' => Pages\EditPurchaseRequest::route('/{record}/edit'),
        ];
    }
}
