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
        // echo id
        $id = $_POST["id"];
        if(!$id){
            $nama = $_POST["nama"];
            $deskripsi = $_POST["deskripsi"];

            // Check if any images are uploaded
            if (isset($_FILES['gambar'])) {
                // gambar multiple files
                $gambar = $_FILES['gambar'];
                $gambarCount = count($gambar['name']);
                $gambarName = array();
                $gambarTmpName = array();
                $gambarSize = array();
                $gambarError = array();
                $gambarType = array();
                $gambarExt = array();

                $sql = "INSERT INTO kegiatan (nama, deskripsi) VALUES ('$nama', '$deskripsi')";
                $result = $koneksi->query($sql);
                $id = $koneksi->insert_id;

                for ($i = 0; $i < $gambarCount; $i++) {
                    if (!empty($gambar['name'][$i])) {
                        $gambarName[$i] = $gambar['name'][$i];
                        $gambarTmpName[$i] = $gambar['tmp_name'][$i];
                        $gambarSize[$i] = $gambar['size'][$i];
                        $gambarError[$i] = $gambar['error'][$i];
                        $gambarType[$i] = $gambar['type'][$i];
                        $gambarExt[$i] = explode('.', $gambarName[$i]);
                        $gambarExt[$i] = strtolower(end($gambarExt[$i]));

                        $allowed = array('jpg', 'jpeg', 'png');

                        if (in_array($gambarExt[$i], $allowed)) {
                            if ($gambarError[$i] === 0) {
                                if ($gambarSize[$i] < 1000000) {
                                    $gambarNameNew[$i] = uniqid('', true).".".$gambarExt[$i];
                                    $gambarDestination[$i] = '../../asset/img/kegiatan/'.$gambarNameNew[$i];
                                    move_uploaded_file($gambarTmpName[$i], $gambarDestination[$i]);
                                    // input data ke database
                                    $sql = "INSERT INTO gambar_kegiatan (image, kegiatan_id) VALUES ('$gambarNameNew[$i]', '$id')";
                                    $result = $koneksi->query($sql);
                                    if ($result) {
                                        echo json_encode(array('message' => 'Data successfully added.'));
                                        header("Location: ./index.php"); // Ganti dengan halaman login
                                    } else {
                                        echo json_encode(array('message' => 'Data failed to add.'));
                                    }
                                } else {
                                    echo json_encode(array('message' => 'Your file is too big.'));
                                }
                            } else {
                                echo json_encode(array('message' => 'There was an error uploading your file.'));
                            }
                        } else {
                            echo json_encode(array('message' => 'You cannot upload files of this type.'));
                        }
                    } else {
                        echo json_encode(array('message' => 'Data successfully added.'));
                        header("Location: ./index.php"); // Ganti dengan halaman yang sesuai
                    }
                }
            } else {
                $sql = "INSERT INTO kegiatan (nama, deskripsi) VALUES ('$nama', '$deskripsi')";
                $result = $koneksi->query($sql);
                if ($result) {
                    echo json_encode(array('message' => 'Data successfully added.'));
                    header("Location: ./index.php"); // Ganti dengan halaman login
                } else {
                    echo json_encode(array('message' => 'Data failed to add.'));
                }
            }
        }else {
            $id = $_POST["id"];
            $nama = $_POST["nama"];
            $deskripsi = $_POST["deskripsi"];

            // Update kegiatan data
            $sql = "UPDATE kegiatan SET nama = '$nama', deskripsi = '$deskripsi' WHERE id = $id";
            $result = $koneksi->query($sql);

            if ($result) {
                // Handle image updates if files are uploaded
                if (isset($_FILES['gambar'])) {
                    $gambar = $_FILES['gambar'];
                    $gambarCount = count($gambar['name']);

                    for ($i = 0; $i < $gambarCount; $i++) {
                        // Check if a file is uploaded
                        if (!empty($gambar['name'][$i])) {
                            $gambarName = $gambar['name'][$i];
                            $gambarTmpName = $gambar['tmp_name'][$i];
                            $gambarSize = $gambar['size'][$i];
                            $gambarError = $gambar['error'][$i];
                            $gambarExt = pathinfo($gambarName, PATHINFO_EXTENSION);
                            $idGambar = $_POST['id_gambar'][$i];
                            
                            $allowed = array('jpg', 'jpeg', 'png');

                            if (in_array($gambarExt, $allowed)) {
                                if ($gambarError === 0) {
                                    if ($gambarSize < 1000000) {
                                        $gambarNameNew = uniqid('', true).".".$gambarExt;
                                        $gambarDestination = '../../asset/img/kegiatan/'.$gambarNameNew;
                                        move_uploaded_file($gambarTmpName, $gambarDestination);

                                        // Update gambar_kegiatan table
                                        if ($idGambar) {
                                            // Delete old image if it exists
                                            $sql = "SELECT * FROM gambar_kegiatan WHERE id = $idGambar";
                                            $result = $koneksi->query($sql);
                                            $row = $result->fetch_assoc();
                                            $gambarOld = $row['image'];
                                            if (file_exists('../../asset/img/kegiatan/'.$gambarOld)) {
                                                unlink('../../asset/img/kegiatan/'.$gambarOld);
                                            }
                                            
                                            $sql = "UPDATE gambar_kegiatan SET image = '$gambarNameNew' WHERE id = $idGambar";
                                        } else {
                                            $sql = "INSERT INTO gambar_kegiatan (image, kegiatan_id) VALUES ('$gambarNameNew', $id)";
                                        }

                                        $result = $koneksi->query($sql);

                                        if ($result) {
                                            echo json_encode(array('message' => 'Data successfully updated.'));
                                            header("Location: ./index.php"); // Ganti dengan halaman login
                                        } else {
                                            echo json_encode(array('message' => 'Data failed to update.'));
                                        }
                                    } else {
                                        echo json_encode(array('message' => 'Your file is too big.'));
                                    }
                                } else {
                                    echo json_encode(array('message' => 'There was an error uploading your file.'));
                                }
                            } else {
                                echo json_encode(array('message' => 'You cannot upload files of this type.'));
                            }
                        }
                    }
                } else {
                    echo json_encode(array('message' => 'Data successfully updated.'));
                    header("Location: ./index.php"); // Ganti dengan halaman login
                }
                header("Location: ./index.php"); // Ganti dengan halaman yang sesuai
            } else {
                echo json_encode(array('message' => 'Data failed to update.'));
            }
        }
    
         break;
    case 'DELETE':
        $id = $_GET['id'];

        // Delete gambar_kegiatan yang ada di assets
        $sql = "SELECT * FROM gambar_kegiatan WHERE kegiatan_id = $id";
        $result = $koneksi->query($sql);
        while ($row = $result->fetch_assoc()) {
            $gambar = $row['image'];
            if (file_exists('../../asset/img/kegiatan/'.$gambar)) {
                unlink('../../asset/img/kegiatan/'.$gambar);
            }
        }

        $sql = "DELETE FROM kegiatan WHERE id = '".$id."'";
        $result = $koneksi->query($sql);

        if ($result) {
            echo json_encode(array('success' => true, 'message' => 'Data successfully deleted.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Data failed to delete.'));
        }
        
        break;
}
?>