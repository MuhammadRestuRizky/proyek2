<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f6f8]">

<div class="max-w-5xl mx-auto p-6">

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

            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
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