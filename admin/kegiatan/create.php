<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Kegiatan Baru</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<body>
  <div class="container">
    <form action="./routekegiatan.php" method="POST">
      <div class="form-group">
        <label for="">Nama Kegiatan</label>
        <input type="text" name="nama" class="form-control">
      </div>
      <div class="form-group">
        <label for="">Deskripsi Kegiatan</label>
        <textarea name="deskripsi" class="form-control"></textarea>
      </div>
      <div class="card my-3">
        <div class="card-body">
        <div class="d-flex flex-row-reverse">
          <div class="p-2"><button class="btn btn-outline-primary tambahgambar">Tambah Gambar</button></div>
        </div>
          <div class="clonegambar">
            <div class="form-group gambar row">
              <label for="" class="col-sm-2 col-form-label">Upload Gambar</label>
              <div class="col-sm-10">
                <input type="file" name="gambar[]" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- button submit -->
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</body>
<script>
  $(document).on('click', '.tambahgambar', function (e) {
    e.preventDefault();
    let html = `
      <div class="form-group gambar">
        <label for="">Upload Gambar</label>
        <input type="file" name="gambar[]" class="form-control">
      </div>
    `;
    $('.clonegambar').append(html);
  });
</script>
</html>