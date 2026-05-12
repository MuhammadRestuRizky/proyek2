<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:0;
            background:#f5f5f5;
        }

        .container{
            display:flex;
        }

        .sidebar{
            width:250px;
            background:black;
            color:white;
            min-height:100vh;
            padding:25px;
        }

        .sidebar h2{
            margin-bottom:30px;
        }

        .sidebar ul{
            list-style:none;
            padding:0;
        }

        .sidebar ul li{
            padding:15px 0;
            border-bottom:1px solid rgba(255,255,255,0.1);
            cursor:pointer;
        }

        .main{
            flex:1;
            padding:25px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:black;
            color:white;
            padding:15px 20px;
            border-radius:10px;
            margin-bottom:25px;
        }

        .admin{
            background:white;
            color:black;
            padding:8px 16px;
            border-radius:20px;
            font-size:14px;
            font-weight:bold;
        }

        h3{
            margin-top:25px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:10px;
            margin-top:15px;
            box-shadow:0 0 8px rgba(0,0,0,0.08);
        }

        .card-container{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
        }

        .btn-aktif{
            background:green;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:6px;
            cursor:pointer;
            margin-top:10px;
        }

        .btn-non{
            background:#ffd5d5;
            color:red;
            border:none;
            padding:10px 18px;
            border-radius:6px;
            cursor:pointer;
            margin-top:10px;
        }

        .aktif{
            background:#d4f8d4;
            color:green;
            padding:6px 12px;
            border-radius:6px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;
            margin-bottom:10px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="sidebar">
        <h2>KostKu</h2>

        <ul>
            <li>Kelola Akun Pemilik Properti</li>
            <li>Kelola Akun Pencari Kost</li>
            <li>Kelola Iklan</li>
        </ul>
    </div>

    <div class="main">

        <div class="header">
            <h2>Dashboard Admin</h2>
            <div class="admin">Admin</div>
        </div>

        <h3>Akun Menunggu Persetujuan</h3>

        <div class="card">
            <p><b>Nama :</b> Kost Putra Dekat Kampus</p>
            <p><b>Email :</b> nama@gmail.com</p>
            <p><b>No Telp :</b> 08564565645</p>
            <p><b>Password :</b> ********</p>

            <button class="btn-aktif">Aktifkan</button>
        </div>

        <h3>Akun Aktif</h3>

        <div class="card-container">

            <div class="card">
                <span class="aktif">AKTIF</span>
                <p><b>Nama :</b> Kost Putra Dekat Kampus</p>
                <p><b>Email :</b> nama@gmail.com</p>
                <p><b>No Telp :</b> 08564565645</p>
                <p><b>Password :</b> ********</p>

                <button class="btn-non">Non Aktifkan</button>
            </div>

            <div class="card">
                <span class="aktif">AKTIF</span>
                <p><b>Nama :</b> Kost Putra Dekat Kampus</p>
                <p><b>Email :</b> nama@gmail.com</p>
                <p><b>No Telp :</b> 08564565645</p>
                <p><b>Password :</b> ********</p>

                <button class="btn-non">Non Aktifkan</button>
            </div>

        </div>

    </div>

</div>

</body>
</html>