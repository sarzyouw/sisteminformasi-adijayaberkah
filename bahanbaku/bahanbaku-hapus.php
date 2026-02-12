<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['kode_bahanbaku'])) {
    $kode_bahanbaku=$_GET['kode_bahanbaku'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM bahanbaku WHERE kode_bahanbaku='$kode_bahanbaku'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:bahanbaku-lihat.php");
?>