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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.min.css" integrity="sha256-VJuwjrIWHWsPSEvQV4DiPfnZi7axOaiWwKfXaJnR5tA=" crossorigin="anonymous">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.all.min.js"></script>
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
                            <a href="./edit.php?id=${data.id}" class="btn btn-outline-primary">Edit</a>
                            <button class="btn btn-outline-danger tombolhapus" data-id="${data.id}">Hapus</button>
                        `;
                    }
                
                },
            ]
        });
    } );

    $(document).on('click', '.tombolhapus', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: './routekegiatan.php?id='+id,
                    type: 'DELETE',
                    success: function (response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: "Data berhasil dihapus!",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    },
                    error: function (response) {
                        Swal.fire({
                            title: 'Gagal',
                            text: "Data gagal dihapus!",
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        })
                    }
                });
            }
        })
    })
</script>
</html>
