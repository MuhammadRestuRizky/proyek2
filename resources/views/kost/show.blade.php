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
            📄 Transaksi
        </a>
        <a href="#" class="flex items-center gap-1 hover:text-gray-300">
            🔍 Pencarian
        </a>
        <a href="#" class="flex items-center gap-1 hover:text-gray-300">
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
<div class="px-2 py-1">
    <a href="{{ url()->previous() }}" class="text-gray-600 text-sm hover:underline">
        ← Kembali
    </a>
</div>

<div class="max-w-4xl mx-auto p-1">

    @php
        $fotos = $kost->fotos;
        $mainFoto = $fotos->where('is_primary', 1)->first() ?? $fotos->first();
    @endphp

    <!-- GRID UTAMA -->
    <div class="grid grid-cols-3 gap-6">

        <!-- ================= LEFT ================= -->
        <div class="col-span-2">

           <!-- FOTO -->
<div class="grid grid-cols-3 gap-3 mb-2">

    <!-- FOTO BESAR -->
    <div class="col-span-2 aspect-[4/3]">
        <img id="mainImage"
            src="{{ asset('storage/' . $mainFoto->foto) }}"
            onclick="openModal(this.src)"
            class="w-full h-full object-cover rounded-2xl">
    </div>

    <!-- FOTO KANAN -->
    <div class="grid grid-cols-2 grid-rows-2 grid-flow-col gap-2 h-full">
        @foreach($fotos->skip(1)->take(4) as $foto)
            <div class="aspect-square">
                <img src="{{ asset('storage/' . $foto->foto) }}"
                    onclick="changeImage(this); openModal(this.src)"
                    class="w-full h-full object-cover rounded-xl cursor-pointer hover:opacity-80 transition">
            </div>
        @endforeach
    </div>

</div>

            <!-- BADGE -->
            <div class="flex gap-2 text-xs mt-1">
                <span class="bg-black text-white px-2 py-1 rounded-full">Kost</span>
                <span class="bg-gray-200 px-2 py-1 rounded-full">
                    {{ ucfirst($kost->gender ?? 'Putra') }}
                </span>
                <span class="bg-green-200 text-green-700 px-2 py-1 rounded-full">
                    {{ $kost->status }}
                </span>
            </div>

            <!-- TITLE -->
            <h1 class="text-2xl font-bold">
                {{ $kost->nama_kost }}
            </h1>

            <!-- ALAMAT -->
            <p class="text-gray-500 text-sm">
                📍 {{ $kost->alamat }}
            </p>

            <!-- HARGA -->
            <p class="text-xl font-bold">
                Rp {{ number_format($kost->harga,0,',','.') }}
                <span class="text-sm text-gray-400">/bulan</span>
            </p>

            <div class="bg-gray-200 rounded-full flex text-sm p-1 w-[260px]">

                <!-- INFORMASI (aktif) -->
                <div class="w-1/2 text-center py-1 text-gray-500">
                    Informasi
                </div>

                <!-- BOOKING -->
                <a href="{{ route('booking.create', $kost->id) }}"
                    class="w-1/2 bg-white text-center py-1 rounded-full font-medium">
                    Booking
                </a>

            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white rounded-2xl p-2">
                <h3 class="font-semibold mb-2">Deskripsi</h3>
                <p class="text-sm text-gray-600">
                    {{ $kost->deskripsi }}
                </p>
            </div>

            <!-- FASILITAS -->
            <div class="bg-white rounded-2xl p-2 mt-2 border">
                <h3 class="font-semibold mb-1">Fasilitas</h3>

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

             <!-- BOOKING -->
            <a href="{{ route('booking.create', $kost->id) }}"
                class="block text-center bg-[#0B0F1A] text-white py-2 rounded-lg">
                Booking Sekarang
            </a>
            
        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>
function changeImage(el) {
    const main = document.getElementById('mainImage');
    main.src = el.src;

    main.classList.add('scale-95');
    setTimeout(() => {
        main.classList.remove('scale-95');
    }, 150);
}

function openModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalImg.src = src;
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target.id === 'imageModal') {
        closeModal();
    }
});
</script>

<!-- MODAL -->
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    <span onclick="closeModal()" class="absolute top-5 right-8 text-white text-3xl cursor-pointer">&times;</span>
    <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded-xl shadow-lg">
</div>

</body>
</html>