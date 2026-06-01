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

        <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
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
    <h3 class="text-xl font-bold mt-6 mb-3">
    Metode Pembayaran Pemilik Kost
</h3>

@forelse($booking->kost->pemilik->paymentMethods->where('is_active', true) as $payment)

<div class="border rounded-lg p-4 mb-3 bg-gray-50">

    <div class="font-bold text-lg">
        {{ $payment->method_name }}
    </div>

    <div class="text-gray-700">
        Nomor: {{ $payment->account_number }}
    </div>

</div>

@empty

<div class="text-red-500">
    Pemilik kost belum menambahkan metode pembayaran
</div>
@endforelse

            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>

                <span>
                    {{ $booking->created_at->translatedFormat('d M Y') }}
                </span>
            </div>

            <div class="border-t my-2"></div>

            <div class="flex justify-between">
                <span>Harga / bulan</span>

                <span>
                    Rp {{ number_format($booking->kost->harga,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Durasi</span>
                <span>{{ $booking->durasi }} bulan</span>
            </div>

            <div class="flex justify-between text-base font-bold mt-2">
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

                <div class="mt-3 inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                    Menunggu Verifikasi Pemilik Kost
                </div>

            </div>

        @endif

    @endif

</div>

    <!-- INFORMASI PENYEWA -->
    <div class="bg-white p-4 rounded-2xl border">

        <h3 class="font-semibold mb-3">
            Informasi Penyewa
        </h3>

        <div class="grid grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-400 text-xs">Nama</p>
                <p class="font-medium">{{ $booking->nama }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-xs">No Telepon</p>
                <p class="font-medium">{{ $booking->no_telp }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-xs">Pemilik</p>

                <p class="font-medium">
                    {{ $booking->kost->pemilik->name ?? '-' }}
                </p>
            </div>

        </div>
    </div>

</div>

</body>
</html>