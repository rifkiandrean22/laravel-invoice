<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;

class OtherSettings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = 'Setting Lainnya';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.other-settings';

    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()->kategori, ['admin', 'manager']);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                TextInput::make('option_1')->label('Opsi 1'),
                TextInput::make('option_2')->label('Opsi 2'),
            ]),
        ];
    }

    public function save()
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            setting()->set($key, $value);
        }
        $this->notify('success', 'Pengaturan berhasil disimpan!');
    }
}
