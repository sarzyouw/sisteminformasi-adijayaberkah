<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that detail
if (isset($_GET['id_penjualan']) && isset($_GET['kode_barang'])) {
    $id_penjualan = mysqli_real_escape_string($conn, $_GET['id_penjualan']);
    $kode_barang = mysqli_real_escape_string($conn, $_GET['kode_barang']);
    
    // First get the amount to be deleted
    $query_get_amount = "SELECT jumlah FROM detail_penjualan WHERE id_penjualan = '$id_penjualan' AND kode_barang = '$kode_barang' LIMIT 1";
    $result_get_amount = mysqli_query($conn, $query_get_amount);
    
    if (!$result_get_amount || mysqli_num_rows($result_get_amount) == 0) {
        die("Error: Data tidak ditemukan atau sudah dihapus.");
    }
    
    $row = mysqli_fetch_assoc($result_get_amount);
    $amount_to_delete = $row['jumlah'];

    // Delete detail row from table
    $result_delete = mysqli_query($conn, "DELETE FROM detail_penjualan WHERE id_penjualan = '$id_penjualan' AND kode_barang = '$kode_barang' LIMIT 1");

    if ($result_delete) {
        // Update total price in penjualan table
        $query_update = "UPDATE penjualan SET jumlah_rp = jumlah_rp - $amount_to_delete WHERE id_penjualan = '$id_penjualan'";
        $result_update = mysqli_query($conn, $query_update);

        if ($result_update) {
            // After delete redirect to detail view
            header("Location: notadetail-lihat.php?id_penjualan=$id_penjualan");
            exit();
        } else {
            die("Error updating total price: " . mysqli_error($conn));
        }
    } else {
        die("Error deleting item: " . mysqli_error($conn));
    }
} else {
    die("Parameter tidak valid. ID Penjualan dan Kode Barang diperlukan.");
}
?>