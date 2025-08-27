<div class="flex h-screen">
    {{-- Sidebar --}}
    <aside
        x-data="{ expanded: true }"
        x-bind:class="expanded ? 'w-64' : 'w-16'"
        @mouseenter="expanded = true"
        @mouseleave="expanded = false"
        class="transition-all duration-300 bg-white border-r flex flex-col"
    >
        {{-- Loop menu items --}}
        @foreach($this->menuItems as $item)
            <div class="flex items-center gap-2 p-2 group relative">
                {{ $item->icon }}
                <span x-show="expanded" x-transition class="whitespace-nowrap">{{ $item->label }}</span>
                {{-- Tooltip --}}
                <div x-show="!expanded" class="absolute left-full ml-2 px-2 py-1 bg-gray-700 text-white text-xs rounded hidden group-hover:block">
                    {{ $item->label }}
                </div>
            </div>
        @endforeach
    </aside>

    {{-- Main content --}}
    <main class="flex-1 overflow-auto">
        {{ $slot }}
    </main>
</div>
