<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login KostKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen">

<div class="grid grid-cols-1 md:grid-cols-2 h-full">

    <!-- KIRI: FORM -->
    <div class="flex items-center justify-center bg-white px-10">

        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold mb-2">Masuk ke KostKu</h2>
            <p class="text-gray-500 mb-6">
                Masukkan email dan password Anda
            </p>

            <!-- NOTIF -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- ROLE SELECT -->
                <div class="mb-5">

                    <div class="flex bg-gray-200 rounded-lg p-1">

                        <button type="button"
                            id="btnCustomer"
                            onclick="setRole('costumer')"
                            class="role-btn flex-1 py-2 rounded-lg text-sm font-medium bg-black text-white">
                            Customer
                        </button>

                        <button type="button"
                            id="btnPemilik"
                            onclick="setRole('pemilik')"
                            class="role-btn flex-1 py-2 rounded-lg text-sm font-medium text-gray-600">
                            Pemilik Kost
                        </button>

                    </div>

                    <!-- VALUE KE BACKEND -->
                    <input type="hidden" name="role" id="roleInput" value="costumer">

                </div>

                <div id="waField" class="mb-4 hidden">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="no_wa"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="08xxxxxxxxxx">
                </div>

                <div class="mb-4">
                    <label>Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="nama@email.com">
                </div>

                <div class="mb-4">
                    <label>Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="********">
                </div>

                <button class="w-full bg-black text-white py-2 rounded-lg">
                    Masuk
                </button>

                <p class="text-sm text-center mt-4">
                    Belum punya akun? 
                    <a id="registerLink" href="/register" class="text-blue-600">
                        Daftar sebagai Customer
                    </a>
                </p>
            </form>
        </div>

    </div>


    <!-- KANAN: GAMBAR -->
    <div class="hidden md:block">
        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
             class="w-full h-full object-cover">
    </div>

</div>

</body>
<script>
function setRole(role){

    document.getElementById('roleInput').value = role;

    let customer = document.getElementById('btnCustomer');
    let pemilik = document.getElementById('btnPemilik');
    let waField = document.getElementById('waField');
    let registerLink = document.getElementById('registerLink');

    if(role === 'costumer'){
        customer.classList.add('bg-black','text-white');
        customer.classList.remove('text-gray-600');

        pemilik.classList.remove('bg-black','text-white');
        pemilik.classList.add('text-gray-600');

        // SEMBUNYIKAN WA
        waField.classList.add('hidden');

    }else{
        pemilik.classList.add('bg-black','text-white');
        pemilik.classList.remove('text-gray-600');

        customer.classList.remove('bg-black','text-white');
        customer.classList.add('text-gray-600');

        // TAMPILKAN WA 🔥
        waField.classList.remove('hidden');
    }

    if(role === 'costumer'){
    registerLink.href = '/register';
    registerLink.innerText = 'Daftar sebagai Customer';
    }
    
    else{
    registerLink.href = '/register-pemilik';
    registerLink.innerText = 'Daftar sebagai Pemilik Kost';
}
}
</script>
</html>