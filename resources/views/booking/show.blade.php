<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f5f6f8]">

<div class="max-w-4xl mx-auto p-4 space-y-4">

    <!-- HEADER -->
    <div class="bg-white p-4 rounded-2xl border flex justify-between items-center">
        <div>
            <h2 class="font-bold text-lg">Detail Transaksi</h2>
            <p class="text-xs text-gray-400">
                ID Transaksi: trx-{{ $booking->id }}
            </p>
        </div>

        <span class="text-xs px-3 py-1 rounded-full font-medium

@if($booking->status == 'disetujui')
    bg-green-100 text-green-700
@elseif($booking->status == 'ditolak')
    bg-red-100 text-red-700
@else
    bg-yellow-100 text-yellow-700
@endif
">
    {{ ucfirst($booking->status) }}
</span>
    </div>

    <!-- NOTIF -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-medium">
            {{ $errors->first() }}
        </div>
    @endif


    <!-- INFORMASI KOST -->
    <div class="bg-white p-4 rounded-2xl border">
        <h3 class="font-semibold mb-3">Informasi Kost</h3>

        <div class="flex gap-4">

            <!-- FOTO -->
            @if($booking->kost->fotos->first())
                <img src="{{ asset('storage/' . $booking->kost->fotos->first()->foto) }}"
                    class="w-28 h-20 object-cover rounded-xl">
            @endif

            <!-- DETAIL -->
            <div class="flex flex-col justify-between text-sm w-full">
                <div>
                    <p class="font-semibold text-base">
                        {{ $booking->kost->nama_kost }}
                    </p>

                    <p class="text-gray-400 text-xs">
                        {{ $booking->kost->alamat }}
                    </p>
                </div>

                <div class="flex justify-between mt-2 text-xs text-gray-600">

                    <div>
                        <p class="text-gray-400">Tanggal Masuk</p>

                        <p>
                            {{ \Carbon\Carbon::parse($booking->tanggal_masuk)->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Durasi</p>
                        <p>{{ $booking->durasi }} bulan</p>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- RINCIAN PEMBAYARAN -->
    <!-- INFORMASI PEMBAYARAN -->
<div class="bg-white p-4 rounded-2xl border">

    <h3 class="font-semibold mb-4">
        Informasi Pembayaran
    </h3>
    <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>

                <span>
                    {{ $booking->created_at->translatedFormat('d M Y') }}
                </span>
            </div>

    @if($booking->paymentMethod)

<div class="border rounded-lg p-4 mb-3 bg-gray-50">

    <div class="font-bold text-lg">
        {{ $booking->paymentMethod->method_name }}
    </div>

    <div class="flex justify-between items-center mt-2">

        <div id="rekening">
            {{ $booking->paymentMethod->account_number }}
        </div>

        <button
            onclick="copyRekening()"
            class="px-3 py-1 bg-black text-white rounded-lg text-sm">

            Salin
        </button>

    </div>

</div>

@endif

    <div class="border-t my-4"></div>

    <div class="flex justify-between mb-2">
        <span class="text-gray-500">
            Harga per bulan
        </span>

        <span>
            Rp {{ number_format($booking->kost->harga,0,',','.') }}
        </span>
    </div>

    <div class="flex justify-between mb-2">
        <span class="text-gray-500">
            Durasi
        </span>

        <span>
            {{ $booking->durasi }} bulan
        </span>
    </div>

    <div class="border-t my-3"></div>

    <div class="flex justify-between text-lg font-bold">
        <span>Total</span>

        <span>
            Rp {{ number_format($booking->total,0,',','.') }}
        </span>
    </div>

</div>
        <!-- ACTION -->
<div class="mt-4 space-y-3">

    {{-- JIKA SUDAH DISETUJUI --}}
    @if($booking->status == 'disetujui')

        <!-- DOWNLOAD STRUK -->
        <a href="{{ route('booking.struk', $booking->id) }}"
           class="w-full border flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-medium hover:bg-gray-50 transition">

            ⬇️ Unduh Struk Transaksi
        </a>

        <!-- WHATSAPP -->
        <a href="https://wa.me/{{ $booking->kost->pemilik->no_wa }}?text=Halo%20saya%20ingin%20menghubungi%20pemilik%20kost"
           target="_blank"
           class="w-full bg-black text-white py-3 rounded-xl text-sm font-medium flex justify-center items-center hover:opacity-90 transition">

            Kontak Pemilik Kost
        </a>

        <!-- KEMBALI KE DASHBOARD -->
        <a href="/"
        class="w-full bg-green-600 text-white py-3 rounded-xl text-sm font-medium flex justify-center items-center hover:bg-green-700 transition">
            Kembali ke Dashboard
        </a>

    @else

        <!-- FORM UPLOAD -->
        <form action="{{ route('booking.upload', $booking->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <label class="block text-sm font-medium mb-2">
                SUBMIT PEMBAYARAN
            </label>

            <input type="file"
                   name="bukti_pembayaran"
                   required
                   class="w-full border border-gray-300 rounded-xl p-3 text-sm file:mr-3 file:border-0 file:bg-black file:text-white file:px-4 file:py-2 file:rounded-lg file:cursor-pointer">

            <button type="submit"
                    class="w-full mt-4 bg-black text-white py-3 rounded-xl font-medium hover:opacity-90 transition">

                SUBMIT PEMBAYARAN

            </button>

        </form>

        <!-- PREVIEW -->
        @if($booking->bukti_pembayaran)

            <div class="mt-5">

                <p class="text-sm font-semibold mb-2">
                    Bukti Pembayaran
                </p>

                <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}"
                     class="w-full max-w-sm rounded-2xl border">

                <!-- Tombol Kembali -->
                <a href="{{ route('home') }}"
                class="mt-4 w-full bg-green-600 text-white py-3 rounded-xl text-sm font-medium flex justify-center items-center hover:bg-green-700 transition">
                    Kembali ke Dashboard
                </a>     

                <div class="mt-3 inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                    Menunggu Verifikasi Pemilik Kost
                </div>

            </div>

        @endif

    @endif

</div>

    <!-- INFORMASI PEMILIK KOST -->

     <h3 class="font-semibold text-lg mb-1">
        Informasi Pemilik Kost
    </h3>
<div class="bg-white p-1 rounded-1xl border">

    <div class="grid md:grid-cols-2 gap-2 items-start">

        <!-- KIRI -->
        <div class="space-y-4">

            <div class="mb-3">
                <p class="text-xs text-gray-400">Nama</p>

                <p class="font-semibold text-base">
                    {{ $booking->kost->pemilik->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400">No. Telepon</p>

                <p class="font-semibold text-base">
                    {{ $booking->kost->pemilik->no_wa ?? '-' }}
                </p>
            </div>

        </div>

        <!-- KANAN -->
        <div class="space-y-2">

            <p class="font-semibold text-base-400 mb-2">
                Lokasi
            </p>
            @php
            $mapsLink = "https://www.google.com/maps/search/?api=1&query=" .
                        urlencode($booking->kost->alamat);
            @endphp
            @if($booking->kost->maps)

                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($booking->kost->alamat) }}"
                   target="_blank">

                    <div class="overflow-hidden rounded-xl border hover:opacity-90 transition">

                        {!! str_replace(
                            ['width="600"', 'height="450"'],
                            ['width="100%"', 'height="180"'],
                            $booking->kost->maps
                        ) !!}

                    </div>

                </a>

                <p class="text-xs text-gray-500 mt-2">
                    {{ $booking->kost->alamat }}
                </p>

            @endif

        </div>

    </div>

</div>
<script>
function copyNumber(text) {

    navigator.clipboard.writeText(text);

    alert('Nomor pembayaran berhasil disalin');
}
</script>
<script>
function copyRekening() {

    let rekening =
        document.getElementById('rekening').innerText;

    navigator.clipboard.writeText(rekening);

    alert('Nomor berhasil disalin');
}
</script>
</body>
</html>