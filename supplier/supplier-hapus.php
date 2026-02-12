<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_supplier'])) {
    $id_supplier=$_GET['id_supplier'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM supplier WHERE id_supplier='$id_supplier'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:supplier-lihat.php");
?>