<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f3f3f3;
        }

        .container{
            display:flex;
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

        .menu .icon{
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

        hr{
            margin:40px 0;
            border:none;
            border-top:4px solid #ddd;
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
            margin-bottom:25px;
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
            font-size:22px;
            margin-bottom:10px;
            font-weight:bold;
        }

        .password{
            color:#bdbdbd;
            letter-spacing:5px;
        }

        /* ================= BUTTON ================= */

        .btn-aktif{
            width:100%;
            background:#14c94e;
            color:black;
            border:none;
            padding:10px;
            border-radius:8px;
            font-weight:bold;
            cursor:pointer;
            margin-bottom:8px;
            transition:0.2s;
        }

        .btn-aktif:hover{
            background:#0ea53e;
            color:white;
        }

        .btn-tolak{
            width:100%;
            background:#ffd9d9;
            color:red;
            border:none;
            padding:10px;
            border-radius:8px;
            font-weight:bold;
            cursor:pointer;
            transition:0.2s;
        }

        .btn-tolak:hover{
            background:red;
            color:white;
        }

        .btn-non{
            margin-top:15px;
            background:#ffd9d9;
            color:red;
            border:none;
            padding:12px 18px;
            border-radius:10px;
            cursor:pointer;
            font-weight:bold;
        }

        /* ================= FILE ================= */

        .file{
            margin-top:12px;
        }

        .file a{
            display:block;
            width:100%;
            background:#e1e1e1;
            padding:12px;
            border-radius:10px;
            text-align:center;
            text-decoration:none;
            color:black;
            font-weight:bold;
            transition:0.2s;
        }

        .file a:hover{
            background:black;
            color:white;
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

        /* ================= GRID ================= */

        .grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:25px;
        }

        form{
            width:100%;
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

            <a href="#">
                <div class="icon">👤</div>
                Kelola Akun Pemilik Properti
            </a>

            <a href="#">
                <div class="icon">👤</div>
                Kelola Akun Pencari Kost
            </a>

            <a href="#">
                <div class="icon">Ad</div>
                Kelola Iklan
            </a>

        </div>

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

            <!-- TITLE -->
            <div class="title">
                Akun Menunggu Persetujuan
            </div>

            <!-- DATA PENDING -->
            @foreach($pendingUsers as $user)

            <div class="card">

                <!-- PROFILE -->
                <div class="profile">

                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

                    <!-- AKTIFKAN -->
                    <form action="{{ route('admin.aktifkan', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-aktif">
                            AKTIFKAN
                        </button>
                    </form>

                    <!-- TOLAK -->
                    <form action="{{ route('admin.tolak', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-tolak">
                            Tolak
                        </button>
                    </form>

                </div>

                <!-- INFO -->
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

                    <!-- FILE KTP -->
                    <div class="file">
                        <a href="{{ asset('storage/' . $user->ktp) }}" target="_blank">
                            Lihat Berkas Foto Selfie KTP
                        </a>
                    </div>

                    <!-- FILE DOKUMEN -->
                    <div class="file">
                        <a href="{{ asset('storage/' . $user->dokumen) }}" target="_blank">
                            Lihat Berkas Kepemilikan Kost/Kontrakan
                        </a>
                    </div>

                </div>

            </div>

            @endforeach

            <hr>

            <!-- TITLE -->
            <div class="title">
                Akun Aktif
            </div>

            <!-- GRID -->
            <div class="grid">

                @foreach($activeUsers as $user)

                <div class="card">

                    <div class="profile">

                        <div class="aktif-label">
                            AKTIF
                        </div>

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

                        <!-- NON AKTIFKAN -->
                        <form action="{{ route('admin.tolak', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-non">
                                Non Aktifkan
                            </button>
                        </form>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

</body>
</html>