<?php
include 'header.php';

$page = $_GET['page'] ?? 'barang';

switch ($page) {
    case 'barang':
        include 'barang.php';
        break;

    case 'tambah':
        include 'tambah.php';
        break;

    case 'ubah':
        include 'ubah.php';
        break;

    case 'hapus':
        include 'hapus.php';
        break;

    case 'about':
        include 'about.php';
        break;

    default:
        echo "<h3>Halaman tidak ditemukan</h3>";
        break;
}

