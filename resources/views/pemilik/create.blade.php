<x-app-layout>
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Kost Baru
    </h1>

    <form action="/pemilik/kost/store" 
          method="POST" 
          enctype="multipart/form-data"
          class="bg-white shadow rounded p-6 space-y-4">

        @csrf

        <div>
            <label>Nama Kost</label>
            <input type="text" name="nama_kost"
                class="w-full border rounded p-2" required>
        </div>

        <div>
            <label>Alamat</label>
            <textarea name="alamat"
                class="w-full border rounded p-2" required></textarea>
        </div>

        <div>
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border rounded p-2"></textarea>
        </div>

        <div>
            <label>Harga per Bulan</label>
            <input type="number" name="harga"
                class="w-full border rounded p-2" required>
        </div>

        <div>
            <label>Tipe</label>
            <select name="tipe" class="w-full border rounded p-2">
                <option value="Putra">Putra</option>
                <option value="Putri">Putri</option>
                <option value="Campur">Campur</option>
            </select>
        </div>

        <div>
            <label>Kamar Mandi</label>
            <select name="kamar_mandi" class="w-full border rounded p-2">
                <option value="Dalam">Dalam</option>
                <option value="Luar">Luar</option>
            </select>
        </div>

        <div>
            <label>Foto Kost</label>
            <input type="file" name="foto"
                class="w-full border rounded p-2">
        </div>

        <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>
</div>
</x-app-layout>
