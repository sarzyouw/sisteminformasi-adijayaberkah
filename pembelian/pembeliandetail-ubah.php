<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $id_pembelian = $_GET['id_pembelian'];
    $kode_bahanbaku = $_GET['kode_bahanbaku'];
    $banyaknya = $_POST['banyaknya'];

    // Validasi input
    if (empty($id_pembelian) || empty($kode_bahanbaku) || empty($banyaknya)) {
        die("<script>alert('Data tidak lengkap!');window.history.back();</script>");
    }

    // Get harga satuan from bahanbaku table
    $query_harga = mysqli_query($conn, "SELECT harga_satuan FROM bahanbaku WHERE kode_bahanbaku = '$kode_bahanbaku'");
    $data_harga = mysqli_fetch_array($query_harga);
    
    if (!$data_harga) {
        die("<script>alert('Bahan baku tidak ditemukan!');window.history.back();</script>");
    }

    $harga_satuan = $data_harga['harga_satuan'];
    $jumlah = $banyaknya * $harga_satuan;

    // Get previous amount for this item
    $query_old = mysqli_query($conn, "SELECT jumlah FROM detail_pembelian WHERE id_pembelian = '$id_pembelian' AND kode_bahanbaku = '$kode_bahanbaku'");
    $old_data = mysqli_fetch_array($query_old);
    $old_jumlah = $old_data['jumlah'];

    // Update detail pembelian
    $query_update = $conn->prepare("UPDATE detail_pembelian SET banyaknya = ?, jumlah = ? WHERE id_pembelian = ? AND kode_bahanbaku = ?");
    $query_update->bind_param("idss", $banyaknya, $jumlah, $id_pembelian, $kode_bahanbaku);
    $result_update = $query_update->execute();

    if ($result_update) {
        // Update total in pembelian table
        $query_total = $conn->prepare("UPDATE pembelian SET jumlah_rp = jumlah_rp - ? + ? WHERE id_pembelian = ?");
        $query_total->bind_param("dds", $old_jumlah, $jumlah, $id_pembelian);
        $result_total = $query_total->execute();
        
        if ($result_total) {
            header("Location: pembeliandetail-lihat.php?id_pembelian=$id_pembelian");
            exit;
        } else {
            die("<script>alert('Gagal update total pembelian!');window.history.back();</script>");
        }
    } else {
        die("<script>alert('Gagal update detail pembelian!');window.history.back();</script>");
    }
}

// Ambil data untuk tampilan form
if (isset($_GET['id_pembelian']) && isset($_GET['kode_bahanbaku'])) {
    $id_pembelian = $_GET['id_pembelian'];
    $kode_bahanbaku = $_GET['kode_bahanbaku'];

    // Get pembelian data
    $query_pembelian = mysqli_query($conn, "SELECT p.*, s.nama_supplier, pg.nama_pegawai 
                                          FROM pembelian p
                                          JOIN supplier s ON p.id_supplier = s.id_supplier
                                          JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                          WHERE p.id_pembelian = '$id_pembelian'");
    if ($query_pembelian) {
        $data_pembelian = mysqli_fetch_array($query_pembelian);
    } else {
        die("Error: " . mysqli_error($conn));
    }

    // Get detail pembelian data
    $query_detail = mysqli_query($conn, "SELECT dp.*, b.nama_bahanbaku, b.harga_satuan 
                                       FROM detail_pembelian dp
                                       JOIN bahanbaku b ON dp.kode_bahanbaku = b.kode_bahanbaku
                                       WHERE dp.id_pembelian = '$id_pembelian' AND dp.kode_bahanbaku = '$kode_bahanbaku'");
    if ($query_detail) {
        $data = mysqli_fetch_array($query_detail);
    } else {
        die("Error: " . mysqli_error($conn));
    }

    // Format tanggal
    $tanggal = date('d/m/Y', strtotime($data_pembelian['tanggal']));
} else {
    die("<script>alert('ID Pembelian atau Kode Bahan Baku tidak disediakan!');window.location='pembelian-lihat.php';</script>");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Ubah Detail Pembelian</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#1a1a1a">
  <link rel="icon" type="image/png" sizes="128x128" href="../images/logo3.PNG">
  <link rel="apple-touch-icon" sizes="180x180" href="../images/logo3.PNG">
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
      margin-bottom: 30px;
    }

    .table-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-top: 30px;
    }

    table.dataTable {
      width: 100% !important;
      border-collapse: collapse !important;
      margin: 0 !important;
    }

    table.dataTable thead th {
      background-color: #3498db;
      color: white;
      font-weight: 500;
      border: none;
      padding: 12px 15px;
      font-size: 0.9rem;
      text-align: center;
    }

    table.dataTable tbody td {
      padding: 12px 15px;
      vertical-align: middle;
      border-top: 1px solid #f1f1f1;
      font-size: 0.9rem;
    }

    table.dataTable tbody tr:hover {
      background-color: #f8f9fa;
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

    .btn-primary {
      background-color: #3498db;
      border-color: #3498db;
      min-width: 70px;
      padding: 5px 10px;
      font-size: 0.85rem;
    }

    .btn-info {
      background-color: #17a2b8;
      border-color: #17a2b8;
      min-width: 70px;
      padding: 5px 10px;
      font-size: 0.85rem;
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

    .currency {
      text-align: right;
      white-space: nowrap;
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
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../images/logo1.png);"></a>
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php"><i class="fa fa-home mr-3"></i> Home</a></li>
          <li><a href="../pelanggan/pelanggan-lihat.php"><i class="fa fa-users mr-3"></i> Pelanggan</a></li>
          <li><a href="../barang/barang-lihat.php"><i class="fa fa-box mr-3"></i> Barang</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fa fa-truck mr-3"></i> Supplier</a></li>
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fa fa-user-tie mr-3"></i> Pegawai</a></li>
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fa fa-cubes mr-3"></i> Bahan Baku</a></li>
          <li class="active"><a href="../pembelian/pembelian-lihat.php"><i class="fa fa-shopping-cart mr-3"></i> Pembelian</a></li>
          <li><a href="../penjualan/nota-lihat.php"><i class="fa fa-file-invoice mr-3"></i> Nota</a></li>
          <li>
            <a href="../index.php" onclick="return confirm('yakin keluar?')"><i class="fa fa-sign-out-alt mr-3"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
      <div class="form-container">
        <div class="page-header">
          <h1 class="page-title">Ubah Detail Pembelian</h1>
          <a href="pembeliandetail-lihat.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-warning">
            <i class="fa fa-arrow-left"></i> Kembali
          </a>
        </div>

        <form method="POST" action="">
          <input type="hidden" name="id_pembelian" value="<?php echo htmlspecialchars($data_pembelian['id_pembelian']); ?>">
          
          <div class="form-group">
            <label class="form-label">ID PEMBELIAN</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_pembelian['id_pembelian']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">TANGGAL</label>
            <input type="text" class="form-control" value="<?php echo $tanggal; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">SUPPLIER</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_pembelian['nama_supplier']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">PEGAWAI</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_pembelian['nama_pegawai']); ?>" readonly>
          </div>

          <hr>
          <h5>UBAH DETAIL BAHAN BAKU</h5>
          <hr>

          <div class="form-group">
            <label class="form-label">KODE BAHAN BAKU</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['kode_bahanbaku']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">NAMA BAHAN BAKU</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_bahanbaku']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">HARGA SATUAN</label>
            <input type="text" class="form-control currency" value="<?php echo 'Rp ' . number_format($data['harga_satuan'], 0, ',', '.'); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">BANYAKNYA</label>
            <input type="number" class="form-control" name="banyaknya" id="banyaknya" min="1" value="<?php echo htmlspecialchars($data['banyaknya']); ?>" required oninput="hitungTotal()">
          </div>

          <div class="form-group">
            <label class="form-label">JUMLAH</label>
            <input type="text" class="form-control currency" id="jumlah" name="jumlah" value="<?php echo 'Rp ' . number_format($data['jumlah'], 0, ',', '.'); ?>" readonly>
          </div>

          <div class="action-buttons">
            <button type="submit" name="proses" class="btn btn-success">
              <i class="fa fa-save"></i> Simpan Perubahan
            </button>
            <a href="pembeliandetail-lihat.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-danger">
              <i class="fa fa-times"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

  <script>
    // Format number as currency
    function formatCurrency(num) {
      return 'Rp ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    // Calculate total automatically
    function hitungTotal() {
      const banyaknya = document.getElementById('banyaknya').value;
      const hargaSatuan = <?php echo $data['harga_satuan']; ?>;
      
      if (banyaknya > 0) {
        const jumlah = hargaSatuan * banyaknya;
        document.getElementById('jumlah').value = formatCurrency(jumlah);
      } else {
        document.getElementById('jumlah').value = '';
      }
    }
  </script>
</body>
</html>