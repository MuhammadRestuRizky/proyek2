<x-app-layout>
<div class="max-w-4xl mx-auto p-6">

    <div class="bg-white shadow rounded-lg overflow-hidden">

        @if($kost->foto)
        <img src="{{ asset('storage/'.$kost->foto) }}" 
             class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <h1 class="text-2xl font-bold">
                {{ $kost->nama_kost }}
            </h1>

            <p class="mt-2 text-gray-600">
                {{ $kost->alamat }}
            </p>

            <p class="mt-4">
                {{ $kost->deskripsi }}
            </p>

            <p class="mt-4 text-green-600 font-bold text-xl">
                Rp {{ number_format($kost->harga,0,',','.') }}/bulan
            </p>

            <div class="mt-4">
                <span class="bg-blue-100 px-3 py-1 rounded">
                    {{ $kost->tipe }}
                </span>
                <span class="bg-green-100 px-3 py-1 rounded">
                    KM {{ $kost->kamar_mandi }}
                </span>
            </div>

            <a href="https://wa.me/{{ $kost->user->phone ?? '628000000000' }}"
               target="_blank"
               class="block mt-6 bg-green-600 text-white text-center py-3 rounded">
               Hubungi via WhatsApp
            </a>

        </div>
    </div>
</div>
</x-app-layout>
