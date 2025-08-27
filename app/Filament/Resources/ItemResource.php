<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Purchase';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')->required()->unique(),
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('category'),
            Forms\Components\TextInput::make('unit')->default('pcs'),
            Forms\Components\TextInput::make('stock')->numeric()->default(0),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('category'),
            Tables\Columns\TextColumn::make('unit'),
            Tables\Columns\TextColumn::make('stock')->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
