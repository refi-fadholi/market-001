<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Pembayaran Kredit</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body class="bg-success-subtle">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {
          @if (session('success'))
            toastr.success("{{ session('success') }}");
          @endif
      
          @if (session('error'))
            toastr.error("{{ session('error') }}");
          @endif

        });
      </script>

    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    /* padding: 20px; */
}

.ct-form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 0 auto;
}

h1 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
    font-size: 14px;
    color: #333;
}

input {
    margin-top: 5px;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    margin-top: 20px;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

#response-message {
    margin-top: 20px;
    text-align: center;
    font-size: 16px;
}

    </style>

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
                    <a class="nav-link text-white" aria-current="page" href="/">Penjualan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="/pembayaran">Pembayaran</a>
                  </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container ct-form pt-10" style="vertical-align: middle; margin-top: 120px;">
        <h1>Form Pembayaran</h1>

        <form id="payment-form" action="{{ url('/pembayaran') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="penjualan_id">ID Penjualan</label>
                <input type="number" id="penjualan_id" name="penjualan_id" min="1" required class="form-control" placeholder="Masukkan ID Penjualan">
            </div>
        
            <div class="form-group">
                <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" required class="form-control" placeholder="Pilih Tanggal Pembayaran">
            </div>
        
            <div class="form-group">
                <label for="jumlah">Jumlah Pembayaran</label>
                <input type="number" id="jumlah" name="jumlah" required class="form-control" placeholder="Masukkan Jumlah Pembayaran">
            </div>
        
            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
        </form>
        

        <div id="response-message"></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js">

$(document).ready(function () {
        $('#payment-form').on('submit', function (e) {
            e.preventDefault(); // Mencegah form submit biasa

            // Ambil data dari form
            var penjualan_id = $('#penjualan_id').val();
            var tanggal_pembayaran = $('#tanggal_pembayaran').val();
            var jumlah = $('#jumlah').val();

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '{{ url("/pembayaran") }}', // URL yang mengarah ke route "store"
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    penjualan_id: penjualan_id,
                    tanggal_pembayaran: tanggal_pembayaran,
                    jumlah: jumlah
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Pembayaran berhasil!');
                    } else {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });


    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
