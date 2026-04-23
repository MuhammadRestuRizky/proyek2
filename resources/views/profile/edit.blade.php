<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-6 rounded-xl shadow w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-4">Profil Saya</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/profile" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- FOTO -->
        <div class="text-center mb-4">
            <img id="preview"
                src="{{ auth()->user()->photo 
                    ? asset('storage/' . auth()->user()->photo) 
                    : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                class="w-24 h-24 rounded-full mx-auto object-cover mb-2 border">

            <input type="file" name="photo" accept="image/*"
                onchange="previewImage(event)">
        </div>

        <!-- NAMA -->
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name"
                value="{{ auth()->user()->name }}"
                class="w-full border p-2 rounded">
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"
                value="{{ auth()->user()->email }}"
                class="w-full border p-2 rounded">
        </div>

        <!-- NO WA -->
        <div class="mb-4">
            <label>No WhatsApp</label>
            <input type="text" name="no_wa"
                value="{{ auth()->user()->no_wa }}"
                class="w-full border p-2 rounded">
        </div>

        <button class="w-full bg-black text-white py-2 rounded-lg">
            Simpan Perubahan
        </button>
    </form>
    
 <!-- LOGOUT -->
        <form method="POST" action="/logout" class="mt-4">
            @csrf
            <button 
                onclick="return confirm('Yakin ingin logout?')"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg transition">
                Logout
            </button>
        </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>