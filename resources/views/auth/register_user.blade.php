<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register KostKu</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Animasi fade */
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="h-screen">

<div class="grid grid-cols-1 md:grid-cols-2 h-full fade-in">

    <!-- KIRI: FORM -->
    <div class="flex items-center justify-center bg-white px-10">

        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold mb-2">Daftar Akun</h2>
            <p class="text-gray-500 mb-6">
                Buat akun untuk mencari kost impian Anda
            </p>

            <!-- ERROR -->
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-black"
                        placeholder="Nama Anda" required>
                </div>

                <!-- Nomor WA -->
                <div class="mb-4">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="no_wa"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-black"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label>Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-black"
                        placeholder="nama@email.com" required>
                </div>

                <!-- Password + Show -->
                <div class="mb-4 relative">
                    <label>Password</label>

                    <input type="password" id="password" name="password"
                        class="w-full border rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-black"
                        placeholder="Minimal 6 karakter" required>

                    <!-- ICON SHOW -->
                    <span onclick="togglePassword()"
                        class="absolute right-3 top-9 cursor-pointer text-gray-500">
                        👁️
                    </span>
                </div>

                <button class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">
                    Daftar
                </button>

                <p class="text-sm text-center mt-4">
                    Sudah punya akun?
                    <a href="/login" class="text-blue-600">Masuk</a>
                </p>

            </form>
        </div>

    </div>


    <!-- KANAN: GAMBAR + OVERLAY -->
    <div class="hidden md:block relative">

        <!-- GAMBAR -->
        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
             class="w-full h-full object-cover">

        <!-- OVERLAY GELAP -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- TEXT OPSIONAL (BIAR MIRIP APP REAL) -->
        <div class="absolute bottom-10 left-10 text-white">
            <h2 class="text-2xl font-bold">Temukan Kost Impianmu</h2>
            <p class="text-sm text-gray-200">
                Ribuan pilihan kost terbaik menunggumu
            </p>
        </div>

    </div>

</div>

<!-- SCRIPT SHOW PASSWORD -->
<script>
function togglePassword() {
    const password = document.getElementById("password");

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>

</body>
</html>