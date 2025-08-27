<div class="w-full h-[80vh] flex justify-center items-center">
    @if ($file)
        @if(Str::endsWith(strtolower($file), ['.jpg','.jpeg','.png','.gif']))
            <img src="{{ $file }}" class="max-h-full max-w-full rounded-lg shadow-lg">
        @elseif(Str::endsWith(strtolower($file), ['.pdf']))
            <iframe src="{{ $file }}" class="w-full h-full border rounded-lg"></iframe>
        @else
            <p class="text-gray-500">File tidak bisa dipreview</p>
        @endif
    @else
        <p class="text-gray-500">Tidak ada file</p>
    @endif
</div>