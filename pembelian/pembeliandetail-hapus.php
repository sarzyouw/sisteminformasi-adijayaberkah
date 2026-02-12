<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that detail
if (isset($_GET['id_pembelian']) && isset($_GET['kode_bahanbaku'])) {
    $id_pembelian = mysqli_real_escape_string($conn, $_GET['id_pembelian']);
    $kode_bahanbaku = mysqli_real_escape_string($conn, $_GET['kode_bahanbaku']);
    
    // First get the amount to be deleted
    $query_get_amount = "SELECT jumlah FROM detail_pembelian WHERE id_pembelian = '$id_pembelian' AND kode_bahanbaku = '$kode_bahanbaku' LIMIT 1";
    $result_get_amount = mysqli_query($conn, $query_get_amount);
    
    if (!$result_get_amount || mysqli_num_rows($result_get_amount) == 0) {
        die("<script>alert('Data tidak ditemukan atau sudah dihapus.');window.history.back();</script>");
    }
    
    $row = mysqli_fetch_assoc($result_get_amount);
    $amount_to_delete = $row['jumlah'];

    // Delete detail row from table
    $result_delete = mysqli_query($conn, "DELETE FROM detail_pembelian WHERE id_pembelian = '$id_pembelian' AND kode_bahanbaku = '$kode_bahanbaku' LIMIT 1");

    if ($result_delete) {
        // Update total price in pembelian table
        $query_update = "UPDATE pembelian SET jumlah_rp = jumlah_rp - $amount_to_delete WHERE id_pembelian = '$id_pembelian'";
        $result_update = mysqli_query($conn, $query_update);

        if ($result_update) {
            // After delete redirect to detail view
            header("Location: pembeliandetail-lihat.php?id_pembelian=$id_pembelian");
            exit();
        } else {
            die("<script>alert('Gagal update total pembelian!');window.history.back();</script>");
        }
    } else {
        die("<script>alert('Gagal menghapus detail pembelian!');window.history.back();</script>");
    }
} else {
    die("<script>alert('Parameter tidak valid. ID Pembelian dan Kode Bahan Baku diperlukan.');window.location='pembelian-lihat.php';</script>");
}
?>