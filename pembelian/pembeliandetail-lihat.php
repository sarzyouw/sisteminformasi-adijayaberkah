<?php
include '../koneksi.php';

// Check if id_pembelian parameter exists
if (isset($_GET['id_pembelian'])) {
    $id_pembelian = $_GET['id_pembelian'];
    
    // Get main pembelian data
    $query_pembelian = mysqli_query($conn, "SELECT p.*, s.nama_supplier, pg.nama_pegawai 
                                         FROM pembelian p
                                         JOIN supplier s ON p.id_supplier = s.id_supplier
                                         JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                         WHERE p.id_pembelian = '$id_pembelian'");
    $data_pembelian = mysqli_fetch_array($query_pembelian);
    
    if (!$data_pembelian) {
        die("Data pembelian tidak ditemukan.");
    }
    
    // Format date
    $tanggal = date('d/m/Y', strtotime($data_pembelian['tanggal']));
    
    // Get detail items
    $query_detail = mysqli_query($conn, "SELECT dp.*, b.nama_bahanbaku, b.harga_satuan 
                                      FROM detail_pembelian dp
                                      JOIN bahanbaku b ON dp.kode_bahanbaku = b.kode_bahanbaku
                                      WHERE dp.id_pembelian = '$id_pembelian'");
    
} else {
    die("ID Pembelian tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Detail Pembelian</title>
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
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li class="active"><a href="../pembelian/pembelian-lihat.php"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
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
        <h1 class="page-title">Detail Pembelian</h1>
        <a href="pembelian-lihat.php" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
      </div>

      <div class="form-container">
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

        <div class="form-group">
          <label class="form-label">JUMLAH (RP)</label>
          <input type="text" class="form-control currency" value="<?php echo number_format($data_pembelian['jumlah_rp'], 0, ',', '.'); ?>" readonly>
        </div>
      </div>

      <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0">Detail Bahan Baku Pembelian</h4>
          <div>
            <a href="pembeliandetail-tambah.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-success">
              <i class="fas fa-plus"></i> TAMBAH BAHAN BAKU
            </a>
            <a href="pembeliancetak.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-primary">
              <i class="fas fa-print"></i> CETAK
            </a>
          </div>
        </div>

        <table id="detail-table" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Bahan Baku</th>
              <th>Nama Bahan Baku</th>
              <th>Banyaknya</th>
              <th>Harga Satuan</th>
              <th>Jumlah</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(mysqli_num_rows($query_detail) > 0) {
                $no = 1;
                $total = 0;
                mysqli_data_seek($query_detail, 0); // Reset pointer
                
                while ($data_detail = mysqli_fetch_array($query_detail)) {
                    $subtotal = $data_detail['banyaknya'] * $data_detail['harga_satuan'];
                    $total += $subtotal;
            ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($data_detail['kode_bahanbaku']); ?></td>
              <td><?php echo htmlspecialchars($data_detail['nama_bahanbaku']); ?></td>
              <td><?php echo htmlspecialchars($data_detail['banyaknya']); ?></td>
              <td class="currency"><?php echo number_format($data_detail['harga_satuan'], 0, ',', '.'); ?></td>
              <td class="currency"><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
              <td>
                <div class="action-buttons">
                  <a href="pembeliandetail-ubah.php?id_pembelian=<?php echo $id_pembelian; ?>&kode_bahanbaku=<?php echo $data_detail['kode_bahanbaku']; ?>" class="btn btn-success btn-sm">Ubah</a>
                  <a href="pembeliandetail-hapus.php?id_pembelian=<?php echo $id_pembelian; ?>&kode_bahanbaku=<?php echo $data_detail['kode_bahanbaku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </div>
              </td>
            </tr>
            <?php 
                } 
            ?>
            <tr>
              <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
              <td class="currency"><strong><?php echo number_format($total, 0, ',', '.'); ?></strong></td>
              <td></td>
            </tr>
            <?php
            } else {
            ?>
            <tr>
              <td colspan="7" class="text-center">Tidak ada data bahan baku</td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/main.js"></script>
  <script>
    $(document).ready(function() {
      $('#detail-table').DataTable({
        "language": {
          "lengthMenu": "Tampilkan _MENU_ data per halaman",
          "zeroRecords": "Data tidak ditemukan",
          "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
          "infoEmpty": "Tidak ada data tersedia",
          "infoFiltered": "(disaring dari _MAX_ total data)",
          "search": "Cari:",
          "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Selanjutnya",
            "previous": "Sebelumnya"
          }
        },
        "responsive": true,
        "autoWidth": false,
        "ordering": false,
        "dom": '<"top"lf>rt<"bottom"ip><"clear">'
      });
    });
  </script>
</body>
</html>