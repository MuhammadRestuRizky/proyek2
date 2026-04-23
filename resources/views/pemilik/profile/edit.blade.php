<h2 class="text-xl font-bold mb-4 text-center">
    Profil Pemilik Kost
</h2>

<p class="text-sm text-gray-500 text-center mb-4">
    Kelola informasi akun pemilik Anda
</p>
<form method="POST" action="/logout">
    @csrf
    <button type="submit"
        class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
        Logout
    </button>
</form>