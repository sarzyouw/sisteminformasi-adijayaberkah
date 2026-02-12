<?php
include '../koneksi.php';

// Periksa apakah parameter ada
if (isset($_GET['kode_barang']) && isset($_GET['kode_bahanbaku'])) {
    $kode_barang = $_GET['kode_barang'];
    $kode_bahanbaku = $_GET['kode_bahanbaku'];

    // Validasi input
    if (empty($kode_barang) || empty($kode_bahanbaku)) {
        die("<script>alert('Parameter tidak lengkap!');window.location='barang-lihat.php';</script>");
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Hapus data detail bahan baku
        $query_delete = $conn->prepare("DELETE FROM detail_bahanbaku WHERE kode_barang = ? AND kode_bahanbaku = ?");
        $query_delete->bind_param("ss", $kode_barang, $kode_bahanbaku);
        $result_delete = $query_delete->execute();

        if ($result_delete && $conn->affected_rows > 0) {
            // Commit transaksi jika berhasil
            $conn->commit();
            header("Location: barangdetail-lihat.php?kode_barang=$kode_barang");
            exit;
        } else {
            throw new Exception("Gagal menghapus data atau data tidak ditemukan");
        }
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollback();
        die("<script>alert('".$e->getMessage()."');window.location='barangdetail-lihat.php?kode_barang=$kode_barang';</script>");
    }
} else {
    die("<script>alert('Parameter tidak lengkap!');window.location='barang-lihat.php';</script>");
}
?>