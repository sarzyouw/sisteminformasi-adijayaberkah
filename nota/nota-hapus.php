<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];
    
    // Mulai transaksi
    mysqli_begin_transaction($conn);
    
    try {
        // Pertama hapus detail penjualan terkait
        $delete_detail = mysqli_query($conn, "DELETE FROM detail_penjualan WHERE id_penjualan='$id_penjualan'");
        if (!$delete_detail) {
            throw new Exception(mysqli_error($conn));
        }
        
        // Kemudian hapus penjualan utama
        $delete_penjualan = mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");
        if (!$delete_penjualan) {
            throw new Exception(mysqli_error($conn));
        }
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($conn);
        
        // Redirect ke halaman lihat nota
        header("Location:nota-lihat.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($conn);
        
        // Tampilkan pesan error
        die("Error menghapus data: " . $e->getMessage());
    }
} else {
    die("ID Penjualan tidak ditemukan");
}
?>