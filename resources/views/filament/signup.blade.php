<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - SEAL App</title>
		@vite('resources/css/app.css')
		@vite('resources/js/app.js') <!-- kalau pakai Tailwind -->
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl mb-4">Daftar Akun Baru - SEAL App</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('filament.signup.submit') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded" placeholder="Huruf Kapital">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border px-3 py-2 rounded" placeholder="contoh@contoh.com">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Kata Sandi</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded" placeholder="Harus 8 Karakter">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Ulangi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" placeholder="Harus 8 Karakter">
            </div>
            <div class="mb-4">
                <select name="kategori" required>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="accounting">Accounting</option>
                <option value="purchasing">Purchasing</option>
                <option value="staff">Staff</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftarkan</button>
        </form>
    </div>
</body>
</html>
