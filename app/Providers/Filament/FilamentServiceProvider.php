<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Livewire\FilamentSidebar;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerRenderHook(
                'body.start',
                fn () => FilamentSidebar::render()
            );
        });
    }
}
