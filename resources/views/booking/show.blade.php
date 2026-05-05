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
    <div class="bg-white p-4 rounded-2xl border">
        <h3 class="font-semibold mb-3">Rincian Pembayaran</h3>

        <div class="text-sm space-y-2">

            <div class="flex justify-between">
                <span class="text-gray-500">Metode</span>
                <span class="font-medium">
                    {{ ucfirst($booking->metode) }}
                </span>
            </div>

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

        <!-- BUTTON -->
        <button class="w-full mt-4 bg-black text-white py-2.5 rounded-xl font-medium hover:opacity-90 transition">
            Upload Bukti Pembayaran
        </button>
    </div>


    <!-- INFORMASI PENYEWA -->
    <div class="bg-white p-4 rounded-2xl border">
        <h3 class="font-semibold mb-3">Informasi Penyewa</h3>

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