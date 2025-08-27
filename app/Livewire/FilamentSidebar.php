<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FilamentSidebar extends Component
{
    public $menuItems;

    public function mount()
    {
        $this->menuItems = [
            [
                'label' => 'Dashboard',
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h10"/></svg>',
                'route' => '#', // sementara route dummy
                'description' => 'Ringkasan dashboard ERP',
            ],
            [
                'label' => 'Purchase Requests',
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0h1m-1 0v6m-8 0H4"/></svg>',
                'route' => '#',
                'description' => 'Daftar permintaan pembelian',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.filament-sidebar');
    }
}
