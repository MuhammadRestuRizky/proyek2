<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Pemilik Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">

    <!-- ICON -->
    <div class="flex justify-center mb-4">
        <div class="bg-gray-100 p-3 rounded-xl">
            📋
        </div>
    </div>

    <!-- TITLE -->
    <h2 class="text-2xl font-semibold text-center">
        Daftar Sebagai Pemilik Properti
    </h2>

    <p class="text-center text-gray-500 text-sm mb-6">
        Sudah punya akun?
        <a href="/login-pemilik" class="text-blue-600 hover:underline">
            Masuk di sini
        </a>
    </p>

    <!-- ERROR -->
    @if($errors->any())
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register-pemilik" enctype="multipart/form-data">
        @csrf

        <!-- NAMA -->
        <div class="mb-4">
            <label class="text-sm">Nama Lengkap</label>
            <input type="text" name="name"
                placeholder="Nama Anda"
                class="w-full mt-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none"
                required>
        </div>

        <!-- ROLE -->
        <div class="mb-4">
            <label class="text-sm">Anda Sebagai</label>
            <div class="mt-1">
                <label class="flex items-center gap-2">
                    <input type="radio" name="role" value="pemilik" checked>
                    Pemilik Properti
                </label>
            </div>
        </div>

        <!-- EMAIL -->
        <div class="mb-4">
            <label class="text-sm">Email</label>
            <input type="email" name="email"
                placeholder="nama@email.com"
                class="w-full mt-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none"
                required>
        </div>

        <!-- NO WA -->
        <div class="mb-4">
            <label class="text-sm">Nomor Whatsapp</label>
            <input type="text" name="no_wa"
                placeholder="08123456789"
                class="w-full mt-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none"
                required>
        </div>

        <!-- PASSWORD -->
        <div class="mb-4">
            <label class="text-sm">Password</label>
            <input type="password" name="password"
                placeholder="Minimal 6 karakter"
                class="w-full mt-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none"
                required>
        </div>

        <!-- KONFIRM PASSWORD -->
        <div class="mb-4">
            <label class="text-sm">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                placeholder="Ulangi password"
                class="w-full mt-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none"
                required>
        </div>

        <!-- UPLOAD KTP -->
        <div class="mb-4">
            <label class="text-sm">Upload Foto Selfie KTP</label>
            <input type="file" name="ktp"
                class="w-full mt-1 px-3 py-2 bg-gray-100 rounded-lg text-sm"
                required>
        </div>

        <!-- UPLOAD BERKAS -->
        <div class="mb-6">
            <label class="text-sm">
                Upload Berkas Kepemilikan Properti Kost/Kontrakan
            </label>
            <input type="file" name="dokumen"
                class="w-full mt-1 px-3 py-2 bg-gray-100 rounded-lg text-sm"
                required>
        </div>

        <!-- BUTTON -->
        <button class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">
            Daftar
        </button>

    </form>

</div>

</body>
</html>