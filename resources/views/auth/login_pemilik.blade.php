<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pemilik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<div class="bg-white p-8 rounded-xl shadow w-96">
    <h2 class="text-xl font-bold mb-4 text-center">Login Pemilik Kost</h2>

    <form method="POST" action="/login-pemilik">
        @csrf

        <input type="email" name="email" placeholder="Email"
            class="w-full mb-3 border p-2 rounded" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full mb-3 border p-2 rounded" required>

        <button class="w-full bg-green-600 text-white p-2 rounded">
            Masuk sebagai Pemilik
        </button>
    </form>

    <p class="text-sm text-center mt-3">
        Login sebagai pencari?
        <a href="/login" class="text-blue-600">Klik di sini</a>
    </p>
</div>

</body>
</html>