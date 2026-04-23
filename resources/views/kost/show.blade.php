<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $kost->nama_kost }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6">

    <!-- ================= FOTO SLIDER ================= -->
    @php
        $mainFoto = $kost->fotos->where('is_primary', 1)->first()
                    ?? $kost->fotos->first();
    @endphp

    <div class="bg-white rounded-xl shadow p-4">

        <!-- FOTO UTAMA -->
        <img id="mainImage"
             src="{{ asset('storage/' . $mainFoto->foto) }}"
             class="w-full h-[400px] object-cover rounded-lg">

        <!-- THUMBNAIL -->
        <div class="flex gap-2 mt-3 overflow-x-auto">
            @foreach($kost->fotos as $foto)
                <img src="{{ asset('storage/' . $foto->foto) }}"
                     class="w-28 h-20 object-cover rounded cursor-pointer border hover:scale-105 transition"
                     onclick="changeImage(this)">
            @endforeach
        </div>

    </div>

    <!-- ================= INFO ================= -->
    <div class="grid md:grid-cols-3 gap-6 mt-6">

        <!-- KIRI -->
        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow">

            <h1 class="text-2xl font-bold mb-2">
                {{ $kost->nama_kost }}
            </h1>

            <p class="text-gray-500 mb-4">
                📍 {{ $kost->alamat }}
            </p>

            <!-- STATUS -->
            <div class="mb-4">
                <span class="px-3 py-1 rounded text-sm
                    {{ $kost->status == 'Tersedia' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $kost->status }}
                </span>
            </div>

            <!-- FASILITAS -->
            <h3 class="font-semibold mb-2">Fasilitas</h3>
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($kost->fasilitas as $f)
                    <span class="bg-gray-200 px-3 py-1 rounded text-sm">
                        {{ $f->nama }}
                    </span>
                @endforeach
            </div>

            <!-- DESKRIPSI -->
            <h3 class="font-semibold mb-2">Deskripsi</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ $kost->deskripsi }}
            </p>

        </div>

        <!-- KANAN -->
        <div class="bg-white p-6 rounded-xl shadow h-fit">

            <p class="text-2xl font-bold text-black">
                Rp {{ number_format($kost->harga) }}
                <span class="text-sm text-gray-400">/bulan</span>
            </p>

            <button class="mt-4 w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800">
                Booking Sekarang
            </button>

        </div>

    </div>

    <!-- ================= MAPS ================= -->
    @if($kost->maps)
    <div class="bg-white p-6 rounded-xl shadow mt-6">

        <h3 class="font-semibold mb-3">Lokasi</h3>

        <div class="w-full h-[350px] rounded overflow-hidden">
            <iframe 
                src="{{ $kost->maps }}"
                width="100%" height="100%" style="border:0;"
                allowfullscreen="" loading="lazy">
            </iframe>
        </div>

    </div>
    @endif

</div>

<!-- SCRIPT SLIDER -->
<script>
function changeImage(el) {
    document.getElementById('mainImage').src = el.src;
}
</script>

</body>
</html>