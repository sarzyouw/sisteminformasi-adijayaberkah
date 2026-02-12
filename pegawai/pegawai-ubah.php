<?php
include '../koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_pegawai = '$_GET[id_pegawai]'");
$data = mysqli_fetch_array($query);

?>
<?php
if (isset($_POST['proses'])) {
  include '../koneksi.php';
  $id_pegawai = $_GET['id_pegawai'];
  $nama_pegawai = $_POST['nama_pegawai'];
  $jabatan = $_POST['jabatan'];

  mysqli_query($conn, "UPDATE pegawai SET nama_pegawai='$nama_pegawai',jabatan='$jabatan' WHERE id_pegawai='$id_pegawai'");
  header("location:pegawai-lihat.php");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>pelanggan-tambah</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="theme-color" content="#1a1a1a"> <!-- warna tab browser -->
  <link rel="icon" type="image/png" sizes="350x350" href="../images/logo3.PNG">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../css/style.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }

    #sidebar {
      background: #2c3e50;
      color: white;
      transition: all 0.3s;
    }

    #sidebar .components a {
      color: #ecf0f1;
      padding: 12px 15px;
      border-left: 3px solid transparent;
      transition: all 0.3s;
      display: flex;
      align-items: center;
    }

    #sidebar .components a i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    #sidebar .components a:hover {
      color: #f39c12;
      background-color: #34495e;
      border-left: 3px solid #f39c12;
    }

    #sidebar .components .active a {
      color: #f39c12;
      background-color: #34495e;
      border-left: 3px solid #f39c12;
    }

    .main-content {
      padding: 30px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .form-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
      padding: 25px;
      margin-top: 30px;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding: 15px 0;
    }

    .page-title {
      font-size: 1.4rem;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
      padding-top: 10px;
    }

    .form-group {
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }

    .form-label {
      width: 150px;
      font-weight: 500;
      color: #2c3e50;
      margin-bottom: 0;
    }

    .form-control {
      flex: 1;
      padding: 10px 15px;
      border-radius: 5px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .btn {
      padding: 8px 20px;
      font-weight: 500;
      border-radius: 5px;
      transition: all 0.3s;
    }

    .btn-success {
      background-color: #2ecc71;
      border-color: #2ecc71;
    }

    .btn-success:hover {
      background-color: #27ae60;
      border-color: #27ae60;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
      background-color: #e74c3c;
      border-color: #e74c3c;
    }

    .btn-danger:hover {
      background-color: #c0392b;
      border-color: #c0392b;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-warning {
      background-color: #f39c12;
      border-color: #f39c12;
      color: white;
    }

    .btn-warning:hover {
      background-color: #e67e22;
      border-color: #e67e22;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 20px;
    }

    .logo-img {
      width: 130px;
      height: auto;
      border-radius: 50%;
      border: 3px solid #f39c12;
      padding: 5px;
      background: white;
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 20px 15px;
      }
      
      .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
      
      .form-group {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .form-label {
        width: 100%;
        margin-bottom: 5px;
      }
      
      .form-control {
        width: 100%;
      }
      
      .action-buttons {
        justify-content: center;
      }
    }
  </style>
</head>
  <body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="p-4 pt-5 text-center">
        <img src="../images/logo1.png" alt="Logo" class="logo-img mb-4">
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php"><i class="fas fa-home"></i> Home</a></li>
           <li><a href="../pelanggan/pelanggan-lihat.php"><i class="fas fa-users"></i> Pelanggan</a></li>
          <li><a href="../barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
         <li class="active"><a href="#pegawai" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li><a href="../pembelian/pembelian-lihat.php"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="../nota/nota-lihat.php"><i class="fas fa-file-invoice"></i> Nota</a></li>
          <li>
            <a href="../index.php" onclick="return confirm('yakin keluar?')"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
        <div class="footer">
          <p>
            Mbd &copy;<script>document.write(new Date().getFullYear());</script>
          </p>
        </div>
      </div>
    </nav>


    <!-- Page Content -->
     <div id="content" class="main-content">
      <div class="page-header">
        <h1 class="page-title">Tambah Pegawai</h1>
        <a href="pegawai-lihat.php" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-list"></i> LIHAT DATA
        </a>
      </div>

      <div class="form-container">
        <form action="" method="post">

            <div class="form-group">
                <label class="id_pegawai" style="display: inline-block; width: 100px;">ID Pegawai</label>
                <input type="text" name="id_pegawai" class="form-control" value="<?= $data['id_pegawai'] ?>" readonly>
            </div>

            <div class="form-group">
                <label class="nama_pegawai" style="display: inline-block; width: 100px;">Nama Pegawai</label>
                <input type="text" name="nama_pegawai" class="form-control" value="<?= $data['nama_pegawai'] ?>" required>
            </div>

            <div class="form-group">
                <label class="jabatan" style="display: inline-block; width: 100px;">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan'] ?>" required>
            </div>

            <div class="action-buttons">
            <a href="pegawai-lihat.php" class="btn btn-danger">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" name="proses" class="btn btn-success">
              <i class="fas fa-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>
</body>

</html>