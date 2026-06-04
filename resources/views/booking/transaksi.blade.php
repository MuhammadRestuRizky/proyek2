<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f6f8]">

<body class="bg-[#f5f6f8]">

<!-- NAVBAR -->
<div class="bg-black text-white px-6 py-3 flex items-center justify-between">

    <!-- KIRI (LOGO) -->
    <div class="text-lg font-semibold">
        KostKu
    </div>

    <!-- TENGAH (MENU) -->
    <div class="flex gap-6 text-sm items-center">
        <a href="{{ route('transaksi.index') }}" class="flex items-center gap-1 hover:text-gray-300">
            📄 Transaksi
        </a>
        <a href="#" class="flex items-center gap-1 hover:text-gray-300">
            🔍 Pencarian
        </a>
        <a href="{{ route('home') }}" 
        class="flex items-center gap-1 hover:text-gray-300">
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
    <h1 class="text-2xl font-bold mb-6">
        Riwayat Transaksi
    </h1>

    @forelse($bookings as $booking)

    <a href="{{ route('booking.show', $booking->id) }}"
       class="block bg-white p-4 rounded-2xl border mb-4 hover:shadow">

        <div class="flex justify-between items-center">

            <div>
                <h3 class="font-semibold">
                    {{ $booking->kost->nama_kost }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $booking->created_at->format('d M Y') }}
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

    </a>

    @empty

    <div class="bg-white p-6 rounded-2xl border text-center">
        Belum ada transaksi.
    </div>

    @endforelse

</div>

</body>
</html>