<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f4f5] min-h-screen flex items-center justify-center">

    <div class="w-[350px] bg-white rounded-xl border border-gray-200 shadow-sm px-6 py-8">

        <!-- Icon -->
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-black" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 21h18M9 8h1m4 0h1M8 21V7a2 2 0 012-2h4a2 2 0 012 2v14M5 21V11a2 2 0 012-2h1m8 0h1a2 2 0 012 2v10"/>
            </svg>
        </div>

        <!-- Judul -->
        <h2 class="text-center text-[18px] font-semibold text-black">
            Login Sebagai Admin
        </h2>

        <p class="text-center text-[13px] text-gray-500 mt-1 mb-6">
            Masukkan email dan password Anda
        </p>

        <!-- Error -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 text-xs px-3 py-2 rounded-md">
                Email atau password salah
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
    @csrf

    <div style="margin-bottom:15px;">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               placeholder="nama@email.com"
               style="width:100%;padding:10px;margin-top:5px;border:1px solid #ddd;border-radius:6px;background:#f3f4f6;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Password</label>
        <input type="password" name="password"
               placeholder="••••••••"
               style="width:100%;padding:10px;margin-top:5px;border:1px solid #ddd;border-radius:6px;background:#f3f4f6;">
    </div>

    <!-- tombol pasti tampil -->
    <input type="submit" value="Masuk"
           style="width:100%;background:black;color:white;padding:12px;border:none;border-radius:6px;font-weight:bold;cursor:pointer;">
</form>

    </div>

</body>
</html>