<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f3f3f3]">

<div class="min-h-screen">

    <!-- HEADER -->
    <div class="bg-black text-white px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <h1 class="font-bold text-xl">
                KostKu
            </h1>
        </div>

        <h2 class="text-2xl font-bold">
            Pesanan Masuk
        </h2>

        <div></div>

    </div>
    <!-- TOMBOL KEMBALI -->
    <div class="px-2 py-0">
        <a href="{{ route('pemilik.dashboard') }}" class="text-gray-600 text-sm hover:underline">
            ← Kembali
        </a>
    </div>
    <!-- CONTENT -->
    <div class="p-2 space-y-9">

        @foreach($bookings as $booking)

        <div class="bg-white rounded-1xl border p-2 flex gap-3 shadow-sm">

            <!-- FOTO KOST -->
            <div class="w-[260px]">

                @if($booking->kost->fotos->first())

                    <img src="{{ asset('storage/' . $booking->kost->fotos->first()->foto) }}"
                         class="w-full h-[180px] object-cover rounded-2xl">

                @endif

                <div class="mt-1">

                    <div class="flex items-center gap-2">

                        <span class="bg-black text-white text-xs px-3 py-1 rounded-full">
                            Kost
                        </span>

                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                            Tersedia
                        </span>

                    </div>

                    <h3 class="font-bold text-xl mt-0">
                        {{ $booking->kost->nama_kost }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-0">
                        {{ $booking->kost->alamat }}
                    </p>

                    <div class="mt-1 text-2xl font-bold">
                        Rp {{ number_format($booking->kost->harga,0,',','.') }}

                        <span class="text-sm text-gray-400 font-normal">
                            /bulan
                        </span>
                    </div>

                </div>

            </div>

            <!-- DETAIL -->
            <div class="flex-1">

                <div class="flex justify-between items-start">

                    <div>
                        <h2 class="text-2xl font-bold">
                            Detail Transaksi
                        </h2>

                        <p class="text-black-400 text-sm mt-1">
                            ID: trx-{{ $booking->id }}
                        </p>
                    </div>

                    @if($booking->status == 'disetujui')

                        <div class="bg-green-100 text-green-700 px-5 py-2 rounded-2xl font-bold text-xl">
                            ✔ Disetujui
                        </div>

                    @else

                        <div class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-2xl font-bold text-xl">
                            Pending
                        </div>

                    @endif

                </div>

                <!-- DATA -->
                <div class="grid grid-cols-2 gap-0 mt-0 text-sm">

                    <div class="flex items-center gap-2">
                        <p class="text-black-200">Nama :</p>
                        <p class="font-bold text-lg">
                            {{ $booking->nama }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-black-200">Email :</p>
                        <p class="font-bold text-lg">
                            {{ $booking->user->email }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-black-200">No Telepon :</p>
                        <p class="font-bold text-lg">
                            {{ $booking->no_telp }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-black-200">Tanggal Pembayaran :</p>
                        <p class="font-bold text-lg">
                            {{ $booking->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-black-200">Metode Pembayaran :</p>
                        <p class="font-bold text-lg">
                            {{ ucfirst($booking->metode) }}
                        </p>
                    </div>

                </div>

                <!-- TOTAL -->
                <div class="mt-1 border-t pt-1">

                    <div class="flex justify-between text-lg">
                        <span>Harga per bulan</span>

                        <span>
                            Rp {{ number_format($booking->kost->harga,0,',','.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-lg mt-0">
                        <span>Durasi</span>

                        <span>
                            {{ $booking->durasi }} bulan
                        </span>
                    </div>

                    <div class="flex justify-between text-2xl font-bold mt-1">
                        <span>Total</span>

                        <span>
                            Rp {{ number_format($booking->total,0,',','.') }}
                        </span>
                    </div>

                </div>

                <!-- BUKTI -->
                @if($booking->bukti_pembayaran)

                <div class="mt-3">
                <button
                    onclick="openModal('{{ asset('storage/' . $booking->bukti_pembayaran) }}')"
                    class="block w-full bg-gray-200 hover:bg-gray-300 text-center py-2 rounded-2xl font-semibold">
                    ⬇ Lihat Bukti Pembayaran
                </button>

                </div>

                @endif

                <!-- BUTTON -->
                @if($booking->status != 'disetujui')

                <form action="{{ route('pemilik.booking.setujui', $booking->id) }}"
                      method="POST"
                      class="mt-2">

                    @csrf

                    <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-2xl text-lg font-bold">

                        Setujui Pembayaran

                    </button>

                </form>

                @endif

            </div>

        </div>

        @endforeach

    </div>

</div>
<!-- MODAL FOTO -->
<div id="imageModal"
     class="fixed inset-0 bg-black/80 hidden z-50 flex items-center justify-center">

    <!-- CLOSE -->
    <button onclick="closeModal()"
            class="absolute top-5 right-6 text-white text-4xl font-bold">

        ✕

    </button>

    <!-- IMAGE -->
    <img id="modalImage"
         src=""
         class="max-w-[90%] max-h-[90%] rounded-2xl shadow-2xl">

</div>

<script>
    function openModal(image) {
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('modalImage').src = image;
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // klik background untuk close
    document.getElementById('imageModal')
        .addEventListener('click', function(e) {

        if (e.target.id === 'imageModal') {
            closeModal();
        }
    });
</script>
</body>
</html>