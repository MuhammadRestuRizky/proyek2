<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pencarian Kost</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.range-slider {
    position: absolute;
    width: 100%;
    height: 8px;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
}

/* BULAT HANDLE */
.range-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    pointer-events: all;
    width: 18px;
    height: 18px;
    background: white;
    border: 3px solid black;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.2s;
}

.range-slider::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

/* FIREFOX */
.range-slider::-moz-range-thumb {
    pointer-events: all;
    width: 18px;
    height: 18px;
    background: white;
    border: 3px solid black;
    border-radius: 50%;
    cursor: pointer;
}
</style>

</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-black text-white px-6 py-4 flex justify-between items-center">

    <h1 class="text-2xl font-bold">KostKu</h1>

    <div class="flex gap-6 text-sm">
        <a href="#" class="flex items-center gap-1">📋 Riwayat</a>
        <a href="/kost" class="bg-gray-700 px-3 py-1 rounded flex items-center gap-1">🔍 Pencarian</a>
        <a href="/" class="flex items-center gap-1">🏠 Beranda</a>
    </div>

    <div class="flex items-center gap-2">
        <span>{{ auth()->user()->name }}</span>
        <img 
        src="{{ auth()->user()->photo 
            ? asset('storage/' . auth()->user()->photo) 
            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
        class="w-8 h-8 rounded-full">
    </div>

</nav>


<!-- SEARCH BAR -->
<div class="bg-gray-700 px-6 py-6">

    <div class="bg-white rounded-xl shadow flex gap-3 p-3 max-w-6xl mx-auto">

        <input id="q" type="text"
        placeholder="Cari lokasi, nama kost..."
        class="flex-1 border rounded-lg px-3 py-2">

        <select id="gender" class="border rounded-lg px-3 py-2">
            <option value="">Semua Tipe</option>
            <option value="putra">Putra</option>
            <option value="putri">Putri</option>
            <option value="campur">Campur</option>
        </select>

        <button onclick="loadData()" class="bg-black text-white px-5 rounded-lg">
            Cari
        </button>

    </div>

</div>


<!-- CONTENT -->
<div class="max-w-6xl mx-auto flex gap-6 mt-6 px-4">

<!-- SIDEBAR -->
<div class="w-64 bg-white rounded-xl p-5 shadow">

    <h3 class="font-semibold mb-4">Filter Pencarian</h3>

    <!-- TIPE -->
    <p class="font-medium mb-2">Tipe Properti</p>
    <div class="space-y-1 text-sm mb-4">
        <label><input type="radio" name="tipe" value="" checked> Semua</label><br>
        <label><input type="radio" name="tipe" value="kost"> Kost</label><br>
        <label><input type="radio" name="tipe" value="kontrakan"> Kontrakan</label>
    </div>

    <!-- GENDER -->
    <p class="font-medium mb-2">Untuk</p>
    <div class="space-y-1 text-sm mb-4">
        <label><input type="radio" name="gender" value="" checked> Semua</label><br>
        <label><input type="radio" name="gender" value="putra"> Putra</label><br>
        <label><input type="radio" name="gender" value="putri"> Putri</label><br>
        <label><input type="radio" name="gender" value="campur"> Campur</label>
    </div>

      <!-- SLIDER -->
        <div class="mb-6">
            <h4 class="font-semibold mb-3">Rentang Harga (per bulan)</h4>

            <!-- LABEL -->
            <div class="flex justify-between text-xs text-gray-500 mb-2">
                <span id="minLabel">Rp 0rb</span>
                <span id="maxLabel">Rp 10.0jt</span>
            </div>

            <!-- WRAPPER -->
            <div class="relative h-2 bg-gray-300 rounded-full">

                <!-- TRACK AKTIF -->
                <div id="rangeTrack"
                    class="absolute h-2 bg-black rounded-full"
                    style="left:0%; right:0%;">
                </div>

                <!-- MIN -->
                <input type="range" id="minRange"
                    min="0" max="10000000" step="100000"
                    class="range-slider">

                <!-- MAX -->
                <input type="range" id="maxRange"
                    min="0" max="10000000" step="100000"
                    class="range-slider">

            </div>
        </div>

    <!-- FASILITAS -->
    <p class="font-medium mb-2">Fasilitas</p>
    <div class="space-y-1 text-sm mb-4">
        <label><input type="checkbox" value="wifi"> WiFi</label><br>
        <label><input type="checkbox" value="ac"> AC</label><br>
        <label><input type="checkbox" value="kamar_mandi_dalam"> Kamar Mandi Dalam</label><br>
        <label><input type="checkbox" value="parkir_motor"> Parkir Motor</label><br>
        <label><input type="checkbox" value="parkir_mobil"> Parkir Mobil</label><br>
        <label><input type="checkbox" value="dapur"> Dapur</label><br>
        <label><input type="checkbox" value="laundry"> Laundry</label><br>
        <label><input type="checkbox" value="security"> Security 24 Jam</label>
    </div>

  <!-- BUTTON -->
    <div class="flex gap-2">
        <button onclick="loadData()"
            class="flex-1 bg-black text-white py-2 rounded-lg">
            Terapkan
        </button>

        <button onclick="resetFilter()"
            class="flex-1 border py-2 rounded-lg">
            Reset
        </button>
    </div>
</div>


<!-- RESULT -->
<div class="flex-1">

    <h3 class="text-xl font-semibold">
        {{ $kosts->count() }} Properti Ditemukan
    </h3>

    <p class="text-gray-500 text-sm mb-5">
        Hasil pencarian untuk semua properti
    </p>

    <div id="result" class="grid md:grid-cols-3 gap-6">
        @include('kost.partials.list')
    </div>

</div>

</div>


<!-- JS -->
<script>

// =======================
// LOAD DATA (AJAX FILTER)
// =======================
function loadData(url = null) {

    let q = document.getElementById('q').value;

    let gender = document.querySelector('input[name="gender"]:checked')?.value || '';
    let tipe = document.querySelector('input[name="tipe"]:checked')?.value || '';

    let min = document.getElementById('minRange').value;
    let max = document.getElementById('maxRange').value;

    // fasilitas
    let fasilitas = [];
    document.querySelectorAll('input[type="checkbox"]:checked')
        .forEach(el => fasilitas.push(el.value));

    let endpoint = url ?? `/kost?q=${q}&gender=${gender}&tipe=${tipe}&min_harga=${min}&max_harga=${max}&fasilitas=${fasilitas.join(',')}`;

    fetch(endpoint, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('result').innerHTML = data;
    });
}


// =======================
// RESET FILTER
// =======================
function resetFilter(){

    // kosongkan search
    document.getElementById('q').value = '';

    // reset radio
    document.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);

    // reset checkbox
    document.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);

    // set default radio
    document.querySelector('input[name="gender"][value=""]').checked = true;
    document.querySelector('input[name="tipe"][value=""]').checked = true;

    // reset slider
    document.getElementById('minRange').value = 0;
    document.getElementById('maxRange').value = 10000000;

    updateSlider();

    // reload data
    loadData();
}


// =======================
// SLIDER HARGA
// =======================
const minRange = document.getElementById('minRange');
const maxRange = document.getElementById('maxRange');
const track = document.getElementById('rangeTrack');

const minLabel = document.getElementById('minLabel');
const maxLabel = document.getElementById('maxLabel');

const minGap = 0;
const maxValue = 10000000;

function formatRupiah(n){
    if(n >= 1000000){
        return 'Rp ' + (n/1000000).toFixed(1) + 'jt';
    }
    return 'Rp ' + (n/1000) + 'rb';
}

function updateSlider(){

    let min = parseInt(minRange.value);
    let max = parseInt(maxRange.value);

    if(min > max){
        minRange.value = max;
        min = max;
    }

    // UPDATE LABEL
    minLabel.innerText = formatRupiah(min);
    maxLabel.innerText = formatRupiah(max);

    // UPDATE TRACK HITAM
    let percentMin = (min / maxValue) * 100;
    let percentMax = (max / maxValue) * 100;

    track.style.left = percentMin + "%";
    track.style.right = (100 - percentMax) + "%";
}

minRange.addEventListener('input', updateSlider);
maxRange.addEventListener('input', updateSlider);

updateSlider();


// =======================
// PAGINATION AJAX
// =======================
document.addEventListener("click", function(e) {

    let link = e.target.closest(".pagination a");

    if (link) {
        e.preventDefault();
        loadData(link.href);
    }

});

</script>
</body>
</html>