@forelse($kosts as $kost)

<a href="{{ route('kost.detail', $kost->id) }}"
   class="block bg-white rounded-xl shadow hover:shadow-xl hover:scale-[1.02] transition overflow-hidden">

    <!-- FOTO -->
    <img 
        src="{{ $kost->foto ? asset('storage/'.$kost->foto) : 'https://source.unsplash.com/400x300/?room' }}"
        class="h-48 w-full object-cover">

    <div class="p-4">

        <!-- TAG -->
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs bg-black text-white px-2 py-1 rounded">
                Kost
            </span>

            <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                {{ ucfirst($kost->gender) }}
            </span>
        </div>

        <!-- NAMA -->
        <h4 class="font-semibold text-lg leading-tight">
            {{ $kost->nama }}
        </h4>

        <!-- ALAMAT -->
        <p class="text-sm text-gray-500 line-clamp-2">
            {{ $kost->alamat }}
        </p>

        <!-- FASILITAS -->
        <div class="flex flex-wrap gap-2 mt-2 text-xs">
            @if($kost->ac)
                <span class="bg-gray-200 px-2 py-1 rounded">AC</span>
            @endif

            @if($kost->wifi ?? false)
                <span class="bg-gray-200 px-2 py-1 rounded">WiFi</span>
            @endif

            @if($kost->kamar_mandi_dalam ?? false)
                <span class="bg-gray-200 px-2 py-1 rounded">KM Dalam</span>
            @endif
        </div>

        <!-- HARGA -->
        <p class="font-bold text-blue-600 mt-3 text-lg">
            Rp {{ number_format($kost->harga, 0, ',', '.') }}
            <span class="text-sm text-gray-400">/bulan</span>
        </p>

        <!-- BUTTON DETAIL -->
        <div
            class="mt-3 text-center bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">
            Lihat Detail
        </div>

    </div>

</a>

@empty

<p class="col-span-3 text-center text-gray-500">
    Tidak ada kost ditemukan.
</p>

@endforelse


<!-- PAGINATION -->
@if(method_exists($kosts, 'links'))
<div class="col-span-3 mt-6">
    {{ $kosts->links() }}
</div>
@endif