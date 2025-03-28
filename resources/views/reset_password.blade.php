<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form Reset Password</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <!-- Custom Style -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 10px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-info {
      background-color: #17a2b8;
      border-color: #17a2b8;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card mt-4 col-md-6 shadow-lg mx-auto">
      <div class="card-body">
        <h4 class="text-center mb-3">Reset Password</h4>
        
        <!-- Pesan Error -->
        @if ($errors->any())
          <div class="alert alert-danger mt-3">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ url('reset-password-proses') }}" method="post">
          @csrf
          
          <div class="mb-3">
            <label for="number" class="form-label">Masukkan Nomor Telepon yang Terdaftar :</label>
            <input type="text" name="nomer" class="form-control" id="number" placeholder="Masukkan Nomor Telepon" autocomplete="off" value="{{ old('nomer') }}">
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2">Reset</button>
            <a href=" "class="btn btn-info text-white">Cancel</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>
</html>
