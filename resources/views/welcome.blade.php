<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-black text-white px-6 py-3 flex items-center justify-between">
    <!-- LOGO -->
    <div class="flex items-center gap-3">
        <h1 class="text-lg font-bold">KostKu</h1>

        @guest
            <span class="bg-gray-700 text-xs px-2 py-1 rounded">
                Admin
            </span>
        @endguest
    </div>

    <!-- MENU TENGAH -->
    @auth
    <div class="flex items-center gap-2 text-sm">

        <a href="/riwayat"
            class="px-3 py-1 rounded-md {{ request()->is('riwayat') ? 'bg-gray-700' : 'hover:bg-gray-800' }}">
            📋 Riwayat
        </a>

        <a href="/kost"
            class="px-3 py-1 rounded-md {{ request()->is('kost') ? 'bg-gray-700' : 'hover:bg-gray-800' }}">
            🔍 Pencarian
        </a>

        <a href="/"
            class="px-3 py-1 rounded-md {{ request()->is('/') ? 'bg-gray-700' : 'hover:bg-gray-800' }}">
            🏠 Beranda
        </a>

    </div>
    @endauth

    <!-- KANAN -->
    <div class="flex items-center gap-3">

        @auth
            <!-- 🔥 UNIVERSAL PROFILE LINK -->
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:opacity-80 transition">

                <span class="text-sm">
                    {{ auth()->user()->name }}
                </span>

                <img 
                    src="{{ auth()->user()->photo 
                        ? asset('storage/' . auth()->user()->photo) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    class="w-8 h-8 rounded-full border border-white">
            </a>

        @else
            <!-- SEBELUM LOGIN -->
            <a href="/login"
                class="bg-green-500 hover:bg-green-600 px-4 py-1 rounded text-sm">
                Masuk
            </a>

            <a href="/register"
                class="bg-red-500 hover:bg-red-600 px-4 py-1 rounded text-sm">
                Daftar
            </a>
        @endauth
    </div>
</nav>
   
<!-- HERO -->
<section class="bg-gradient-to-r from-gray-800 to-gray-600 text-white pt-20 pb-3 text-center max-h-[290px] overflow-hidden">
    <h2 class="text-4xl font-bold mb-1">
        Temukan Kost & Kontrakan Impianmu
    </h2>
    <p class="text-gray-300 mb-2">
        Ribuan pilihan kost dan kontrakan terbaik dengan harga terjangkau
    </p>

    <!-- SEARCH -->
    <div class="bg-white rounded-xl shadow-lg max-w-6xl mx-auto p-1 text-gray-700">
        <form action="/kost" method="GET" class="grid md:grid-cols-12 gap-2">
            <input type="text" name="q"
                placeholder="Cari lokasi atau nama..."
                class="border rounded-lg px-3 h-12 w-full md:col-span-7">

            <select name="tipe" class="border rounded-lg px-3 h-12 w-full md:col-span-2">
                <option value="" dissable selected hidden>Tipe</option>
                <option value="kost">Kost</option>
                <option value="kontrakan">Kontrakan</option>
            </select>

            <select name="harga" class="border rounded-lg px-3 h-11 w-full md:col-span-2">
                <option value="" disabled selected hidden>Harga</option>
                <option value="murah">Murah</option>
                <option value="sedang">Sedang</option>
                <option value="mahal">Mahal</option>
            </select>

            <button class="bg-black text-white rounded-lg h-12 w-full md:col-span-1">
                Cari
            </button>
        </form>
    </div>
</section>

<!-- FITUR -->
<section class="max-w-6xl mx-auto grid md:grid-cols-4 gap-4 mt-1 px-5">
    <div class="bg-white p-4 rounded-xl shadow text-center">
        <h4 class="font-semibold">Pilihan Lengkap</h4>
        <p class="text-sm text-gray-500">Ribuan kost tersedia</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow text-center">
        <h4 class="font-semibold">Lokasi Strategis</h4>
        <p class="text-sm text-gray-500">Dekat kampus & kota</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow text-center">
        <h4 class="font-semibold">Terpercaya</h4>
        <p class="text-sm text-gray-500">Pemilik terverifikasi</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow text-center">
        <h4 class="font-semibold">Cepat & Mudah</h4>
        <p class="text-sm text-gray-500">Proses instan</p>
    </div>
</section>

<!-- LIST KOST -->
<section class="px-10 py-2">

    <h3 class="text-xl font-semibold mb-6">Pilihan Terpopuler</h3>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    @forelse ($kosts as $kost)

        @php
            $fotos = $kost->fotos ?? collect();
            $mainFoto = $fotos->where('is_primary', 1)->first()
                        ?? $fotos->first();
        @endphp

        <!-- CARD -->

        <a href="{{ route('kost.detail', $kost->id) }}" 
        class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl hover:scale-[1.02] transition">

            <!-- IMAGE -->
            <div class="relative">
                @if($mainFoto)
                    <img src="{{ asset('storage/' . $mainFoto->foto) }}"
                        class="w-full h-36 object-cover">
                @else
                    <div class="w-full h-36 bg-gray-300 flex items-center justify-center">
                        Tidak ada foto
                    </div>
                @endif
            </div>

            <!-- THUMB -->
            <div class="flex gap-2 p-3 overflow-x-auto">
                @foreach($fotos->take(4) as $i => $foto)
                    <img src="{{ asset('storage/' . $foto->foto) }}"
                        onclick="openGallery({{ $kost->id }}, {{ $i }})"
                        class="w-12 h-8 object-cover rounded-lg cursor-pointer hover:opacity-80">
                @endforeach
            </div>

            <!-- CONTENT -->
            <div class="px-3 pb-3">

                <!-- BADGE -->
                <div class="flex gap-2 mb-2 text-xs">
                    <span class="bg-black text-white px-2 py-1 rounded-full">Kost</span>
                    <span class="bg-gray-200 px-2 py-1 rounded-full">
                        {{ ucfirst($kost->gender ?? 'Putra') }}
                    </span>
                </div>

                <!-- TITLE -->
                <h3 class="text-lg font-semibold leading-tight">
                    {{ Str::limit($kost->nama_kost, 25) }}
                </h3>

                <!-- ADDRESS -->
                <p class="text-sm text-gray-500 mt-1">
                    📍 {{ Str::limit($kost->alamat, 30) }}
                </p>

                <!-- FASILITAS -->
                <div class="flex flex-wrap gap-2 mt-3 text-xs">
                    @foreach($kost->fasilitas->take(3) as $f)
                        <span class="bg-gray-100 px-2 py-1 rounded-full">
                            {{ $f->nama }}
                        </span>
                    @endforeach

                    @if($kost->fasilitas->count() > 3)
                        <span class="bg-gray-100 px-2 py-1 rounded-full">
                            +{{ $kost->fasilitas->count() - 3 }}
                        </span>
                    @endif
                </div>

                <!-- PRICE -->
                <p class="mt-2 font-bold">
                    Rp {{ number_format($kost->harga) }}
                    <span class="text-sm text-gray-400">/bulan</span>
                </p>

            </div>
        </a>

    @empty
        <p class="text-gray-500">Belum ada kost tersedia</p>
    @endforelse

    </div>

<!-- MODAL GALLERY -->
<div id="galleryModal" class="fixed inset-0 bg-black/90 hidden z-50">

    <button onclick="closeGallery()"
        class="absolute top-5 right-6 text-white text-3xl">
        ✕
    </button>

    <button onclick="prevImage()"
        class="absolute left-6 top-1/2 -translate-y-1/2 text-white text-3xl">
        ‹
    </button>

    <button onclick="nextImage()"
        class="absolute right-6 top-1/2 -translate-y-1/2 text-white text-3xl">
        ›
    </button>

    <div class="flex items-center justify-center h-full">
        <img id="galleryImage"
            class="max-h-[85vh] max-w-[90vw] object-contain">
    </div>


</div>
</section>

<!-- CTA -->
<section class="bg-black text-white text-center py-12 mt-12">
    <h3 class="text-xl font-semibold mb-2">
        Punya Kost atau Kontrakan?
    </h3>
    <p class="text-gray-400 mb-4">
        Pasang iklan properti Anda dan jangkau ribuan calon penyewa
    </p>
    <button class="bg-white text-black px-6 py-2 rounded">
        Pasang Iklan Gratis
    </button>
</section>

<script>
let galleries = @json($kosts->mapWithKeys(fn($k) => [$k->id => $k->fotos->pluck('foto')]));
let currentIndex = 0;
let currentKost = null;

function openGallery(kostId, index) {
    currentKost = kostId;
    currentIndex = index;

    document.getElementById('galleryModal').classList.remove('hidden');
    showImage();
}

function closeGallery() {
    document.getElementById('galleryModal').classList.add('hidden');
}

function showImage() {
    let foto = galleries[currentKost][currentIndex];
    document.getElementById('galleryImage').src = '/storage/' + foto;
}

function nextImage() {
    if (currentIndex < galleries[currentKost].length - 1) {
        currentIndex++;
        showImage();
    }
}

function prevImage() {
    if (currentIndex > 0) {
        currentIndex--;
        showImage();
    }
}
</script>
</body>
</html>