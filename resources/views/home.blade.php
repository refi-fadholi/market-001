<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Penjualan</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-success-subtle">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

      <nav class="navbar navbar-expand-lg bg-success">
        <div class="container">
            <a class="navbar-brand text-white" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Penjualan</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-white" href="/pembayaran">Pembayaran</a>
                      </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
    <div class="position-relative py-3 px-4" style="text-align: center; font-weight: bold; font-size: 20px;">Tabel Penjualan</div>

    <div class="row">

        <div class="col-2"></div>
        <div class="col-8 p-2">
            <table class="table" id="penjualan-table">
                <thead>
                  <tr>
                    <th class="bg-success bg-opacity-75 text-white" scope="col">Marketing</th>
                    <th class="bg-success bg-opacity-75 text-white" scope="col">Bulan</th>
                    <th class="bg-success bg-opacity-75 text-white" scope="col">Omzet</th>
                    <th class="bg-success bg-opacity-75 text-white" scope="col">Komisi %</th>
                    <th class="bg-success bg-opacity-75 text-white" scope="col">Komisi Nominal</th>
                  </tr>
                </thead>
                <tbody>    
                        <!-- Data akan ditambahkan di sini oleh AJAX --> 
                </tbody>
              </table>
        </div>
        <div class="col-2"></div>

        
    </div>
    
</div>

<script>
    $(document).ready(function() {
        // Ambil data penjualan dari API
        $.ajax({
            url: '/api/penjualans',
            method: 'GET',
            success: function(response) {
                // Jika sukses, tampilkan data penjualan ke dalam table
                let rows = '';
                response.data.forEach(function(penjualan) {
                    rows += `
                        <tr>
                            <td>${penjualan.marketing}</td>
                            <td>${penjualan.bulan}</td>
                            <td>${formatRupiah(penjualan.omzet)}</td>
                            <td>${penjualan.komisi_persen}</td>
                            <td>${formatRupiah(penjualan.komisi_nominal)}</td>
                        </tr>
                    `;
                });
                $('#penjualan-table tbody').html(rows);
            },
            error: function() {
                alert('Error fetching data!');
            }
        });
    });


    function formatRupiah(angka) {
    // Pastikan angka adalah string
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp. ' + rupiah;
}



    </script>
    
</body>
</html>


