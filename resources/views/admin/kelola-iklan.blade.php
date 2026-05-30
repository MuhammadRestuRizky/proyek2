<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Iklan</title>

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

        .container{
            display:flex;
        }

        /* SIDEBAR */
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

        .tanggal-title{
            font-size:42px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .tanggal-section{
            margin-bottom:60px;
        }

        .iklan-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .logo{
            padding:22px;
            font-size:30px;
            font-weight:bold;
            border-bottom:1px solid rgba(255,255,255,.1);
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
            font-weight:bold;
        }

        .menu a:hover{
            background:white;
            color:black;
        }

        .menu .active{
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

        /* MAIN */
        .main{
            margin-left:260px;
            width:calc(100% - 260px);
        }

        /* HEADER */
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
        }

        .admin-circle{
            width:38px;
            height:38px;
            border-radius:50%;
            background:white;
        }

        /* CONTENT */
        .content{
            padding:30px;
        }

        .title{
            font-size:40px;
            font-weight:bold;
            margin-bottom:25px;
        }

        /* GRID IKLAN */
        .iklan-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .iklan-card{
            background:white;
            border-radius:18px;
            overflow:hidden;
            border:1px solid #ddd;
            box-shadow:0 0 10px rgba(0,0,0,.08);
        }

        .iklan-card img{
            width:100%;
            height:180px;
            object-fit:cover;
        }

        .iklan-content{
            padding:15px;
        }

        .iklan-content h3{
            font-size:18px;
            margin-bottom:8px;
        }

        .alamat{
            color:#666;
            font-size:14px;
            margin-bottom:12px;
        }

        .harga{
            font-size:28px;
            font-weight:bold;
            margin-bottom:15px;
        }

        .harga span{
            font-size:14px;
            color:#888;
        }

        .btn-hapus{
            width:100%;
            border:none;
            background:#ffd7d7;
            color:red;
            padding:10px;
            border-radius:10px;
            cursor:pointer;
            font-weight:bold;
        }

        .btn-hapus:hover{
            background:red;
            color:white;
        }

    </style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            KostKu
        </div>

        <div class="menu">

            <a href="{{ route('admin.kelola.iklan') }}" class="active">
                <div class="icon">Ad</div>
                Kelola Iklan
            </a>

            <a href="{{ route('admin.dashboard') }}">
                <div class="icon">👤</div>
                Kelola Akun Pemilik Properti
            </a>

            <a href="{{ route('admin.customer') }}">
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
                Kelola Iklan
            </div>

            @if(session('success'))
                <div style="
                    background:#d4edda;
                    color:#155724;
                    padding:15px;
                    border-radius:10px;
                    margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($iklanPerTanggal as $tanggal => $daftarIklan)

<div class="tanggal-section">

    <div class="tanggal-title">

        Iklan Tanggal
        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}

    </div>

    <div class="iklan-grid">

        @foreach($daftarIklan as $kost)

        <div class="iklan-card">

            @php
                $foto = $kost->fotos->first();
            @endphp

            <img
                src="{{ $foto ? asset('storage/'.$foto->foto) : asset('images/no-image.png') }}"
                alt="foto">

            <div class="iklan-content">

                <h3>
                    {{ $kost->nama_kost }}
                </h3>

                <div class="alamat">
                    {{ $kost->alamat }}
                </div>

                <div class="harga">
                    Rp {{ number_format($kost->harga,0,',','.') }}
                    <span>/bulan</span>
                </div>

                <form
                    action="{{ route('admin.hapus.iklan',$kost->id) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn-hapus"
                        onclick="return confirm('Yakin ingin menghapus iklan ini?')">

                        Hapus Iklan

                    </button>

                </form>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endforeach

        </div>

    </div>

</div>

</body>
</html>