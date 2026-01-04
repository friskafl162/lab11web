<?php
// File: BarangModul.php

class BarangModul {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ambil semua data
    public function getAll() {
        $sql = "SELECT * FROM data_barang";
        return mysqli_query($this->conn, $sql);
    }

    // tambah data
    public function tambah($data, $gambar = null) {
        $nama       = mysqli_real_escape_string($this->conn, $data['nama']);
        $kategori   = mysqli_real_escape_string($this->conn, $data['kategori']);
        $harga_jual = $data['harga_jual'];
        $harga_beli = $data['harga_beli'];
        $stok       = $data['stok'];
        $gambar     = $gambar;

        $sql = "INSERT INTO data_barang 
                (nama, kategori, harga_jual, harga_beli, stok, gambar)
                VALUES
                ('$nama','$kategori','$harga_jual','$harga_beli','$stok','$gambar')";

        return mysqli_query($this->conn, $sql);
    }

    // hapus
    public function hapus($id) {
        $id = (int)$id;
        return mysqli_query(
            $this->conn,
            "DELETE FROM data_barang WHERE id_barang=$id"
        );
    }

    // ambil 1 data (buat ubah)
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM data_barang WHERE id_barang=$id";
        return mysqli_query($this->conn, $sql);
    }

    // update
    public function update($id, $data, $gambar = null) {
        $id = (int)$id;
        $nama = $data['nama'];
        $kategori = $data['kategori'];
        $harga_jual = $data['harga_jual'];
        $harga_beli = $data['harga_beli'];
        $stok = $data['stok'];

        $sql = "UPDATE data_barang SET
                nama='$nama',
                kategori='$kategori',
                harga_jual='$harga_jual',
                harga_beli='$harga_beli',
                stok='$stok'";

        if ($gambar) {
            $sql .= ", gambar='$gambar'";
        }

        $sql .= " WHERE id_barang=$id";

        return mysqli_query($this->conn, $sql);
    }
}
