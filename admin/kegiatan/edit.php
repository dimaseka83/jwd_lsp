<?php 
    include '../../koneksi.php';
    $id = $_GET['id'];
    $sql = "SELECT * FROM kegiatan WHERE id = '$id'";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.min.css" integrity="sha256-VJuwjrIWHWsPSEvQV4DiPfnZi7axOaiWwKfXaJnR5tA=" crossorigin="anonymous">
<body>
  <div class="container mt-5">
    <a href="index.php" class=" mb-5 btn btn-outline-primary">Kembali</a>
    <form action="./routekegiatan.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <div class="form-group">
        <label for="">Nama Kegiatan</label>
        <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>">
      </div>
      <div class="form-group">
        <label for="">Deskripsi Kegiatan</label>
        <textarea name="deskripsi" class="form-control">
            <?php echo ($row['deskripsi']); ?>
        </textarea>
      </div>
      <div class="card my-3">
        <div class="card-body">
        <div class="d-flex flex-row-reverse">
          <div class="p-2"><button class="btn btn-outline-primary tambahgambar">Tambah Gambar</button></div>
        </div>
          <div class="clonegambar">
            <?php 
              $sql = "SELECT * FROM gambar_kegiatan WHERE kegiatan_id = '$id'";
              $result = $koneksi->query($sql);
              while($row = $result->fetch_assoc()) {
            ?>
            <div class="form-group gambar row my-1">
                <label for="" class="col-sm-2 col-form-label">Upload Gambar</label>
                <div class="col-sm-8">
                <img src="../../asset/img/kegiatan/<?php echo $row['image']; ?>" alt="" width="100px">
                <input type="file" name="gambar[]" class="form-control">
                <input type="hidden" name="id_gambar[]" value="<?php echo $row['id']; ?>">
                </div>
                <div class="col-sm-2">
                <button class="btn btn-outline-danger" data-id="<?php echo $row['id']; ?>" id="hapus">Hapus</button>
                </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- button submit -->
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.all.min.js"></script>
</body>
<script>
  $(document).on('click', '.tambahgambar', function (e) {
    e.preventDefault();
    let html = `
      <div class="form-group gambar row my-1">
        <label for="" class="col-sm-2 col-form-label">Upload Gambar</label>
        <div class="col-sm-8">
          <input type="file" name="gambar[]" class="form-control">
        </div>
        <div class="col-sm-2">
          <button class="btn btn-outline-danger" id="hapus">Hapus</button>
        </div>
      </div>
    `;
    $('.clonegambar').append(html);
  });

  $(document).on('click', '#hapus', function (e) {
    e.preventDefault();
    let dataId = $(this).data('id');
    if(dataId){
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: './routegambar.php?id='+dataId,
            type: 'DELETE',
            success: function (response) {
              Swal.fire(
                'Terhapus!',
                'Gambar telah dihapus.',
                'success'
              )
              location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              Swal.fire(
                'Gagal!',
                'Gambar gagal dihapus.',
                'error'
              )
            }
          });
        }
      })
    }else{
      $(this).parents('.gambar').remove();  
    }
  });
</script>
</html>
