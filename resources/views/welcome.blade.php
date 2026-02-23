<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mykost'In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- NAVBAR -->
<nav class="bg-blue-600 text-white px-10 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Mykost'In</h1>

    <!-- PROFIL -->
    <div class="relative">
        @auth
            <button id="profileBtn" class="flex items-center gap-2 focus:outline-none">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" 
                    class="w-9 h-9 rounded-full border"
                >
                <span>{{ auth()->user()->name }}</span>
            </button>

            <!-- Dropdown -->
            <div id="profileMenu" class="hidden absolute right-0 mt-3 bg-white text-gray-700 rounded-xl shadow-lg w-40">
                <a href="/dashboard" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        @else
            <a href="/admin/login" class="flex items-center gap-2 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M5.121 17.804A9 9 0 1112 21v-2m0 0a5 5 0 100-10 5 5 0 000 10z"/>
                </svg>
                Login
            </a>
        @endauth
    </div>
</nav>

<!-- HERO SEARCH -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20 text-center">
    <h2 class="text-4xl font-bold mb-3">
        Cari Kost & Kontrakan Yang Anda Inginkan
    </h2>
    <p class="text-white/80 mb-10">
        Temukan Kamar Kost & Kontrakan Di Daerah yang Anda Inginkan Dengan Kualitas Terbaik dan Harga Yang Terjangjau

    <div class="bg-white rounded-2xl shadow-2xl max-w-5xl mx-auto p-6 text-gray-700">
        <form action="/kost" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <input type="text" name="q"
                placeholder="Lokasi atau nama kost..."
                class="border rounded-lg px-4 py-3">

            <select name="harga" class="border rounded-lg px-4 py-3">
                <option value="">Semua Harga</option>
                <option value="0-500000">< 500rb</option>
                <option value="500000-1000000">500rb - 1jt</option>
                <option value="1000000-2000000">1jt - 2jt</option>
                <option value="2000000+">> 2jt</option>
            </select>

            <select name="gender" class="border rounded-lg px-4 py-3">
                <option value="">Semua Tipe</option>
                <option value="putra">Putra</option>
                <option value="putri">Putri</option>
                <option value="campur">Campur</option>
            </select>

            <select name="ac" class="border rounded-lg px-4 py-3">
                <option value="">AC / Non AC</option>
                <option value="1">AC</option>
                <option value="0">Non AC</option>
            </select>

            <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                🔍 Cari
            </button>
        </form>
    </div>
</div>

<!-- CONTAINER HASIL -->
<div class="max-w-6xl mx-auto p-8">
    <h3 class="text-xl font-semibold mb-6">Properti Terbaru</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($kosts ?? [] as $kost)
        <div class="bg-white rounded-xl shadow hover:shadow-xl transition">
            <img src="{{ $kost->foto ?? 'https://source.unsplash.com/400x300/?house' }}" 
                 class="rounded-t-xl h-48 w-full object-cover">
            <div class="p-4">
                <h4 class="font-semibold">{{ $kost->nama }}</h4>
                <p class="text-sm text-gray-500">{{ $kost->alamat }}</p>
                <p class="font-bold text-blue-600 mt-2">
                    Rp {{ number_format($kost->harga) }}
                </p>
                <p class="text-xs mt-1">
                    {{ ucfirst($kost->gender) }} • {{ $kost->ac ? 'AC' : 'Non AC' }}
                </p>
            </div>
        </div>
        @empty
        <p class="col-span-3 text-center text-gray-500">
            Belum ada data kost.
        </p>
        @endforelse
    </div>
</div>

<!-- JS dropdown -->
<script>
document.getElementById('profileBtn')?.addEventListener('click', function () {
    document.getElementById('profileMenu').classList.toggle('hidden');
});
</script>

</body>
</html>
