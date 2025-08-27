<div x-data="{ expanded: true }" class="flex h-screen">
    <aside
        x-bind:class="expanded ? 'w-64' : 'w-16'"
        @mouseenter="expanded = true"
        @mouseleave="expanded = false"
        class="transition-all duration-300 bg-white border-r flex flex-col"
    >
        <nav class="flex-1 overflow-y-auto">
            @foreach($menuItems as $item)
                <a href="{{ $item['route'] }}" class="flex items-center gap-2 p-2 group relative hover:bg-gray-100 rounded">
                    {!! $item['icon'] !!}
                    <div class="flex flex-col">
                        <span x-show="expanded" x-transition class="whitespace-nowrap">{{ $item['label'] }}</span>
                        <span x-show="expanded" x-transition class="text-xs text-gray-400">{{ $item['description'] }}</span>
                    </div>
                    <div x-show="!expanded" class="absolute left-full ml-2 px-2 py-1 bg-gray-700 text-white text-xs rounded hidden group-hover:block">
                        {{ $item['label'] }}
                    </div>
                </a>
            @endforeach
        </nav>
    </aside>
    <main class="flex-1 overflow-auto">{{ $slot }}</main>
</div>
