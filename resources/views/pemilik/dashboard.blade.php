<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>

</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<div class="fixed top-0 left-0 w-full z-50 bg-black text-white px-6 py-3 flex items-center justify-between shadow">

    <!-- LEFT -->
    <div class="flex items-center gap-4">

        <!-- LOGO -->
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 border border-white rounded-md flex items-center justify-center text-xs">
                🏢
            </div>
            <span class="font-semibold text-lg tracking-wide">KostKu</span>
        </div>

        <!-- SEARCH -->
        <div class="relative">
            <input type="text"
                placeholder="Cari Nama kost Anda ..."
                class="bg-gray-200 text-black px-4 py-1.5 pl-10 rounded-full w-[420px] text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">

            <span class="absolute left-3 top-1.5 text-gray-500 text-sm">🔍</span>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-6">

        <a class="flex items-center gap-1 text-sm hover:text-gray-300 transition">
            🏠 Beranda
        </a>

        <!-- PROFILE -->
        <a href="{{ route('pemilik.profile.edit') }}"
           class="flex items-center gap-2 hover:opacity-80 transition">

            <span class="text-sm">{{ auth()->user()->name }}</span>

            <img 
                src="{{ auth()->user()->photo 
                    ? asset('storage/' . auth()->user()->photo) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                class="w-8 h-8 rounded-full border border-white">
        </a>

    </div>

</div>


<div class="flex">

<!-- SIDEBAR -->
<div class="w-56 bg-gradient-to-b from-black to-gray-900 text-white p-6 fixed top-0 left-0 h-screen pt-[64px] z-40">

    <div class="space-y-8">

        <div class="flex items-center gap-4 hover:translate-x-1 transition">
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                👤
            </div>
            <span class="font-medium text-lg">Kelola Profil</span>
        </div>

        <a href="{{ route('pemilik.kost.create') }}"
            class="flex items-center gap-4 hover:translate-x-1 transition cursor-pointer">
                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                    +
                </div>
                <div class="font-medium text-lg">Pasang Iklan</div>
            </a>

        <div class="flex items-center gap-4 hover:translate-x-1 transition">
            <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                📦
            </div>
            <span class="font-medium text-lg">Pesanan</span>
        </div>

    </div>

</div>


<!-- CONTENT -->
<div class="flex-1 ml-56 mt-20 px-6">
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-gray 200 to-gray-200 py-2 text-center shadow-inner">

        <h1 class="text-2xl font-bold">
            Kelola Kost & Kontrakan Anda
        </h1>

        <p class="text-gray-400 mt-1">
            Kelola properti Anda dengan mudah dan profesional
        </p>

        <!-- FILTER -->
        <div class="mt-0 flex justify-center">
            <div class="bg-white rounded-full shadow flex overflow-hidden">

                <button class="px-6 py-2 bg-black text-white text-sm">
                    Kostan
                </button>

                <button class="px-6 py-2 text-sm hover:bg-gray-100 transition">
                    Kontrakan
                </button>

                <button class="px-6 py-2 text-sm hover:bg-gray-100 transition">
                    Semua
                </button>

            </div>
        </div>

    </div>

<div class="px-10 py-2">

    <h3 class="text-xl font-semibold mb-6">Iklan Anda</h3>

    <div class="grid md:grid-cols-4 gap-8">

    @forelse ($kosts as $kost)

<!-- CARD -->
<div class="bg-white rounded-2xl shadow overflow-hidden">

    {{-- HERO IMAGE --}}
    @php
        $fotos = $kost->fotos;
        $main = $fotos->first();
    @endphp

    <div class="relative">
        @if($main)
            <img src="{{ asset('storage/' . $main->foto) }}"
                class="w-full h-36 object-cover">
        @else
            <div class="w-full h-36 bg-gray-300 flex items-center justify-center">
                Tidak ada foto
            </div>
        @endif
    </div>

    {{-- THUMBNAIL --}}
    <div class="flex gap-2 p-3 overflow-x-auto">

        @foreach($fotos->take(4) as $i => $foto)
            <img src="{{ asset('storage/' . $foto->foto) }}"
                onclick="openGallery({{ $kost->id }}, {{ $i }})"
                class="w-12 h-8 object-cover rounded-lg cursor-pointer hover:opacity-80">
        @endforeach

    </div>

    {{-- CONTENT --}}
    <div class="px-2 pb-3">

        {{-- BADGE --}}
        <div class="flex gap-2 mb-2 text-xs">
            <span class="bg-black text-white px-2 py-1 rounded-full">Kost</span>

            <span class="bg-gray-200 px-2 py-1 rounded-full">
                {{ ucfirst($kost->gender ?? 'Putra') }}
            </span>
        </div>

        {{-- TITLE --}}
        <h3 class="text-lg font-semibold leading-tight">
            {{ $kost->nama_kost }}
        </h3>

        {{-- ADDRESS --}}
        <p class="text-sm text-gray-500 mt-1">
            📍 {{ Str::limit($kost->alamat, 30) }}
        </p>

        {{-- FASILITAS --}}
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

        {{-- PRICE --}}
        <div class="mt-2">
            <p class="text-1x0 font-bold">
                Rp {{ number_format($kost->harga) }}
                <span class="text-sm text-gray-400">/bulan</span>
            </p>

            <a href="{{ route('pemilik.kost.edit', $kost->id) }}"
            class="text-xs px-3 py-1 rounded-lg border border-gray-300 hover:bg-gray-100">
                Edit
            </a>
        </div>

    </div>

</div>   
    @empty
        <p class="text-gray-500">Belum ada kost</p>
    @endforelse

</div>


<!-- ================= MODAL ================= -->
<div id="galleryModal"
    class="fixed inset-0 bg-black/90 hidden z-50">

    <!-- CLOSE -->
    <button onclick="closeGallery()"
        class="absolute top-5 right-6 text-white text-3xl z-50">
        ✕
    </button>

    <!-- LEFT -->
    <button onclick="prevImage()"
        class="absolute left-6 top-1/2 -translate-y-1/2 bg-black/50 text-white px-4 py-2 rounded-full z-40">
        ‹
    </button>

    <!-- RIGHT -->
    <button onclick="nextImage()"
        class="absolute right-6 top-1/2 -translate-y-1/2 bg-black/50 text-white px-4 py-2 rounded-full z-40">
        ›
    </button>

    <!-- IMAGE CENTER -->
    <div class="flex items-center justify-center h-full">

        <img id="galleryImage"
            class="max-h-[85vh] max-w-[90vw] object-contain transition duration-300">

    </div>

</div>


<!-- ================= SCRIPT ================= -->
<script>
let galleryData = {};
let currentIndex = 0;
let currentKost = null;

// ambil semua foto dari blade
@foreach($kosts as $kost)
    galleryData[{{ $kost->id }}] = [
        @foreach($kost->fotos as $foto)
            "{{ asset('storage/' . $foto->foto) }}",
        @endforeach
    ];
@endforeach

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
    document.getElementById('galleryImage').src =
        galleryData[currentKost][currentIndex];
}

function nextImage() {
    let total = galleryData[currentKost].length;
    currentIndex = (currentIndex + 1) % total;
    showImage();
}

function prevImage() {
    let total = galleryData[currentKost].length;
    currentIndex = (currentIndex - 1 + total) % total;
    showImage();
}

// klik background untuk close
document.getElementById('galleryModal')
.addEventListener('click', function(e) {
    if (e.target.id === 'galleryModal') {
        closeGallery();
    }
});
</script>
</body>
</html>