<?php 
include("../../koneksi.php");

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

switch ($method) {
    case 'DELETE' :
        $id = $_GET['id'];
        // delete assets/img/kegiatan/ file
        $sql = "SELECT * FROM gambar_kegiatan WHERE id = '$id'";
        $result = $koneksi->query($sql);
        $row = $result->fetch_assoc();
        $gambar = $row['image'];
        $gambarPath = '../../assets/img/kegiatan/'.$gambar;
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
        // delete from database
        $sql = "DELETE FROM gambar_kegiatan WHERE id = '$id'";
        $result = $koneksi->query($sql);
        if ($result) {
            echo json_encode(array('success' => true, 'message' => 'Berhasil menghapus gambar'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus gambar'));
        }
        break;
}
?>