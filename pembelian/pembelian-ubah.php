<?php
include '../koneksi.php';

// Get data based on id_pembelian parameter
if(isset($_GET['id_pembelian'])) {
    $id_pembelian = $_GET['id_pembelian'];
    $query = mysqli_query($conn, "SELECT * FROM pembelian WHERE id_pembelian='$id_pembelian'");
    $data = mysqli_fetch_array($query);
}

// Update data when form is submitted
if(isset($_POST['proses'])) {
    $id_pembelian = $_POST['id_pembelian'];
    $id_supplier = $_POST['id_supplier'];
    $id_pegawai = $_POST['id_pegawai'];
    $no_nota = $_POST['no_nota'];
    $tanggal = $_POST['tanggal'];

    $update = mysqli_query($conn, "UPDATE pembelian SET 
        id_supplier='$id_supplier',
        id_pegawai='$id_pegawai',
        no_nota='$no_nota',
        tanggal='$tanggal'
        WHERE id_pembelian='$id_pembelian'");

    if($update) {
        header("Location: pembelian-lihat.php");
        exit();
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Ubah Pembelian</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#1a1a1a">
  <link rel="icon" type="image/png" sizes="75x75" href="../images/logo3.PNG">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    select.form-control {
      width: 100%;
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
      
      .form-control, select.form-control {
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
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li class="active"><a href="#pembelian-lihat.php" data-toggle="collapse" aria-expanded="false"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="../nota/nota-lihat.php"><i class="fas fa-file-invoice"></i> Nota</a></li>
          <li>
            <a href="../index.php" onclick="return confirm('yakin keluar?')"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
        <div class="footer">
          <p>
            Mbd ©<script>document.write(new Date().getFullYear());</script>
          </p>
        </div>
      </div>
    </nav>

    <div id="content" class="main-content">
      <div class="page-header">
        <h1 class="page-title">Ubah Data Pembelian</h1>
        <a href="pembelian-lihat.php" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-list"></i> LIHAT DATA
        </a>
      </div>

      <div class="form-container">
        <form action="" method="post">
          <input type="hidden" name="id_pembelian" value="<?php echo $data['id_pembelian']; ?>">
          
          <div class="form-group">
            <label for="id_pembelian_display" class="form-label">ID Pembelian</label>
            <input type="text" id="id_pembelian_display" class="form-control" value="<?php echo $data['id_pembelian']; ?>" disabled>
          </div>

          <div class="form-group">
            <label for="id_supplier" class="form-label">Supplier</label>
            <select class="form-control" name="id_supplier" required>
              <option value="">---Pilih Supplier---</option>
              <?php
              $query_supplier = mysqli_query($conn, "SELECT * FROM supplier");
              while ($supplier = mysqli_fetch_array($query_supplier)) {
                $selected = ($supplier['id_supplier'] == $data['id_supplier']) ? 'selected' : '';
                echo '<option value="'.$supplier['id_supplier'].'" '.$selected.'>'.$supplier['nama_supplier'].'</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="id_pegawai" class="form-label">Pegawai</label>
            <select class="form-control" name="id_pegawai" required>
              <option value="">---Pilih Pegawai---</option>
              <?php
              $query_pegawai = mysqli_query($conn, "SELECT * FROM pegawai");
              while ($pegawai = mysqli_fetch_array($query_pegawai)) {
                $selected = ($pegawai['id_pegawai'] == $data['id_pegawai']) ? 'selected' : '';
                echo '<option value="'.$pegawai['id_pegawai'].'" '.$selected.'>'.$pegawai['nama_pegawai'].'</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="no_nota" class="form-label">No. Nota</label>
            <input type="text" name="no_nota" class="form-control" value="<?php echo $data['no_nota']; ?>" required>
          </div>

          <div class="form-group">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>" required>
          </div>

          <div class="action-buttons">
            <a href="pembelian-lihat.php" class="btn btn-danger">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" name="proses" class="btn btn-success">
              <i class="fas fa-save"></i> Simpan Perubahan
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