<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
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

    <!-- INFO -->
    <div>
        <h1 class="text-xl font-bold">{{ $kost->nama_kost }}</h1>
        <p class="text-sm text-gray-500">{{ $kost->alamat }}</p>

        <p class="text-lg font-bold mt-1">
            Rp {{ number_format($kost->harga,0,',','.') }}
            <span class="text-sm text-gray-400">/bulan</span>
        </p>
    </div>

   <div class="bg-gray-200 rounded-full flex text-sm p-1 w-[260px]">

    <!-- INFORMASI (ke halaman detail kost) -->
    <a href="{{ route('kost.detail', $kost->id) }}"
        class="w-1/2 text-center py-1 rounded-full bg-white font-mediumtext-gray-500">
        Informasi
    </a>

    <!-- BOOKING (aktif di halaman ini) -->
    <div class="w-1/2 text-center py-1 rounded-full text-gray-500">
        Booking
    </div>

</div>

    <!-- FORM -->
    <form action="{{ route('booking.store') }}" method="POST" class="bg-white p-4 rounded-2xl border">
        @csrf
        <input type="hidden" name="kost_id" value="{{ $kost->id }}">
        <input type="hidden" name="nama" value="{{ auth()->user()->name }}">
        <h3 class="font-semibold mb-3">Detail Booking</h3>

        <!-- PENYEWA -->
        <div class="bg-gray-100 p-3 rounded-xl mb-3 text-sm">
            <p class="font-medium mb-2">Informasi Penyewa</p>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-gray-400 text-xs">Nama</p>
                    <p>{{ auth()->user()->name }}</p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs">Email</p>
                    <p>{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs">No Telepon</p>
                    <input type="text" name="no_telp"
                        class="w-full border rounded p-1 text-sm">
                </div>
            </div>
        </div>

        <!-- TANGGAL -->
        <div class="mb-3">
            <label class="text-xs">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk"
                class="w-full border p-2 rounded-lg text-sm">
        </div>

        <!-- DURASI -->
        <div class="mb-3">
            <label class="text-xs">Durasi Sewa (bulan)</label>
            <input type="number" id="durasi" name="durasi" value="1" min="1"
                class="w-full border p-2 rounded-lg text-sm"
                onchange="hitungTotal()">
        </div>

        <!-- METODE -->
        <div class="mb-3">
            <label class="text-xs">Metode Pembayaran</label>

            <div class="space-y-2 mt-2 text-sm">
                <label class="block border p-2 rounded-xl">
                    <input type="radio" name="metode" value="bank" checked>
                    Transfer Bank
                </label>

                <label class="block border p-2 rounded-xl">
                    <input type="radio" name="metode" value="ewallet">
                    E-Wallet
                </label>

                <label class="block border p-2 rounded-xl">
                    <input type="radio" name="metode" value="cash">
                    Tunai
                </label>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="border-t pt-3 text-sm">
            <div class="flex justify-between">
                <span>Harga per bulan</span>
                <span>Rp {{ number_format($kost->harga,0,',','.') }}</span>
            </div>

            <div class="flex justify-between">
                <span>Durasi</span>
                <span id="durasiText">1 bulan</span>
            </div>

            <div class="flex justify-between font-bold mt-2">
                <span>Total Pembayaran</span>
                <span id="totalText">
                    Rp {{ number_format($kost->harga,0,',','.') }}
                </span>
            </div>
        </div>

        <button class="w-full mt-4 bg-black text-white py-2 rounded-xl">
            Buat Pesanan
        </button>

    </form>

</div>

<!-- ================= RIGHT ================= -->
<div class="space-y-4">

    @php
        $pemilik = $kost->pemilik ?? null;
        $phone = $pemilik->no_wa ?? null;

        if ($phone && substr($phone,0,1) == '0') {
            $phone = '62' . substr($phone,1);
        }
    @endphp

    <!-- PEMILIK -->
    <div class="bg-white p-4 rounded-2xl border">
        <h3 class="font-semibold mb-3">Hubungi Pemilik</h3>

        <p class="text-xs text-gray-400">Nama Pemilik</p>
        <p class="mb-2">{{ $pemilik->name ?? '-' }}</p>

        <p class="text-xs text-gray-400">Nomor Telepon</p>
        <p class="mb-3">{{ $pemilik->no_wa ?? '-' }}</p>

        @if($phone)
        <a href="https://wa.me/{{ $phone }}"
            target="_blank"
            class="block text-center bg-black text-white py-2 rounded-lg">
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

<!-- SCRIPT -->
<script>
function hitungTotal() {
    let harga = {{ $kost->harga }};
    let durasi = document.getElementById('durasi').value;
    let total = harga * durasi;

    document.getElementById('durasiText').innerText = durasi + " bulan";
    document.getElementById('totalText').innerText =
        "Rp " + total.toLocaleString('id-ID');
}
</script>

</body>
</html>