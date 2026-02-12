<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that record
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];
    
    mysqli_query($conn, "DELETE FROM detail_bahanbaku WHERE kode_barang='$kode_barang'");
    
    $result = mysqli_query($conn, "DELETE FROM barang WHERE kode_barang='$kode_barang'");
    
    if($result) {
        header("Location: barang-lihat.php");
        exit();
    } else {
        // If there's an error, show alert and redirect back
        echo "<script>alert('Gagal menghapus data barang');</script>";
        echo "<script>window.location.href='barang-lihat.php';</script>";
    }
} else {
    header("Location: barang-lihat.php");
    exit();
}
?>