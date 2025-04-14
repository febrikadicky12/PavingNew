<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form Reset Password</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="card mt-4 col-md-6 shadow-lg">
      <div class="card-body">
        <form action="{{url('reset-password-proses')}}" method="post">
          @csrf
          <div class="col-md-6">
            <div class="mb-3">
              <label for="number" class="form-label">Your Number Phone :</label>
              <input type="number" name="nomer" class="form-control" id="number" placeholder="Input your number" autocomplete="false">
            </div>
          </div>
          <div class="div">
            <button type="submit" class="btn btn-primary">Reset</button>
            <a href="" class="btn btn-info text-white">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>