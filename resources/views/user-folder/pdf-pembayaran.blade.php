<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style media="screen">
         
        body {
            font-family: 'Nunito', sans-serif;
        }
         
        table, th, td {
            border: 1px solid black;
        }
 
        table {
            border-collapse: collapse;
            margin: 80px auto;
        }
         
        th, td {
            padding: 6px 0;
        }
         
        th {
            text-align: left;
            padding-left: 4px;
            background-color: #F1F1F1;
        }
         
        td {
            padding-left: 4px;
            padding-right: 86px;
        }
  
    </style>
</head>
<body>
     
    <h3  class="fw-bold">Bukti Pembayaran</h3>
    <p class="mt-3">Tanggal Pemesanan: {{$data->created_at}}</p>
    <p class="mt-1">Nama Pemesan: {{$data->nama_pemesan}}</p> 
    <p class="mt-1">Alamat Pemesan: {{$data->alamat_pemesan}}</p> 
    <p class="mt-1">Kontak Pemesan: {{$data->kontak_pemesan}}</p> 
    <hr>
    <table>
        <caption>Detail Pesanan</caption>

        <tr class="mt-2">
            <th>Item / Desc</th>
            <th>Luas</th>
            <th>Harga</th>
        </tr>
        @foreach ($data->deskripsi_item as $item)
        <tr>
            <td>{{$item['nama_item']}}</td>
            <td>{{$item['luas_bangunan']}}</td>
            <td>Rp. {{$item['harga_item']}}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="2">Total</th>
            <td>Rp. {{$data->total_harga}}</td>
        </tr>
    </table>
     
</body>
</html>