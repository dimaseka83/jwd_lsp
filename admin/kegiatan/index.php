<?php
include("../middleware.php");
include("../../koneksi.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administrator</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Admin</a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <div class="d-flex" role="search">
        <a href="../../logout.php" class="btn btn-outline-danger">Logout</a>
      </div>
    </div>
  </div>
</nav>
    <div class="container mt-5">
    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <a href="create.php" class="btn btn-outline-primary openmodal">Buat Kegiatan</a>
        </div>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            ajax: {
                url: './routekegiatan.php',
                dataSrc: ''
            },
            columns: [
                // nomor urut
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'nama' },
                { data: 'deskripsi' },
                { 
                    data: null,
                    render: function(data, type, row){
                        return `
                            <a href="./editkegiatan.php?id=${data.id}" class="btn btn-outline-primary">Edit</a>
                            <a href="./deletekegiatan.php?id=${data.id}" class="btn btn-outline-danger">Hapus</a>
                        `;
                    }
                
                },
            ]
        });
    } );

    const myModal = document.querySelector('.openmodal');
    // show modal
    myModal.addEventListener('show.bs.modal', event => {
        return event.preventDefault() // stops modal from being shown
        })
</script>
</html>
