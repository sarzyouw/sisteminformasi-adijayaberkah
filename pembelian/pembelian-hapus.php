<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that record
if (isset($_GET['id_pembelian'])) {
    $id_pembelian = $_GET['id_pembelian'];
    
    // First, delete related records in detail_pembelian (if exists)
    mysqli_query($conn, "DELETE FROM detail_pembelian WHERE id_pembelian='$id_pembelian'");
    
    // Then delete the main pembelian record
    $result = mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'");
    
    if($result) {
        // After successful delete, redirect to pembelian list
        header("Location: pembelian-lihat.php");
        exit();
    } else {
        // If there's an error, show alert and redirect back
        echo "<script>alert('Gagal menghapus data pembelian');</script>";
        echo "<script>window.location.href='pembelian-lihat.php';</script>";
    }
} else {
    // If no id parameter, redirect to pembelian list
    header("Location: pembelian-lihat.php");
    exit();
}
?>