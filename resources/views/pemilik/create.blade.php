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

<div class="grid grid-cols-3 gap-6">

<!-- LEFT -->
<div class="col-span-2 space-y-4">

<!-- FOTO -->
<div class="bg-white p-4 rounded-xl shadow">

    <h3 class="font-semibold mb-3">Foto Kost</h3>

    <!-- INPUT PILIH FOTO -->
    <input type="hidden" name="primary_index" id="primary_index">

    <input 
        type="file" 
        id="foto" 
        accept="image/*"
        class="w-full border p-2 rounded"
    >

    <!-- INFO -->
    <p class="text-sm text-gray-500 mt-2">
        Klik berkali-kali untuk menambah foto
    </p>

    <!-- PREVIEW -->
    <div id="preview-container" class="grid grid-cols-3 gap-2 mt-3"></div>

    <!-- TEMPAT SIMPAN FILE -->
    <div id="hidden-inputs"></div>

</div>

    <!-- HARGA -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Harga / Bulan</label>
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
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Google Maps (Embed Link)</label>
        <input type="text" name="maps" id="maps" class="w-full border p-2 mt-2 rounded"
               placeholder="Paste link embed Google Maps">

        <!-- PREVIEW MAP -->
        <iframe id="mapPreview"
                class="w-full h-60 mt-3 rounded hidden"
                frameborder="0">
        </iframe>
    </div>

</div>

<!-- RIGHT -->
<div class="space-y-4">

    <!-- NAMA -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Nama Kost</label>
        <input type="text" name="nama_kost" class="w-full border p-2 mt-2 rounded" required>
    </div>

    <!-- TIPE -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Tipe</label>
        <select name="tipe" class="w-full border p-2 rounded mt-2">
            <option value="kost">Kost</option>
            <option value="kontrakan">Kontrakan</option>
        </select>
    </div>

    <!-- GENDER -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Untuk</label>
        <select name="gender" class="w-full border p-2 rounded mt-2">
            <option value="putra">Putra</option>
            <option value="putri">Putri</option>
            <option value="campur">Campur</option>
        </select>
    </div>

    <!-- KAMAR MANDI -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Kamar Mandi</label>
        <select name="kamar_mandi" class="w-full border p-2 rounded mt-2">
            <option value="Dalam">Dalam</option>
            <option value="Luar">Luar</option>
        </select>
    </div>

    <!-- FASILITAS -->
    <div class="bg-white p-4 rounded-xl shadow">
        <label class="font-semibold">Fasilitas</label>

        <div class="grid grid-cols-2 gap-2 mt-2 text-sm">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="1"> WiFi
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="2"> AC
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="3"> KM Dalam
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="4"> Parkir
            </label>

        </div>
    </div>

</div>

</div>

<!-- BUTTON -->
<div class="flex justify-end gap-4 mt-6">
    <button class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
        Pasang 
    </button>

    <a href="/pemilik/dashboard"
       class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
        Hapus
    </a>
</div>

</form>

</div>

<script>
let selectedFiles = [];
let primaryIndex = 0;

document.getElementById('foto').addEventListener('change', function(e) {

    let file = e.target.files[0];
    if (!file) return;

    let container = document.getElementById('preview-container');
    let hiddenInputs = document.getElementById('hidden-inputs');

    let index = selectedFiles.length;
    selectedFiles.push(file);

    let div = document.createElement('div');
    div.classList.add('relative');

    let img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.classList.add('w-full', 'h-32', 'object-cover', 'rounded');

    // tombol utama
    let btnPrimary = document.createElement('button');
    btnPrimary.innerHTML = "Utama";
    btnPrimary.classList.add(
        'absolute','bottom-1','left-1',
        'bg-black','text-white','text-xs','px-2','rounded'
    );

    btnPrimary.onclick = function(e) {
        e.preventDefault();

        document.getElementById('primary_index').value = index;

        document.querySelectorAll('.primary-label').forEach(el => el.remove());

        let label = document.createElement('span');
        label.innerHTML = "UTAMA";
        label.classList.add(
            'primary-label',
            'absolute','top-1','left-1',
            'bg-green-600','text-white','text-xs','px-2','rounded'
        );

        div.appendChild(label);
    };

    // tombol hapus
    let btnDelete = document.createElement('button');
    btnDelete.innerHTML = "×";
    btnDelete.classList.add(
        'absolute','top-1','right-1',
        'bg-red-600','text-white',
        'rounded-full','w-6','h-6'
    );

    btnDelete.onclick = function(e) {
        e.preventDefault();
        div.remove();
        input.remove();
    };

    div.appendChild(img);
    div.appendChild(btnPrimary);
    div.appendChild(btnDelete);

    container.appendChild(div);

    // hidden input
    let dt = new DataTransfer();
    dt.items.add(file);

    let input = document.createElement('input');
    input.type = 'file';
    input.name = 'foto[]';
    input.files = dt.files;

    hiddenInputs.appendChild(input);

    // reset input
    e.target.value = "";
});
</script>


<!-- SCRIPT MAP PREVIEW -->
<script>
const mapsInput = document.getElementById('maps');
const mapPreview = document.getElementById('mapPreview');

mapsInput.addEventListener('input', function () {
    if (this.value.includes("google.com")) {
        mapPreview.src = this.value;
        mapPreview.classList.remove('hidden');
    }
});
</script>

</body>
</html>