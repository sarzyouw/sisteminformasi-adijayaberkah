<?php
include '../koneksi.php';

// Check if kode_barang parameter exists
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];
    
    // Get main barang data
    $query_barang = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
    $data_barang = mysqli_fetch_array($query_barang);
    
    if (!$data_barang) {
        die("Data barang tidak ditemukan.");
    }
    
    // Get detail bahan baku for this barang
    $query_detail = mysqli_query($conn, "SELECT db.*, b.nama_bahanbaku 
                                      FROM detail_bahanbaku db
                                      JOIN bahanbaku b ON db.kode_bahanbaku = b.kode_bahanbaku
                                      WHERE db.kode_barang = '$kode_barang'");
    
} else {
    die("Kode Barang tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Detail Barang</title>
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

    .btn-info {
      background-color: #3498db;
      border-color: #3498db;
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
      flex-wrap: wrap;
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

    .dataTables_wrapper {
      padding: 15px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 5px 10px;
      margin: 0 2px;
      border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: #3498db;
      color: white !important;
      border: 1px solid #3498db;
    }

    .dataTables_info,
    .dataTables_length,
    .dataTables_filter {
      padding: 10px 15px;
    }

    .btn-sm {
      padding: 3px 8px;
      font-size: 0.75rem;
    }
    
    .btn-add {
      background-color: #2ecc71;
      border-color: #2ecc71;
      color: white;
    }
    
    .btn-add:hover {
      background-color: #27ae60;
      border-color: #27ae60;
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
          <li class="active"><a href="../barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li><a href="../pembelian/pembelian-lihat.php"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
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

    <!-- Page Content  -->
    <div id="content" class="main-content">
      <div class="page-header">
        <h1 class="page-title">Detail Barang: <?php echo htmlspecialchars($data_barang['nama_barang']); ?></h1>
        <a href="../barang/barang-lihat.php" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
      </div>

      <div class="form-container">
        <div class="form-group">
          <label class="form-label">KODE BARANG</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_barang['kode_barang']); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label">NAMA BARANG</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_barang['nama_barang']); ?>" readonly>
        </div>

        <div class="form-group">
          <label class="form-label">HARGA SATUAN</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($data_barang['harga_satuan']); ?>" readonly>
        </div>
      </div>

      <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0">Bahan Baku yang Dibutuhkan</h4>
          <a href="barangdetail-tambah.php?kode_barang=<?php echo $kode_barang; ?>" class="btn btn-add">
            <i class="fas fa-plus"></i> TAMBAH
          </a>
        </div>

        <table id="detail-table" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Bahan Baku</th>
              <th>Nama Bahan Baku</th>
              <th>Ukuran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($query_detail) > 0) {
                $no = 1;
                mysqli_data_seek($query_detail, 0); // Reset pointer
                
                while ($data_detail = mysqli_fetch_array($query_detail)) {
            ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($data_detail['kode_bahanbaku']); ?></td>
              <td><?php echo htmlspecialchars($data_detail['nama_bahanbaku']); ?></td>
              <td><?php echo htmlspecialchars($data_detail['ukuran']); ?></td>
              <td>
                <div class="action-buttons">
                  <a href="barangdetail-ubah.php?kode_barang=<?php echo $kode_barang; ?>&kode_bahanbaku=<?php echo $data_detail['kode_bahanbaku']; ?>" 
                     class="btn btn-success btn-sm">
                    <i class="fas fa-edit"></i> Ubah
                  </a>
                  <a href="barangdetail-hapus.php?kode_barang=<?php echo $kode_barang; ?>&kode_bahanbaku=<?php echo $data_detail['kode_bahanbaku']; ?>" 
                     class="btn btn-danger btn-sm" 
                     onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash"></i> Hapus
                  </a>
                </div>
              </td>
            </tr>
            <?php 
                } 
            } else {
            ?>
            <tr>
              <td colspan="5" class="text-center">Tidak ada bahan baku yang terdaftar untuk barang ini</td>
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