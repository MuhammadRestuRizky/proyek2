<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $kost->nama_kost }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f5f6f8]">

<!-- NAVBAR -->
<div class="bg-black text-white px-6 py-3 flex items-center justify-between">

    <!-- KIRI (LOGO) -->
    <div class="text-lg font-semibold">
        KostKu
    </div>

    <!-- TENGAH (MENU) -->
    <div class="flex gap-6 text-sm items-center">
        <a href="#" class="flex items-center gap-1 hover:text-gray-300">
            📄 Riwayat
        </a>
        <a href="#" class="flex items-center gap-1 hover:text-gray-300">
            🔍 Pencarian
        </a>
        <a href="#" class="flex items-center gap-1 bg-gray-700 px-3 py-1 rounded-lg">
            🏠 Beranda
        </a>
    </div>

    <!-- KANAN (USER) -->
    <div class="flex items-center gap-3">
        <span>{{ auth()->user()->name ?? 'Warnadi' }}</span>
        <div class="w-8 h-8 bg-gray-300 text-black rounded-full flex items-center justify-center text-sm">
            {{ strtoupper(substr(auth()->user()->name ?? 'WA', 0, 2)) }}
        </div>
    </div>

</div>

<!-- TOMBOL KEMBALI -->
<div class="px-6 py-3">
    <a href="{{ url()->previous() }}" class="text-gray-600 text-sm hover:underline">
        ← Kembali
    </a>
</div>

<div class="max-w-6xl mx-auto p-6">

    @php
        $fotos = $kost->fotos;
        $mainFoto = $fotos->where('is_primary', 1)->first() ?? $fotos->first();
    @endphp

    <!-- GRID UTAMA -->
    <div class="grid grid-cols-3 gap-6">

        <!-- ================= LEFT ================= -->
        <div class="col-span-2">

            <!-- FOTO -->
            <div class="grid grid-cols-3 gap-3 h-[240px] mb-4">

                <!-- FOTO BESAR -->
                <div class="col-span-2 h-full">
                    <img id="mainImage"
                        src="{{ asset('storage/' . $mainFoto->foto) }}"
                        class="w-full h-full object-cover rounded-2xl">
                </div>

                <!-- FOTO KANAN -->
                <div class="flex flex-col gap-2 h-full">
                    @foreach($fotos->skip(1)->take(3) as $foto)
                        <img src="{{ asset('storage/' . $foto->foto) }}"
                            onclick="changeImage(this)"
                            class="w-full flex-1 object-cover rounded-xl cursor-pointer hover:opacity-80 transition">
                    @endforeach
                </div>

            </div>

            <!-- BADGE -->
            <div class="flex gap-2 text-xs">
                <span class="bg-black text-white px-2 py-1 rounded-full">Kost</span>
                <span class="bg-gray-200 px-2 py-1 rounded-full">
                    {{ ucfirst($kost->gender ?? 'Putra') }}
                </span>
                <span class="bg-green-200 text-green-700 px-2 py-1 rounded-full">
                    {{ $kost->status }}
                </span>
            </div>

            <!-- TITLE -->
            <h1 class="text-2xl font-bold mt-2">
                {{ $kost->nama_kost }}
            </h1>

            <!-- ALAMAT -->
            <p class="text-gray-500 text-sm mt-1">
                📍 {{ $kost->alamat }}
            </p>

            <!-- HARGA -->
            <p class="text-xl font-bold mt-2">
                Rp {{ number_format($kost->harga,0,',','.') }}
                <span class="text-sm text-gray-400">/bulan</span>
            </p>

            <!-- TAB -->
            <div class="mt-4 bg-gray-200 rounded-full flex text-sm p-1 w-[280px]">
                <div class="w-1/2 bg-white text-center py-1 rounded-full font-medium">
                    Informasi
                </div>
                <div class="w-1/2 text-center py-1 text-gray-500">
                    Booking
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white rounded-2xl p-4 mt-4 border">
                <h3 class="font-semibold mb-2">Deskripsi</h3>
                <p class="text-sm text-gray-600">
                    {{ $kost->deskripsi }}
                </p>
            </div>

            <!-- FASILITAS -->
            <div class="bg-white rounded-2xl p-4 mt-4 border">
                <h3 class="font-semibold mb-3">Fasilitas</h3>

                <div class="grid grid-cols-2 gap-2 text-sm">
                    @foreach($kost->fasilitas as $f)
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 bg-gray-300 rounded-full flex items-center justify-center text-xs">✓</span>
                            {{ $f->nama }}
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ================= RIGHT ================= -->
        <div class="space-y-4">

            <!-- BOOKING -->
            <div class="bg-white p-4 rounded-2xl border">
                <button class="w-full bg-[#0B0F1A] text-white py-2 rounded-lg">
                    Booking Sekarang
                </button>
            </div>

            <!-- PEMILIK -->
            <div class="bg-white p-4 rounded-2xl border">
                <h3 class="font-semibold mb-3">Hubungi Pemilik</h3>

                @php
                    $pemilik = $kost->pemilik ?? null;
                    $phone = $pemilik->no_wa ?? null;

                    if ($phone && substr($phone, 0, 1) == '0') {
                        $phone = '62' . substr($phone, 1);
                    }
                @endphp

                <p class="text-xs text-gray-500">Nama Pemilik</p>
                <p class="mb-2">{{ $pemilik->name ?? '-' }}</p>

                <p class="text-xs text-gray-500">Nomor WhatsApp</p>
                <p class="mb-3">{{ $pemilik->no_wa ?? '-' }}</p>

                @if($phone)
                    <a href="https://wa.me/{{ $phone }}?text=Halo%20saya%20tertarik%20dengan%20kost%20{{ urlencode($kost->nama_kost) }}"
                        target="_blank"
                        class="block text-center bg-[#0B0F1A] text-white py-2 rounded-lg hover:opacity-90 transition">
                        WhatsApp
                    </a>
                @endif
            </div>

            <!-- MAP -->
            @if($kost->maps)
            <div class="bg-white p-4 rounded-2xl border">
                <h3 class="font-semibold mb-2">Lokasi</h3>

                <div class="w-full h-40 rounded overflow-hidden">
                    <iframe src="{{ $kost->maps }}"
                        width="100%" height="100%" style="border:0;"
                        loading="lazy">
                    </iframe>
                </div>

                <p class="text-xs text-gray-500 mt-2">
                    {{ $kost->alamat }}
                </p>
            </div>
            @endif

        </div>

    </div>
</div>

<!-- SCRIPT SLIDER -->
<script>
function changeImage(el) {
    const main = document.getElementById('mainImage');
    main.src = el.src;

    // efek smooth (opsional)
    main.classList.add('scale-95');
    setTimeout(() => {
        main.classList.remove('scale-95');
    }, 150);
}
</script>

</body>
</html>