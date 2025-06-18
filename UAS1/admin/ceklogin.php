<?php

// require 'function.php';
require_once 'function.php';


if (isset($_POST['btn_login'])) {
    $data_email = $_POST['email'];
    $data_password = $_POST['password'];

    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM author WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $data_email, $data_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['idpenulis'] = $row['id_author'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['author_name']; // Pastikan kolom ini ada di tabel
        header('Location: index.php');
        exit();
    } else {
        header('Location: login.php?error=1');
        exit();
    }
}
?>