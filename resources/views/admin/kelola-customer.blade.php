<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Akun Customer</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f3f3f3;
}

/* ================= SIDEBAR ================= */

.sidebar{
    width:260px;
    min-height:100vh;
    background:#0b0b0f;
    color:white;
    position:fixed;
    left:0;
    top:0;
    display:flex;
    flex-direction:column;
}

.logo{
    padding:22px;
    font-size:30px;
    font-weight:bold;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.menu{
    margin-top:20px;
}

/* LOGOUT PALING BAWAH */
.logout-menu{
    margin-top:auto;
    width:100%;
    background:none;
    border:none;
    color:white;
    display:flex;
    align-items:center;
    gap:14px;
    padding:18px 20px;
    cursor:pointer;
    font-size:17px;
    font-weight:bold;
    transition:.2s;
    text-align:left;
}

.logout-menu:hover{
    background:white;
    color:black;
}

.logout-icon{
    width:48px;
    height:48px;
    border:2px solid white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    font-weight:bold;
}

.logout-menu:hover .logout-icon{
    border-color:black;
}

.menu a{
    display:flex;
    align-items:center;
    gap:14px;
    color:white;
    text-decoration:none;
    padding:18px 20px;
    transition:0.2s;
    font-weight:bold;
    font-size:17px;
}

.menu a:hover{
    background:white;
    color:black;
}

.menu a.active{
    background:white;
    color:black;
}

.icon{
    width:48px;
    height:48px;
    border-radius:50%;
    background:white;
    color:black;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:bold;
}

/* ================= MAIN ================= */

.main{
    margin-left:260px;
    width:calc(100% - 260px);
}

/* ================= HEADER ================= */

.header{
    height:75px;
    background:black;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 35px;
    color:white;
}

.header h2{
    color:red;
    font-size:36px;
    font-weight:bold;
}

.admin-box{
    display:flex;
    align-items:center;
    gap:15px;
    font-size:18px;
}

.admin-circle{
    width:38px;
    height:38px;
    border-radius:50%;
    background:white;
}

/* ================= CONTENT ================= */

.content{
    padding:30px;
}

.title{
    font-size:42px;
    font-weight:bold;
    margin-bottom:25px;
}

/* ================= GRID ================= */

.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:25px;
}

/* ================= CARD ================= */

.card{
    background:white;
    border-radius:18px;
    padding:20px;
    display:flex;
    gap:20px;
    box-shadow:0 0 10px rgba(0,0,0,0.08);
    border:1px solid #ddd;
}

.profile{
    width:130px;
    text-align:center;
}

.profile img{
    width:75px;
    margin-bottom:12px;
}

.info{
    flex:1;
}

.info p{
    font-size:18px;
    margin-bottom:10px;
    font-weight:bold;
}

.password{
    color:#bdbdbd;
    letter-spacing:5px;
}

/* ================= LABEL ================= */

.aktif-label{
    background:#d8f5dd;
    color:green;
    display:inline-block;
    padding:8px 16px;
    border-radius:8px;
    font-size:14px;
    font-weight:bold;
    margin-bottom:12px;
}

.nonaktif-label{
    background:#ffd9d9;
    color:red;
    display:inline-block;
    padding:8px 16px;
    border-radius:8px;
    font-size:14px;
    font-weight:bold;
    margin-bottom:12px;
}

/* ================= BUTTON ================= */

.btn-hapus{
    margin-top:15px;
    background:#ffd9d9;
    color:red;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

.btn-hapus:hover{
    background:red;
    color:white;
}

.btn-aktif{
    margin-top:15px;
    background:#d8f5dd;
    color:green;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

.btn-aktif:hover{
    background:green;
    color:white;
}

form{
    display:inline;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        KostKu
    </div>

    <div class="menu">

        <a href="{{ route('admin.kelola.iklan') }}">
            <div class="icon">Ad</div>
            Kelola Iklan
        </a>

        <a href="{{ route('admin.dashboard') }}">
            <div class="icon">👤</div>
            Kelola Akun Pemilik Properti
        </a>

        <a href="{{ route('admin.customer') }}" class="active">
            <div class="icon">👤</div>
            Kelola Akun Pencari Kost
        </a>

    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="logout-menu">

            <div class="logout-icon">
                ⇨
            </div>

            Logout

        </button>

    </form>

</div>

<!-- MAIN -->
<div class="main">

    <!-- HEADER -->
    <div class="header">

        <div></div>

        <h2>Dashboard Admin</h2>

        <div class="admin-box">
            <span>Admin</span>
            <div class="admin-circle"></div>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="title">
            Akun Pencari Kost
        </div>

        <div class="grid">

            @foreach($customers as $user)

            <div class="card">

                <div class="profile">

                    @if($user->status_akun == 'aktif')
                        <div class="aktif-label">
                            AKTIF
                        </div>
                    @else
                        <div class="nonaktif-label">
                            NON AKTIF
                        </div>
                    @endif

                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

                </div>

                <div class="info">

                    <p><b>Nama :</b> {{ $user->name }}</p>

                    <p><b>Email :</b> {{ $user->email }}</p>

                    <p><b>No Telp :</b> {{ $user->no_wa }}</p>

                    <p>
                        <b>Password :</b>
                        <span class="password">
                            ********************
                        </span>
                    </p>

                    @if($user->status_akun == 'aktif')

                    <form action="{{ route('admin.customer.nonaktif',$user->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn-hapus">
                            Non Aktifkan
                        </button>
                    </form>

                    @else

                    <form action="{{ route('admin.customer.aktif',$user->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn-aktif">
                            Aktifkan
                        </button>
                    </form>

                    @endif

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

</body>
</html>