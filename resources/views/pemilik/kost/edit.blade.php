<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Iklan</title>
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
    Edit Iklan
</div>

<div class="max-w-7xl mx-auto p-6">

<form action="{{ route('pemilik.kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

<div class="grid grid-cols-3 gap-6">

<!-- LEFT -->
<div class="col-span-2 space-y-4">

<!-- FOTO -->
<div class="bg-white p-4 rounded-xl shadow">
    <h3 class="font-semibold mb-3">Foto Kost</h3>

    <!-- INPUT -->
    <input type="hidden" name="primary_index" id="primary_index">

    <input 
        type="file" 
        id="foto"
        accept="image/*"
        class="w-full border p-2 rounded"
    >

    <p class="text-sm text-gray-500 mt-2">
        Klik untuk menambah foto
    </p>

    <!-- PREVIEW FOTO LAMA + BARU -->
    <div id="preview-container" class="flex flex-wrap gap-3 mt-3">
        @foreach($kost->fotos as $foto)
            <div style="width:110px; height:110px; position:relative;">

                <img src="{{ asset('storage/' . $foto->foto) }}"
                     style="width:100%; height:100%; object-cover; ;">


                <!-- HAPUS -->
                <button type="button"
                        onclick="hapusFoto({{ $foto->id }}, this.parentElement)"
                        style="position:absolute; top: 3px; right: 3px; background: #ef4444; color: white; border:none; border:radius:50%; width:18px; height:18px; font-size:12px; cursor:pointer;">
                    ×
                </button>
            </div>
        @endforeach
    </div>
    <!-- TEMP FILE -->
    <div id="hidden-inputs" hidden></div>
    <input type="hidden" name="primary_index" id="primary_index">
</div>
<!-- HARGA -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Harga / Bulan</label>
    <input type="number" name="harga"
        value="{{ $kost->harga }}"
        class="w-full border p-2 rounded mt-2">
</div>

<!-- STATUS -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Status</label>
    <select name="status" class="w-full border p-2 rounded mt-2">
        <option value="Tersedia" {{ $kost->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="Habis" {{ $kost->status == 'Habis' ? 'selected' : '' }}>Habis</option>
    </select>
</div>

<!-- DESKRIPSI -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Deskripsi</label>
    <textarea name="deskripsi" class="w-full border p-2 rounded mt-2">{{ $kost->deskripsi }}</textarea>
</div>

<!-- ALAMAT -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Alamat</label>
    <input type="text" name="alamat"
        value="{{ $kost->alamat }}"
        class="w-full border p-2 rounded mt-2">
</div>

<!-- MAPS -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Google Maps</label>
    <input type="text" name="maps"
        value="{{ $kost->maps }}"
        class="w-full border p-2 mt-2 rounded">
</div>

</div>

<!-- RIGHT -->
<div class="space-y-4">

<!-- NAMA -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Nama Kost</label>
    <input type="text" name="nama_kost"
        value="{{ $kost->nama_kost }}"
        class="w-full border p-2 mt-2 rounded" required>
</div>

<!-- TIPE -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Tipe</label>
    <select name="tipe" class="w-full border p-2 rounded mt-2">
        <option value="kost" {{ $kost->tipe == 'kost' ? 'selected' : '' }}>Kost</option>
        <option value="kontrakan" {{ $kost->tipe == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
    </select>
</div>

<!-- GENDER -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Untuk</label>
    <select name="gender" class="w-full border p-2 rounded mt-2">
        <option value="putra" {{ $kost->gender == 'putra' ? 'selected' : '' }}>Putra</option>
        <option value="putri" {{ $kost->gender == 'putri' ? 'selected' : '' }}>Putri</option>
        <option value="campur" {{ $kost->gender == 'campur' ? 'selected' : '' }}>Campur</option>
    </select>
</div>

<!-- KAMAR MANDI -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Kamar Mandi</label>
    <select name="kamar_mandi" class="w-full border p-2 rounded mt-2">
        <option value="Dalam" {{ $kost->kamar_mandi == 'Dalam' ? 'selected' : '' }}>Dalam</option>
        <option value="Luar" {{ $kost->kamar_mandi == 'Luar' ? 'selected' : '' }}>Luar</option>
    </select>
</div>

<!-- FASILITAS -->
<div class="bg-white p-4 rounded-xl shadow">
    <label class="font-semibold">Fasilitas</label>

    <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
        @foreach($fasilitas as $item)
            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}"
                    {{ $kost->fasilitas->contains($item->id) ? 'checked' : '' }}>
                {{ $item->nama }}
            </label>
        @endforeach
    </div>
</div>

</div>

</div>

<!-- BUTTON -->
<div class="flex justify-end gap-4 mt-6">
    <button class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
        Update Iklan
    </button>

    <a href="{{ route('pemilik.dashboard') }}"
       class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
        Batal
    </a>
</div>

</form>
<script>
let selectedFiles = [];
let primaryIndex = -1;


document.getElementById('foto').addEventListener('change', function(e) {

    const file = e.target.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar');
        return;
    }

    const container = document.getElementById('preview-container');
    const hiddenInputs = document.getElementById('hidden-inputs');

    const index = selectedFiles.length;
    selectedFiles.push(file);

    // WRAPPER
    const div = document.createElement('div');
    div.style.width = "110px";
    div.style.height = "110px";
    div.style.position = "relative";
    div.style.flex = "0 0 auto";

    // IMAGE
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.width = "100%";
    img.style.height = "100%";
    img.style.objectFit = "cover";
    img.style.borderRadius = "8px";

    // BUTTON HAPUS
    const btnDelete = document.createElement('button');
    btnDelete.innerHTML = "×";
    btnDelete.style.position = "absolute";
    btnDelete.style.top = "3px";
    btnDelete.style.right = "3px";
    btnDelete.style.background = "#ef4444";
    btnDelete.style.color = "white";
    btnDelete.style.border = "none";
    btnDelete.style.borderRadius = "50%";
    btnDelete.style.width = "18px";
    btnDelete.style.height = "18px";
    btnDelete.style.fontSize = "12px";
    btnDelete.style.cursor = "pointer";

    // BUTTON UTAMA
    const btnPrimary = document.createElement('button');
    btnPrimary.style.position = "absolute";
    btnPrimary.style.bottom = "3px";
    btnPrimary.style.left = "3px";
    btnPrimary.style.background = "black";
    btnPrimary.style.color = "white";
    btnPrimary.style.fontSize = "10px";
    btnPrimary.style.padding = "2px 4px";
    btnPrimary.style.borderRadius = "4px";
    btnPrimary.style.border = "none";
    btnPrimary.style.cursor = "pointer";

    btnPrimary.onclick = function(e) {
        e.preventDefault();

        // 🔥 HAPUS SEMUA LABEL UTAMA (LAMA + BARU)
        document.querySelectorAll('.label-utama').forEach(el => el.remove());

        primaryIndex = index;
        document.getElementById('primary_index').value = index;

        const label = document.createElement('span');
        label.innerHTML = "UTAMA";
        label.className = "label-utama";
        label.style.position = "absolute";
        label.style.top = "3px";
        label.style.left = "3px";
        label.style.background = "green";
        label.style.color = "white";
        label.style.fontSize = "10px";
        label.style.padding = "2px 4px";
        label.style.borderRadius = "4px";

        div.appendChild(label);
    };

    // HIDDEN INPUT
    const dt = new DataTransfer();
    dt.items.add(file);

    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'foto[]';
    input.files = dt.files;

    hiddenInputs.appendChild(input);

    // DELETE ACTION
    btnDelete.onclick = function(e) {
        e.preventDefault();
        div.remove();
        input.remove();
        selectedFiles.splice(index, 1);
    };

    // APPEND
    div.appendChild(img);
    div.appendChild(btnDelete);
    div.appendChild(btnPrimary);

    container.appendChild(div);

    e.target.value = "";
});
</script>
<script>
function hapusFoto(id, el) {

    if (!confirm('Yakin mau hapus foto ini?')) return;

    fetch (`/pemilik/foto/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // reload biar langsung hilang
        } else {
            alert('Gagal hapus foto');
        }
    })
    .catch(err => {
        console.log(err);
        alert('Error server');
    });
}
</script>
</div>