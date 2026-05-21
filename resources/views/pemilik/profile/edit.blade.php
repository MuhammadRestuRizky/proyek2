<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#ececec] min-h-screen">

    <!-- HEADER -->
<div class="bg-black text-white px-6 py-3 flex items-center justify-between">

    <!-- Logo kiri -->
    <div class="flex items-center gap-2">
        <span class="text-xl">🏢</span>
        <span class="font-bold text-lg">KostKu</span>
    </div>

    <!-- Judul tengah -->
    <div class="absolute left-1/2 transform -translate-x-1/2 text-3xl font-bold">
        Profil Saya
    </div>

    <!-- Profile kanan -->
    <div class="flex items-center gap-1">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-black text-sm">
            👤
        </div>
        <span class="text-xs">⌄</span>
    </div>
</div>

<!-- BAR ABU + BACK -->
<div class="bg-[#b5b5b5] px-6 py-2">
    <a href="{{ url()->previous() }}"
       class="text-white text-lg font-medium hover:underline">
        ← Kembali
    </a>
</div>

    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KIRI -->
        <div class="space-y-6">

            <!-- FOTO -->
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="w-28 h-28 mx-auto bg-gray-200 rounded-lg flex items-center justify-center text-5xl">
                    👤
                </div>

                <label class="block mt-3 cursor-pointer font-semibold text-sm">
                    Tambahkan Foto
                    <input type="file" hidden>
                </label>
            </div>

            <!-- PROFILE -->
            <form action="{{ route('pemilik.profile.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-bold text-xl mb-4">Profil Utama</h3>

                    <div class="space-y-4">

                        <!-- Nama -->
                        <div class="border rounded-lg p-3 relative">
                            <label class="font-bold block">Nama :</label>
                            <input type="text"
                                   name="name"
                                   value="{{ auth()->user()->name }}"
                                   readonly
                                   class="editable-input w-full bg-transparent outline-none">
                        </div>

                        <!-- Email -->
                        <div class="border rounded-lg p-3">
                            <label class="font-bold block">Email :</label>
                            <input type="text"
                                   value="{{ auth()->user()->email }}"
                                   readonly
                                   class="w-full bg-transparent outline-none">
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="border rounded-lg p-3">
                            <label class="font-bold block">Nomor Telepon :</label>
                            <input type="text"
                                   name="no_wa"
                                   value="{{ auth()->user()->no_wa }}"
                                   readonly
                                   class="editable-input w-full bg-transparent outline-none">
                        </div>

                        <!-- Password -->
                        <div class="border rounded-lg p-3">
                            <label class="font-bold block">Password :</label>
                            <input type="password"
                                   value="***************"
                                   readonly
                                   class="w-full bg-transparent outline-none">
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- KANAN -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-2xl mb-6">Metode Pembayaran E-Wallet</h3>

            <div class="space-y-4">

                @foreach($paymentMethods as $method)
                <div class="bg-gray-100 rounded-xl p-4 flex justify-between items-center">

                    <div>
                        <div class="font-bold text-lg">
                            {{ $method->method_name }}
                        </div>

                        <div class="text-sm">
                            Nomor : {{ $method->account_number }}
                        </div>
                    </div>

                    <div class="flex items-center gap-3">

                        <span class="px-4 py-1 rounded-lg font-bold
                            {{ $method->is_active ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                            {{ $method->is_active ? 'Aktif' : 'Disable' }}
                        </span>

                        <form action="{{ route('payment-method.destroy', $method->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Yakin hapus metode pembayaran ini?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- FORM TAMBAH -->
            <form action="{{ route('payment-method.store') }}" method="POST" class="mt-6">
                @csrf

                <div class="border rounded-lg p-4 bg-gray-50">

                    <input type="text"
                           name="method_name"
                           placeholder="Nama metode (Dana/Gopay/BCA)"
                           class="w-full border p-2 rounded mb-3">

                    <input type="text"
                           name="account_number"
                           placeholder="Nomor akun"
                           class="w-full border p-2 rounded mb-3">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" checked>
                        Aktif
                    </label>
                </div>

                <button type="submit"
                        class="w-full mt-4 bg-gray-200 py-4 rounded-xl font-bold hover:bg-gray-300">
                    Tambahkan Metode Pembayaran
                </button>
            </form>
        </div>
    </div>

    <!-- BUTTON -->
    <div class="flex justify-end gap-4 px-6 pb-6">

        <button type="submit"
                form="profileForm"
                class="bg-[#02022d] text-white px-8 py-3 rounded-lg font-bold">
            Terapkan
        </button>

        <button type="button"
                onclick="enableEdit()"
                class="bg-red-600 text-white px-8 py-3 rounded-lg font-bold">
            Edit
        </button>
    </div>

    <!-- LOGOUT -->
    <div class="px-6 pb-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>

<script>
function enableEdit() {
    let inputs = document.querySelectorAll('.editable-input');

    inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.classList.add('border', 'p-1', 'rounded');
    });
}
</script>

</body>
</html>