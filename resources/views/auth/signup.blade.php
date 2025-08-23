<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - SEAL App</title>
</head>
<body>
    <h2>Daftar Akun</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('signup.submit') }}">
        @csrf
        <div>
            <label>Nama Lengkap:</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label>Kata Sandi:</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Ulangi Kata Sandi:</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit">Daftarkan</button>
    </form>
</body>
</html>
