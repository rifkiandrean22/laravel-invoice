<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Invoice App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white p-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ config('app.name', 'Invoice App') }}</h1>
            <a href="{{ route('filament.auth.login') }}" class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-200">Login</a>
        </div>
    </header>

    <main class="container mx-auto my-20 text-center">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang di {{ config('app.name', 'Invoice App') }}</h2>
        <p class="text-gray-700 text-lg mb-8">
            Kelola invoice, purchase, dan laporan bisnis Anda dengan mudah.
        </p>
		<a href="/admin" class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-200">Login</a>

        <a href="{{ route('filament.auth.login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700">Masuk Sekarang</a>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-20">
        <div class="container mx-auto text-center">
            &copy; {{ date('Y') }} {{ config('app.name', 'Invoice App') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
