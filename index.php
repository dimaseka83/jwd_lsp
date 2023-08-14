<?php 
session_start();
    include("koneksi.php");

    // get data kegiatan and relation with table gambar_kegiatan
    $sql = "SELECT * FROM kegiatan INNER JOIN gambar_kegiatan ON kegiatan.id = gambar_kegiatan.kegiatan_id";
    $query = mysqli_query($koneksi, $sql);
    $kegiatan = array();
    while($data = mysqli_fetch_assoc($query)){
        $kegiatan[] = $data;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        foreach($kegiatan as $data) {
            echo "<h2>".$data["nama"]."</h2>";
            echo "<img src='images/".$data["nama_file"]."'>";
            echo "<p>".$data["deskripsi"]."</p>";
        }
    ?>
</body>
</html>