<?php 
include("../../koneksi.php");

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM kegiatan";
        $result = $koneksi->query($sql);
        
        $kegiatan = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $kegiatan[] = $row;
            }
            // return response json
            echo json_encode($kegiatan);
        } else {
            // json array kosong
            echo json_encode(array());
        }
        break;
    case 'POST':
        $nama = $_POST["nama"];
        $deskripsi = $_POST["deskripsi"];
        
        $sql = "INSERT INTO kegiatan (nama, deskripsi) VALUES ('".$nama."', '".$deskripsi."')";
        $result = $koneksi->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Data successfully added.'));
            header("Location: ./index.php"); // Ganti dengan halaman login
        } else {
            echo json_encode(array('message' => 'Data failed to add.'));
        }

        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "UPDATE kegiatan SET nama = '".$data["nama"]."', deskripsi = '".$data["deskripsi"]."' WHERE id = '".$data["id"]."'";
        $result = $koneksi->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Data successfully updated.'));
        } else {
            echo json_encode(array('message' => 'Data failed to update.'));
        }
        
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "DELETE FROM kegiatan WHERE id = '".$data["id"]."'";
        $result = $koneksi->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Data successfully deleted.'));
        } else {
            echo json_encode(array('message' => 'Data failed to delete.'));
        }
        
        break;
}
?>