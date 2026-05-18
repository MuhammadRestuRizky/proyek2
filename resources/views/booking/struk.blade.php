<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow">

    <h1 class="text-2xl font-bold mb-6">
        Struk Transaksi
    </h1>

    <div class="space-y-3 text-sm">

        <div class="flex justify-between">
            <span>ID Transaksi</span>
            <span>TRX-{{ $booking->id }}</span>
        </div>

        <div class="flex justify-between">
            <span>Nama Kost</span>
            <span>{{ $booking->kost->nama_kost }}</span>
        </div>

        <div class="flex justify-between">
            <span>Penyewa</span>
            <span>{{ $booking->nama }}</span>
        </div>

        <div class="flex justify-between">
            <span>Durasi</span>
            <span>{{ $booking->durasi }} Bulan</span>
        </div>

        <div class="flex justify-between">
            <span>Total</span>
            <span class="font-bold">
                Rp {{ number_format($booking->total,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span>Status</span>
            <span class="text-green-600 font-bold">
                DISETUJUI
            </span>
        </div>

    </div>

    <button onclick="window.print()"
            class="mt-6 w-full bg-black text-white py-3 rounded-xl">

        Cetak Struk
    </button>

</div>

</body>
</html>