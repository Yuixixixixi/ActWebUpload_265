<?php
require_once 'config.php';

$message = "";
$message_type = "";
$uploadOk = 1;

// 1. LOGIKA PROSES UNGGAH FILE
if (isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            $message = "Berkas bukan gambar.";
            $message_type = "error";
            $uploadOk = 0;
        }
    } else {
        $message = "Silakan pilih file terlebih dahulu.";
        $message_type = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && file_exists($target_file)) {
        $message = "Maaf, berkas sudah ada.";
        $message_type = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && $_FILES["fileToUpload"]["size"] > 500000) {
        $message = "Maaf, berkas terlalu besar (Maks 500KB).";
        $message_type = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && $fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        $message = "Maaf, hanya format JPG, JPEG, PNG & GIF.";
        $message_type = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $message = "Berkas " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " berhasil diunggah.";
            $message_type = "success";
        } else {
            $message = "Maaf, terjadi kesalahan saat mengunggah.";
            $message_type = "error";
        }
    }
}

// 2. LOGIKA PROSES HAPUS FILE
if (isset($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['file'])) {
    $file_to_delete = $target_dir . basename($_GET['file']);
    
    if (file_exists($file_to_delete)) {
        if (unlink($file_to_delete)) {
            $message = "Berkas berhasil dihapus.";
            $message_type = "success";
        } else {
            $message = "Gagal menghapus berkas.";
            $message_type = "error";
        }
    } else {
        $message = "Berkas tidak ditemukan.";
        $message_type = "error";
    }
}
?>