<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "dbcms";

// Koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['btn_login'])) {
    $data_email = $_POST['email'];
    $data_password = $_POST['password'];

    $sql = "SELECT * FROM author WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $data_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (md5($data_password) === $row['password']) {
            $_SESSION['idpenulis'] = $row['id_author'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['author_name'] = $row['author_name'];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['flash_error'] = "Password salah";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['flash_error'] = "Email tidak ditemukan";
        header('Location: login.php');
        exit();
    }
}

if(isset($_POST['btn_ubah_penulis'])){
    $data_nama=$_POST['nama'];
    $data_email=$_POST['email'];
    $data_password=md5($_POST['password']);
    $id_update=$_POST['id_penulis_update'];

    $sql = "UPDATE author 
            SET 
                author_name='$data_nama',
                email='$data_email',
                password='$data_password'
            WHERE id_author='$id_update'";
    if (mysqli_query($conn, $sql)) {
    header('Location: penulis.php');
    } else {
    echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_POST['btn_hapus_artikel'])){
    $id_hapus = $_POST['id_hapus_artikel'];
    $sql_get_image = "SELECT picture FROM article WHERE id_article = (SELECT id_article FROM kontributor WHERE id_kontributor = ?)";
    $stmt_get = mysqli_prepare($conn, $sql_get_image);
    mysqli_stmt_bind_param($stmt_get, "i", $id_hapus);
    mysqli_stmt_execute($stmt_get);
    $result = mysqli_stmt_get_result($stmt_get);
    $image_data = mysqli_fetch_assoc($result);
    $image_path = $image_data['picture'] ?? '';

    mysqli_begin_transaction($conn);
    
    try {
        $sql1 = "DELETE FROM kontributor WHERE id_kontributor = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $id_hapus);
        mysqli_stmt_execute($stmt1);

        $sql2 = "DELETE FROM article WHERE id_article NOT IN (SELECT id_article FROM kontributor)";
        mysqli_query($conn, $sql2);

        if(!empty($image_path) && file_exists($image_path)) {
            unlink($image_path);
        }
        
        mysqli_commit($conn);
        header('Location: artikel.php?status=deleted');
        exit();
    } catch(Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}





// if (isset($_POST['btn_hapus_kategori'])) {
//     $id_hapus = $_POST['id_hapus_kategori'];

//     $sql1 = "DELETE FROM kontributor WHERE id_kontributor = ?";
//     $stmt1 = mysqli_prepare($conn, $sql1);

//     if ($stmt1) {
//         mysqli_stmt_bind_param($stmt1, "i", $id_hapus);
//         if (mysqli_stmt_execute($stmt1)) {
//             $sql2 = "DELETE FROM category WHERE id_category NOT IN (SELECT id_category FROM kontributor)";
//             if (mysqli_query($conn, $sql2)) {
//                 header('Location: kategori.php');
//                 exit();
//             } else {
//                 echo "Gagal menghapus kategori yang tidak digunakan: " . mysqli_error($conn);
//             }
//         } else {
//             echo "Gagal mengeksekusi penghapusan kontributor: " . mysqli_stmt_error($stmt1);
//         }
//     } else {
//         echo "Gagal menyiapkan statement: " . mysqli_error($conn);
//     }
// }
if (isset($_POST['btn_hapus_kategori'])) {
    $id_hapus = $_POST['id_hapus_kategori'];
    
    // Mulai transaksi
    mysqli_begin_transaction($conn);
    
    try {
        // 1. Cek apakah kategori digunakan di kontributor
        $sql_check = "SELECT COUNT(*) as total FROM kontributor WHERE id_category = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id_hapus);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);
        $row = mysqli_fetch_assoc($result);
        
        if ($row['total'] > 0) {
            throw new Exception("Kategori tidak dapat dihapus karena masih digunakan dalam artikel");
        }
        
        // 2. Hapus kategori spesifik
        $sql_delete = "DELETE FROM category WHERE id_category = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_hapus);
        mysqli_stmt_execute($stmt_delete);
        
        mysqli_commit($conn);
        $_SESSION['success'] = "Kategori berhasil dihapus";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error'] = $e->getMessage();
    }
    
    header('Location: kategori.php');
    exit();
}


if(isset($_POST['btn_hapus_penulis'])) {
    $id_hapus = $_POST['id_hapus_penulis'];
    $current_user_id = $_SESSION['idpenulis']; // ID admin yang sedang login
    
    // 1. Cek apakah mencoba menghapus diri sendiri
    if($id_hapus == $current_user_id) {
        $_SESSION['error'] = "Anda tidak dapat menghapus akun sendiri!";
        header('Location: penulis.php');
        exit();
    }
    
    // 2. Ambil semua gambar yang terkait dengan penulis ini
    $sql_get_images = "SELECT a.picture FROM article a 
                      JOIN kontributor k ON a.id_article = k.id_article
                      WHERE k.id_author = ?";
    $stmt_get = mysqli_prepare($conn, $sql_get_images);
    mysqli_stmt_bind_param($stmt_get, "i", $id_hapus);
    mysqli_stmt_execute($stmt_get);
    $result = mysqli_stmt_get_result($stmt_get);
    $images_to_delete = [];
    while($row = mysqli_fetch_assoc($result)) {
        if(!empty($row['picture'])) {
            $images_to_delete[] = $row['picture'];
        }
    }
    
    mysqli_begin_transaction($conn);
    
    try {
        // 3. Hapus dari kontributor terlebih dahulu
        $sql1 = "DELETE FROM kontributor WHERE id_author = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $id_hapus);
        mysqli_stmt_execute($stmt1);
        
        // 4. Hapus artikel yang tidak memiliki kontributor
        $sql2 = "DELETE FROM article WHERE id_article NOT IN (SELECT id_article FROM kontributor)";
        mysqli_query($conn, $sql2);
        
        // 5. Hapus penulis
        $sql3 = "DELETE FROM author WHERE id_author = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $id_hapus);
        mysqli_stmt_execute($stmt3);
        
        // 6. Hapus file gambar terkait
        foreach($images_to_delete as $image_path) {
            if(file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        mysqli_commit($conn);
        $_SESSION['success'] = "Penulis berhasil dihapus";
        header('Location: penulis.php');
        exit();
    } catch(Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error'] = "Gagal menghapus penulis: " . $e->getMessage();
        header('Location: penulis.php');
        exit();
    }
}
if(isset($_POST['btn_simpan_kategori'])){
    $data_nama=$_POST['nama'];
    $data_keterangan=$_POST['keterangan'];

    $sql = "INSERT INTO category (category_name, description)
            VALUES ('$data_nama', '$data_keterangan')";

            if (mysqli_query($conn, $sql)) {
            header('Location: kategori.php');
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
}

if(isset($_POST['btn_ubah_kategori'])){
    $data_nama=$_POST['nama'];
    $data_keterangan=$_POST['keterangan'];
    $id_update=$_POST['id_kategori_update'];

    $sql = "UPDATE category 
            SET 
                category_name='$data_nama',
                description='$data_keterangan'
            WHERE id_category='$id_update'";
    if (mysqli_query($conn, $sql)) {
    header('Location: kategori.php');
    } else {
    echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_POST['btn_simpan_penulis'])){
    $data_nama=$_POST['nama'];
    $data_email=$_POST['email'];
    $data_password=md5($_POST['password']);

    $sql = "INSERT INTO author (author_name, email, password)
            VALUES ('$data_nama', '$data_email','$data_password')";

            if (mysqli_query($conn, $sql)) {
            header('Location: penulis.php');
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
}

if(isset($_POST['btn_simpan'])){
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $target_dir = "gambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }
        if ($_FILES["gambar"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    }
    $data_tanggal=$_POST['tanggal'];
    $data_judul=$_POST['judul'];
    $data_isi=$_POST['isi'];
    $data_gambar=$target_file;
    $data_kategori=$_POST['kategori'];
    $sql = "INSERT INTO article (date, title, content,picture)
    VALUES ('$data_tanggal', '$data_judul', '$data_isi','$data_gambar')";

    if (mysqli_query($conn,$sql)) {
        $sql = "SELECT * FROM article ORDER BY id_article DESC LIMIT 1 ";
        $result = mysqli_query($conn, $sql);
        $data_id_artikel="";

        if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data_id_artikel = $row['id_article'];
        }
        } else {
        echo "0 results";
        }
        $data_id_penulis=$_SESSION['idpenulis'];
        $sql = "INSERT INTO kontributor (id_author,id_category,id_article)
        VALUES ('$data_id_penulis', '$data_kategori', '$data_id_artikel')";

        if (mysqli_query($conn, $sql)) {
        header('Location: artikel.php');
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    } else {

    }
}
if(isset($_POST['btn_ubah_artikel'])){

    $id_ubah = $_POST['id_kontributor_ubah'];
    $data_gambar = '';
    $upload_gambar = false;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $target_dir = "gambar/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["gambar"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $data_gambar = $target_file;
                $upload_gambar = true;
                echo "The file ". htmlspecialchars(basename($_FILES["gambar"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $data_tanggal = $_POST['tanggal'];
    $data_judul = $_POST['judul'];
    $data_isi = $_POST['isi'];
    $data_kategori = $_POST['kategori'];
    if(!$upload_gambar) {
        $sql_gambar = "SELECT a.picture FROM article a 
                    JOIN kontributor k ON a.id_article = k.id_article
                    WHERE k.id_kontributor = '$id_ubah'";
        $result = mysqli_query($conn, $sql_gambar);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $data_gambar = $row['picture'];
        } else {
            echo "Error: Could not retrieve old image.";
            exit();
        }
    }
    
    // Update artikel
    $sql_update_artikel = "UPDATE article a
            INNER JOIN kontributor k ON a.id_article = k.id_article
            SET 
                a.title = '$data_judul',
                a.content = '$data_isi',
                a.picture = '$data_gambar'
            WHERE k.id_kontributor = '$id_ubah'";
    
    $sql_ubah_kontributor = "UPDATE kontributor
            SET id_category = '$data_kategori'
            WHERE id_kontributor = '$id_ubah'";
    
    $success = true;
    if (!mysqli_query($conn, $sql_update_artikel)) {
        echo "Error updating article: " . mysqli_error($conn);
        $success = false;
    }
    
    if (!mysqli_query($conn, $sql_ubah_kontributor)) {
        echo "Error updating contributor: " . mysqli_error($conn);
        $success = false;
    }
    
    if ($success) {
        header('Location: artikel.php');
        exit();
    }
}


function potong_artikel($isi_artikel,$jml_karakter){
    while($isi_artikel[$jml_karakter]!=" "){
        --$jml_karakter;
    }
    $potongan_paragraf=substr($isi_artikel,0,$jml_karakter);
    $potongan_paragraf_jadi=$potongan_paragraf." ...";
    return $potongan_paragraf_jadi;
}
    function hariIndonesia($nama_hari) {
    switch ($nama_hari) {
        case 'Monday':
            return "Senin";
        case 'Tuesday':
            return "Selasa";
        case 'Wednesday':
            return "Rabu";
        case 'Thursday':
            return "Kamis";
        case 'Friday':
            return "Jumat";
        case 'Saturday':
            return "Sabtu";
        case 'Sunday':
            return "Minggu";
        default:
            return "Hari tidak dikenal";
    }
}

    // bulan 
    function bulanIndonesia($nomor_bulan) {
    switch ($nomor_bulan) {
        case '01':
            return "Januari";
        case '02':
            return "Februari";
        case '03':
            return "Maret";
        case '04':
            return "April";
        case '05':
            return "Mei";
        case '06':
            return "Juni";
        case '07':
            return "Juli";
        case '08':
            return "Agustus";
        case '09':
            return "September";
        case '10':
            return "Oktober";
        case '11':
            return "November";
        case '12':
            return "Desember";
        default:
            return "Bulan tidak dikenal";
    }
}

?>

