<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $id_penjualan = $_POST['id_penjualan'];
    $kode_barang = $_POST['kode_barang'];
    $banyaknya = $_POST['banyaknya'];

    // Validasi input
    if (empty($id_penjualan) || empty($kode_barang) || empty($banyaknya)) {
        die("<script>alert('Data tidak lengkap!');window.history.back();</script>");
    }

    // Get harga satuan from barang table
    $query_harga = mysqli_query($conn, "SELECT harga_satuan FROM barang WHERE kode_barang = '$kode_barang'");
    $data_harga = mysqli_fetch_array($query_harga);
    
    if (!$data_harga) {
        die("<script>alert('Barang tidak ditemukan!');window.history.back();</script>");
    }

    $harga_satuan = $data_harga['harga_satuan'];
    $jumlah = $banyaknya * $harga_satuan;

    // Insert detail penjualan
    $query_insert = $conn->prepare("INSERT INTO detail_penjualan (id_penjualan, kode_barang, banyaknya, jumlah) VALUES(?, ?, ?, ?)");
    $query_insert->bind_param("ssid", $id_penjualan, $kode_barang, $banyaknya, $jumlah);
    $result_insert = $query_insert->execute();

    if ($result_insert) {
        // Update total in penjualan table
        $query_update = $conn->prepare("UPDATE penjualan SET jumlah_rp = jumlah_rp + ? WHERE id_penjualan = ?");
        $query_update->bind_param("ds", $jumlah, $id_penjualan);
        $result_update = $query_update->execute();
        
        if ($result_update) {
            header("Location: notadetail-lihat.php?id_penjualan=$id_penjualan");
            exit;
        } else {
            die("<script>alert('Gagal update total penjualan!');window.history.back();</script>");
        }
    } else {
        die("<script>alert('Gagal menyimpan detail penjualan!');window.history.back();</script>");
    }
}

// Ambil data untuk tampilan form
if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];
    $query = mysqli_query($conn, "SELECT p.*, pl.nama_pelanggan, pg.nama_pegawai 
                                FROM penjualan p
                                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                                JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                WHERE p.id_penjualan = '$id_penjualan'");
    $data = mysqli_fetch_array($query);
    
    if (!$data) {
        die("<script>alert('Data penjualan tidak ditemukan!');window.location='nota-lihat.php';</script>");
    }
    
    // Format tanggal
    $tanggal = date('d/m/Y', strtotime($data['tanggal']));
} else {
    die("<script>alert('ID Penjualan tidak disediakan!');window.location='nota-lihat.php';</script>");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Tambah Baran Penjualan</title>
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
      <div class="p-4 pt-5 text-center">
        <img src="../images/logo1.png" alt="Logo" class="logo-img mb-4">
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php"><i class="fas fa-home"></i> Home</a></li>
          <li><a href="../pelanggan/pelanggan-lihat.php"><i class="fas fa-users"></i> Pelanggan</a></li>
          <li><a href="../barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li><a href="../pembelian/pembelian-lihat.php"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
          <li class="active"><a href="#nota-lihat.php" data-toggle="collapse" aria-expanded="false"><i class="fas fa-file-invoice"></i> Nota</a></li>
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
        <h1 class="page-title">Tambah Detail Penjualan</h1>
        <a href="notadetail-lihat.php?id_penjualan=<?php echo $id_penjualan; ?>" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
      </div>

      <div class="form-container">
        <form method="POST" action="">
          <input type="hidden" name="id_penjualan" value="<?php echo htmlspecialchars($data['id_penjualan']); ?>">
          
          <div class="form-group">
            <label class="form-label">ID PENJUALAN</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['id_penjualan']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">TANGGAL</label>
            <input type="text" class="form-control" value="<?php echo $tanggal; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">PELANGGAN</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">PEGAWAI</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_pegawai']); ?>" readonly>
          </div>

          <hr>
          <h5>TAMBAH DETAIL BARANG</h5>
          <hr>

          <div class="form-group">
            <label class="form-label">BARANG</label>
            <select class="form-control" name="kode_barang" id="kode_barang" required>
              <option value="">-- Pilih Barang --</option>
              <?php
              $query_barang = mysqli_query($conn, "SELECT * FROM barang");
              while ($barang = mysqli_fetch_array($query_barang)) {
                  echo '<option value="'.htmlspecialchars($barang['kode_barang']).'" data-harga="'.htmlspecialchars($barang['harga_satuan']).'">';
                  echo htmlspecialchars($barang['kode_barang'].' - '.$barang['nama_barang'].' (Rp '.number_format($barang['harga_satuan'], 0, ',', '.').')');
                  echo '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">BANYAKNYA</label>
            <input type="number" class="form-control" name="banyaknya" id="banyaknya" min="1" required>
          </div>

          <div class="form-group">
            <label class="form-label">HARGA SATUAN</label>
            <input type="text" class="form-control currency" id="harga_satuan" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">JUMLAH</label>
            <input type="text" class="form-control currency" id="jumlah" name="jumlah" readonly>
          </div>

          <div class="action-buttons">
            <button type="submit" name="proses" class="btn btn-success">
              <i class="fas fa-save"></i> SIMPAN
            </button>
            <a href="notadetail-lihat.php?id_penjualan=<?php echo $id_penjualan; ?>" class="btn btn-danger">
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
      // Format number as currency
      function formatCurrency(num) {
        return 'Rp ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }

      // Calculate total automatically
      $('#kode_barang, #banyaknya').change(function() {
        const kodeBarang = $('#kode_barang');
        const banyaknya = $('#banyaknya').val();
        const hargaSatuan = kodeBarang.find(':selected').data('harga');
        
        if (hargaSatuan && banyaknya > 0) {
          const jumlah = hargaSatuan * banyaknya;
          $('#harga_satuan').val(formatCurrency(hargaSatuan));
          $('#jumlah').val(formatCurrency(jumlah));
        } else {
          $('#harga_satuan').val('');
          $('#jumlah').val('');
        }
      });
    });
  </script>
</body>
</html>