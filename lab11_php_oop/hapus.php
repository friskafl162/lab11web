<?php
require_once 'koneksi.php';

// validasi id
if (!isset($_GET['id'])) {
    die('ID tidak valid');
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// hapus data
$sql = "DELETE FROM data_barang WHERE id_barang = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    header('Location: index.php?page=barang');
    exit;
} else {
    die('Gagal menghapus data');
}
