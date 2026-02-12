<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan=$_GET['id_pelanggan'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:pelanggan-lihat.php");
?>