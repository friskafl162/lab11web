<?php
error_reporting(E_ALL);
require_once 'koneksi.php';

/* =========================
   AMBIL ID (GET / POST)
========================= */
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
} elseif (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
} else {
    die("ID tidak ditemukan");
}

/* =========================
   PROSES UPDATE
========================= */
if (isset($_POST['submit'])) {

    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = mysqli_real_escape_string($conn, $_POST['harga_jual']);
    $harga_beli = mysqli_real_escape_string($conn, $_POST['harga_beli']);
    $stok       = mysqli_real_escape_string($conn, $_POST['stok']);
    $gambar_lama = $_POST['gambar_lama'];

    $gambar = $gambar_lama;

    if (!empty($_FILES['file_gambar']['name'])) {
        $ext = pathinfo($_FILES['file_gambar']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $path = 'gambar/' . $filename;

        if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $path)) {
            if (!empty($gambar_lama) && file_exists('gambar/' . $gambar_lama)) {
                unlink('gambar/' . $gambar_lama);
            }
            $gambar = $filename;
        }
    }

    $sql = "UPDATE data_barang SET
                nama='$nama',
                kategori='$kategori',
                harga_jual='$harga_jual',
                harga_beli='$harga_beli',
                stok='$stok',
                gambar='$gambar'
            WHERE id_barang='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        die("Error update: " . mysqli_error($conn));
    }
}

/* =========================
   AMBIL DATA BARANG
========================= */
$sql = "SELECT * FROM data_barang WHERE id_barang='$id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data barang tidak ditemukan");
}

$data = mysqli_fetch_assoc($result);

function is_select($a, $b) {
    return ($a == $b) ? 'selected' : '';
}

require_once 'header.php';
?>

<h1>Ubah Barang</h1>

<div class="id-barang">
    ID Barang: <?= $data['id_barang']; ?>
</div>

<form method="post" action="ubah" enctype="multipart/form-ubah">

    <div class="row">
    <div class="input">
        <label>Nama Barang</label>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required />
    </div>

    <div class="input">
        <label>Kategori</label>
        <select name="kategori" required>
        <option value="Komputer" <?= is_select("Komputer", $data['kategori']); ?>>Komputer</option>
        <option value="Elektronik" <?= is_select("Elektronik", $data['kategori']); ?>>Elektronik</option>
        <option value="Hand Phone" <?= is_select("Hand Phone", $data['kategori']); ?>>Hand Phone</option>
    </select>

    <label>Harga Jual</label>
    <input type="number" name="harga_jual" value="<?= $data['harga_jual']; ?>" required>

    <label>Harga Beli</label>
    <input type="number" name="harga_beli" value="<?= $data['harga_beli']; ?>" required>

    <label>Stok</label>
    <input type="number" name="stok" value="<?= $data['stok']; ?>" required>

    <label>Gambar</label>
    <input type="file" name="file_gambar">
    <small>Gambar sekarang: <?= $data['gambar'] ?: 'Tidak ada'; ?></small>

    <input type="hidden" name="id" value="<?= $data['id_barang']; ?>">
    <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">

    <br><br>
    <button type="submit" name="submit">Simpan Perubahan</button>
</form>

<?php require_once 'footer.php'; ?>
