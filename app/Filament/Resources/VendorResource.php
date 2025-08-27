<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use App\Filament\Resources\VendorResource\Pages;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class VendorResource extends Resource
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
    protected static ?string $model = Vendor::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 8; //  Vendor
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_vendor')->required(),
                Forms\Components\TextInput::make('alamat')->required(),
                Forms\Components\TextInput::make('kontak')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_vendor')->label('Nama Vendor'),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat'),
                Tables\Columns\TextColumn::make('kontak')->label('Kontak'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListVendors::route('/'),
        'create' => Pages\CreateVendor::route('/create'),
        'edit' => Pages\EditVendor::route('/{record}/edit'),
    ];
}
}

    