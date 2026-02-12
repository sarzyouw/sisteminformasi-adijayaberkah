<?php
include '../koneksi.php';

// Get the kode_bahanbaku from URL parameter
$kode_bahanbaku = isset($_GET['kode_bahanbaku']) ? $_GET['kode_bahanbaku'] : '';

// Fetch existing data
$query = $conn->prepare("SELECT * FROM bahanbaku WHERE kode_bahanbaku = ?");
$query->bind_param("s", $kode_bahanbaku);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $kode_bahanbaku = $_POST['kode_bahanbaku'];
    $nama_bahanbaku = $_POST['nama_bahanbaku'];
    $harga_satuan = $_POST['harga_satuan'];

    // Validasi input
    if (empty($kode_bahanbaku) || empty($nama_bahanbaku) || empty($harga_satuan)) {
        die("<script>alert('Data tidak lengkap!');window.history.back();</script>");
    }

    // Konversi harga satuan ke format angka
    $harga_satuan = str_replace('.', '', $harga_satuan);
    $harga_satuan = str_replace(',', '.', $harga_satuan);

    // Update bahan baku
    $query_update = $conn->prepare("UPDATE bahanbaku SET nama_bahanbaku = ?, harga_satuan = ? WHERE kode_bahanbaku = ?");
    $query_update->bind_param("sds", $nama_bahanbaku, $harga_satuan, $kode_bahanbaku);
    $result_update = $query_update->execute();

    if ($result_update) {
        header("Location: bahanbaku-lihat.php");
        exit;
    } else {
        die("<script>alert('Gagal mengupdate bahan baku!');window.history.back();</script>");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Ubah Bahan Baku</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#1a1a1a">
  <link rel="icon" type="image/png" sizes="128x128" href="../images/logo3.PNG">
  <link rel="apple-touch-icon" sizes="180x180" href="../images/logo3.PNG">
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
      margin-bottom: 30px;
    }

    .btn-success {
      background-color: #2ecc71;
      border-color: #2ecc71;
      min-width: 70px;
      padding: 5px 10px;
      font-size: 0.85rem;
    }

    .btn-danger {
      background-color: #e74c3c;
      border-color: #e74c3c;
      min-width: 70px;
      padding: 5px 10px;
      font-size: 0.85rem;
    }

    .btn-warning {
      background-color: #f39c12;
      border-color: #f39c12;
      color: white;
      font-weight: 500;
      transition: all 0.3s;
      padding: 8px 15px;
      font-size: 0.9rem;
    }

    .btn-warning:hover {
      background-color: #e67e22;
      border-color: #e67e22;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .action-buttons {
      display: flex;
      gap: 8px;
      justify-content: center;
    }

    .footer p {
      color: #bdc3c7;
      font-size: 0.8rem;
    }

    .logo-img {
      width: 130px;
      height: auto;
      border-radius: 50%;
      border: 3px solid #f39c12;
      padding: 5px;
      background: white;
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
      margin-bottom: 15px;
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

    .form-control[readonly] {
      background-color: #f8f9fa;
      cursor: not-allowed;
    }

    .currency-input {
      text-align: right;
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 20px 15px;
      }

      .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
      }

      .action-buttons {
        flex-direction: column;
        gap: 5px;
      }
      
      .form-group {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .form-label {
        width: 100%;
        margin-bottom: 5px;
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
          <li class="active"><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
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

    <!-- Page Content  -->
    <div id="content" class="main-content">
      <div class="page-header">
        <h1 class="page-title">Ubah Bahan Baku</h1>
        <a href="bahanbaku-lihat.php" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
      </div>

      <div class="form-container">
        <form method="POST" action="">
          <div class="form-group">
            <label class="form-label">KODE BAHAN BAKU</label>
            <input type="text" class="form-control" name="kode_bahanbaku" value="<?php echo htmlspecialchars($data['kode_bahanbaku'] ?? ''); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">NAMA BAHAN BAKU</label>
            <input type="text" class="form-control" name="nama_bahanbaku" value="<?php echo htmlspecialchars($data['nama_bahanbaku'] ?? ''); ?>" required>
          </div>

          <div class="form-group">
            <label class="form-label">HARGA SATUAN</label>
            <input type="text" class="form-control currency-input" name="harga_satuan" id="harga_satuan" 
                   value="<?php echo isset($data['harga_satuan']) ? number_format($data['harga_satuan'], 0, ',', '.') : ''; ?>" required>
          </div>

          <div class="action-buttons">
            <button type="submit" name="proses" class="btn btn-success">
              <i class="fas fa-save"></i> SIMPAN PERUBAHAN
            </button>
            <a href="bahanbaku-lihat.php" class="btn btn-danger">
              <i class="fas fa-times"></i> BATAL
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

  <script>
    $(document).ready(function() {
      // Format input harga satuan
      $('#harga_satuan').on('keyup', function(e) {
        // Hapus karakter selain angka
        let value = this.value.replace(/\D/g, '');
        
        // Format dengan titik sebagai pemisah ribuan
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        this.value = value;
      });
    });
  </script>
</body>
</html>