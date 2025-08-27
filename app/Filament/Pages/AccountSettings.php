<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;

class AccountSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationLabel = 'Setting Akun';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.account-settings';

    // **Form state harus ada sebagai property**
    public array $formData = [];
        public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()->kategori, ['admin', 'manager']);
    }

    public function mount(): void
    {
        // isi form state
        $this->formData = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'password' => null,
        ];

        $this->form->fill($this->formData);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                TextInput::make('formData.name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('formData.email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('formData.password')
                    ->label('Password Baru')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
                    ->required(false),
            ]),
        ];
    }

    public function save()
    {
        $data = $this->form->getState();

        $user = auth()->user();
        $user->name = $data['formData']['name'];
        $user->email = $data['formData']['email'];

        if (!empty($data['formData']['password'])) {
            $user->password = $data['formData']['password'];
        }

        $user->save();

        $this->notify('success', 'Setting akun berhasil disimpan!');
    }
}
