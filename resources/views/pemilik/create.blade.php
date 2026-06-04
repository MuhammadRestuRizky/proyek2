<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pasang Iklan</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<div class="bg-black text-white px-6 py-3 flex justify-between">
    <h1 class="font-bold">KostKu</h1>
    <span>{{ auth()->user()->name }}</span>
</div>

<!-- HEADER -->
<div class="bg-gray-500 text-white text-center py-3 text-xl font-semibold">
    Pasang Iklan
</div>

<div class="max-w-7xl mx-auto p-6">

<form action="{{ route('pemilik.kost.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

<div class="grid grid-cols-12 gap-6">

<!-- LEFT -->
<div class="col-span-9 space-y-5">

    <!-- FOTO -->
<div class="bg-white rounded-2xl border p-4">

    <h3 class="font-bold text-xl mb-4">
        Foto Kost / Kontrakan :
    </h3>

    <input type="hidden" name="primary_index" id="primary_index">

    <input
        type="file"
        id="foto"
        accept="image/*"
        class="hidden"
    >

    <div class="grid grid-cols-12 gap-4">

        <!-- FOTO BESAR -->
        <div class="col-span-9">

            <div id="main-preview"
                 class="w-full h-[420px] rounded-2xl bg-gray-200 overflow-hidden flex items-center justify-center">

                <span class="text-gray-400">
                    Belum ada foto
                </span>

            </div>

        </div>

        <!-- THUMBNAIL -->
        <div class="col-span-3">

            <div id="preview-container"
                 class="space-y-3">
            </div>

            <!-- BUTTON TAMBAH -->
            <button type="button"
                    onclick="document.getElementById('foto').click()"
                    class="w-full h-32 border-2 border-dashed rounded-2xl flex items-center justify-center text-6xl text-gray-400 hover:bg-gray-100 transition">

                +

            </button>

        </div>

    </div>

    <div id="hidden-inputs"></div>

</div>

    <!-- HARGA -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Harga per Bulan</label>
        <input type="number" name="harga" class="w-full border p-2 rounded mt-2">
    </div>

    <!-- STATUS -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Status</label>
        <select name="status" class="w-full border p-2 rounded mt-2">
            <option value="Tersedia">Tersedia</option>
            <option value="Habis">Habis</option>
        </select>
    </div>

    <!-- DESKRIPSI -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border p-2 rounded mt-2"></textarea>
    </div>

    <!-- ALAMAT -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Alamat</label>
        <input type="text" name="alamat" class="w-full border p-2 rounded mt-2">
    </div>

    <!-- GOOGLE MAPS -->
 <!-- GOOGLE MAPS -->
<div class="bg-white p-4 rounded-xl shadow">

    <label class="font-semibold">
        Google Maps (Embed Code)
    </label>

    <textarea
        name="maps"
        id="maps"
        rows="5"
        class="w-full border p-2 mt-2 rounded"
        placeholder="Paste kode iframe Google Maps di sini"></textarea>

    <!-- PREVIEW -->
    <div
        id="mapPreviewContainer"
        class="hidden mt-3 w-full h-60 rounded overflow-hidden border">
    </div>

</div>

</div>

<!-- RIGHT -->
<div class="col-span-3">

    <div class="space-y-4 sticky top-5">

        <!-- NAMA KOST -->
        <div class="bg-white border rounded-1xl p-2 shadow-sm">

            <h3 class="font-bold text-lg mb-1">
                Nama Kost / Kontrakan
            </h3>

            <input type="text"
                   name="nama_kost"
                   placeholder="Masukkan nama kost"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black"
                   required>

        </div>


        <!-- TIPE PROPERTI -->
        <div class="bg-white border rounded-1xl p-2 shadow-sm">

            <h3 class="font-bold text-lg mb-1">
                Tipe Properti
            </h3>

            <div class="space-y-3 text-sm">

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio"
                           name="tipe"
                           value="kost"
                           checked>

                    Kost
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio"
                           name="tipe"
                           value="kontrakan">

                    Kontrakan
                </label>

            </div>

        </div>


        <!-- UNTUK -->
        <div class="bg-white border rounded-1xl p-2 shadow-sm">

            <h3 class="font-bold text-lg mb-1">
                Untuk
            </h3>

            <div class="space-y-3 text-sm">

                <label class="flex items-center gap-3">
                    <input type="radio"
                           name="gender"
                           value="putra">

                    Putra
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio"
                           name="gender"
                           value="putri">

                    Putri
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio"
                           name="gender"
                           value="campur">

                    Campur
                </label>

            </div>

        </div>


        <!-- KAMAR MANDI -->
        <div class="bg-white border rounded-1xl p-3 shadow-sm">

            <h3 class="font-bold text-lg mb-1">
                Kamar Mandi
            </h3>

            <div class="space-y-3 text-sm">

                <label class="flex items-center gap-3">
                    <input type="radio"
                           name="kamar_mandi"
                           value="Dalam">

                    Dalam
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio"
                           name="kamar_mandi"
                           value="Luar">

                    Luar
                </label>

            </div>

        </div>


        <!-- FASILITAS -->
<div class="bg-white border rounded-1xl p-3 shadow-sm">

    <h3 class="font-bold text-lg mb-1">
        Fasilitas
    </h3>

    <div class="space-y-3 text-sm">

        @foreach($fasilitas as $item)

        <label class="flex items-center gap-3">

            <input
                type="checkbox"
                name="fasilitas[]"
                value="{{ $item->id }}">

            {{ $item->nama }}

        </label>

        @endforeach

    </div>

</div>


        <!-- BUTTON -->
        <div class="flex gap-3 pt-2">

            <button type="submit"
                    class="flex-1 bg-black text-white py-3 rounded-xl font-medium hover:opacity-90 transition">

                Terapkan

            </button>

            <a href="/pemilik/dashboard"
               class="flex-1 bg-red-600 text-white py-3 rounded-xl font-medium text-center hover:bg-red-700 transition">

                Hapus

            </a>

        </div>

    </div>

</div>

<script>
let selectedFiles = [];

document.getElementById('foto').addEventListener('change', function(e) {

    let file = e.target.files[0];
    if (!file) return;

    let container = document.getElementById('preview-container');
    let hiddenInputs = document.getElementById('hidden-inputs');
    let mainPreview = document.getElementById('main-preview');

    let imageUrl = URL.createObjectURL(file);

    // FOTO UTAMA
    if(selectedFiles.length === 0){
        mainPreview.innerHTML = `
            <img src="${imageUrl}"
                 class="w-full h-full object-cover">
        `;
    }

    // THUMBNAIL
let thumb = document.createElement('div');

thumb.className =
    'relative w-full h-28 rounded-xl overflow-hidden border cursor-pointer';

thumb.innerHTML = `
    <img src="${imageUrl}"
         class="w-full h-full object-cover">

    <button type="button"
        class="absolute top-1 right-1 bg-red-600 text-white w-6 h-6 rounded-full text-sm font-bold">
        ✕
    </button>
`;

thumb.onclick = function() {
    mainPreview.innerHTML = `
        <img src="${imageUrl}"
             class="w-full h-full object-cover">
    `;
};
    container.appendChild(thumb);

    // SIMPAN FILE
    let dt = new DataTransfer();
    dt.items.add(file);

    let input = document.createElement('input');
    input.type = 'file';
    input.name = 'foto[]';
    input.files = dt.files;

    hiddenInputs.appendChild(input);
    thumb.querySelector('button').onclick = function(event){

    event.stopPropagation();

    thumb.remove();
    input.remove();

    selectedFiles = selectedFiles.filter(
        f => f !== file
    );

    if(selectedFiles.length === 0){
        mainPreview.innerHTML = `
            <span class="text-gray-400">
                Belum ada foto
            </span>
        `;
    }
};

    selectedFiles.push(file);

    e.target.value = "";
});
</script>


<script>

const mapsInput = document.getElementById('maps');
const mapPreviewContainer = document.getElementById('mapPreviewContainer');

mapsInput.addEventListener('input', function () {

    let iframeCode = this.value.trim();

    if (iframeCode.includes('<iframe')) {

        iframeCode = iframeCode
            .replace(/width="[^"]*"/g, 'width="100%"')
            .replace(/height="[^"]*"/g, 'height="100%"');

        mapPreviewContainer.innerHTML = iframeCode;

        mapPreviewContainer.classList.remove('hidden');

    } else {

        mapPreviewContainer.innerHTML = '';

        mapPreviewContainer.classList.add('hidden');
    }

});

</script>
</body>
</html>