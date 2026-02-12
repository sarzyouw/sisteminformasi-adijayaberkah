<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['selesai'])) {
    $id_pembelian = $_POST['id_pembelian'];
    $kode_bahanbaku = $_POST['kode_bahanbaku'];
    $banyaknya = $_POST['banyaknya'];

    // Validasi input
    if (empty($id_pembelian) || empty($kode_bahanbaku) || empty($banyaknya)) {
        die("<script>alert('Data tidak lengkap!');window.history.back();</script>");
    }

    // Proses setiap item
    foreach ($kode_bahanbaku as $index => $kb) {
        $kb_value = $kb;
        $banyaknya_value = $banyaknya[$index];

        // Get harga satuan dari tabel bahanbaku
        $query_harga = mysqli_query($conn, "SELECT harga_satuan FROM bahanbaku WHERE kode_bahanbaku = '$kb_value'");
        $data_harga = mysqli_fetch_array($query_harga);
        
        if (!$data_harga) {
            die("<script>alert('Bahan baku dengan kode $kb_value tidak ditemukan!');window.history.back();</script>");
        }

        $harga_satuan = $data_harga['harga_satuan'];
        $jumlah = $banyaknya_value * $harga_satuan;

        // Insert detail pembelian
        $query_insert = $conn->prepare("INSERT INTO detail_pembelian (id_pembelian, kode_bahanbaku, banyaknya, jumlah) VALUES(?, ?, ?, ?)");
        $query_insert->bind_param("ssid", $id_pembelian, $kb_value, $banyaknya_value, $jumlah);
        $result_insert = $query_insert->execute();

        if ($result_insert) {
            // Update total in pembelian table
            $query_update = $conn->prepare("UPDATE pembelian SET jumlah_rp = jumlah_rp + ? WHERE id_pembelian = ?");
            $query_update->bind_param("ds", $jumlah, $id_pembelian);
            $result_update = $query_update->execute();
        } else {
            die("<script>alert('Gagal menyimpan detail pembelian untuk item $kb_value!');window.history.back();</script>");
        }
    }

    // Arahkan ke pembelian-lihat.php setelah selesai
    header("Location: pembelian-lihat.php");
    exit();
}

// Ambil data untuk tampilan form
if (isset($_GET['id_pembelian'])) {
    $id_pembelian = $_GET['id_pembelian'];
    $query = mysqli_query($conn, "SELECT p.*, s.nama_supplier, pg.nama_pegawai 
                                FROM pembelian p
                                JOIN supplier s ON p.id_supplier = s.id_supplier
                                JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
                                WHERE p.id_pembelian = '$id_pembelian'");
    $data = mysqli_fetch_array($query);
    
    if (!$data) {
        die("<script>alert('Data pembelian tidak ditemukan!');window.location='pembelian-lihat.php';</script>");
    }
    
    // Format tanggal
    $tanggal = date('d/m/Y', strtotime($data['tanggal']));
} else {
    die("<script>alert('ID Pembelian tidak disediakan!');window.location='pembelian-lihat.php';</script>");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Tambah Bahan Baku Pembelian</title>
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
      text-decoration: none;
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

    .item-row {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
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

    .action-buttons {
      display: flex;
      gap: 8px;
      justify-content: center;
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
          <li><a href="../bahanbaku/bahanbaku-lihat.php"><i class="fas fa-box"></i> Bahan Baku</a></li>
          <li><a href="../supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
          <li><a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="../barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li class="active"><a href="../pembelian/pembelian-lihat.php"><i class="fas fa-cubes"></i>Pembelian</a></li>
          <li><a href="../penjualan/nota-lihat.php"><i class="fas fa-file-invoice"></i> Nota</a></li>
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
        <h1 class="page-title">Tambah Bahan Baku Pembelian</h1>
        <a href="pembeliandetail-lihat.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-warning shadow-sm font-weight-bold">
          <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
      </div>

      <div class="form-container">
        <form method="POST" action="">
          <input type="hidden" name="id_pembelian" value="<?php echo htmlspecialchars($data['id_pembelian']); ?>">
          
          <div class="form-group">
            <label class="form-label">ID PEMBELIAN</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['id_pembelian']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">TANGGAL</label>
            <input type="text" class="form-control" value="<?php echo $tanggal; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">SUPPLIER</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_supplier']); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">PEGAWAI</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_pegawai']); ?>" readonly>
          </div>

          <hr>
          <h5>TAMBAH DETAIL PEMBELIAN BAHAN BAKU</h5>
          <hr>

          <div id="item-container">
            <div class="item-row">
              <div class="form-group">
                <label class="form-label">BAHAN BAKU</label>
                <select class="form-control" name="kode_bahanbaku[]" id="kode_bahanbaku_0" required>
                  <option value="">-- Pilih Bahan Baku --</option>
                  <?php
                  $query_bahanbaku = mysqli_query($conn, "SELECT * FROM bahanbaku");
                  while ($bahanbaku = mysqli_fetch_array($query_bahanbaku)) {
                      echo '<option value="' . htmlspecialchars($bahanbaku['kode_bahanbaku']) . '" data-harga="' . htmlspecialchars($bahanbaku['harga_satuan']) . '">';
                      echo htmlspecialchars($bahanbaku['kode_bahanbaku'] . ' - ' . $bahanbaku['nama_bahanbaku'] . ' (Rp ' . number_format($bahanbaku['harga_satuan'], 0, ',', '.') . ')');
                      echo '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label">BANYAKNYA</label>
                <input type="number" class="form-control" name="banyaknya[]" id="banyaknya_0" min="1" required>
              </div>

              <div class="form-group">
                <label class="form-label">HARGA SATUAN</label>
                <input type="text" class="form-control currency" id="harga_satuan_0" readonly>
              </div>

              <div class="form-group">
                <label class="form-label">JUMLAH</label>
                <input type="text" class="form-control currency" id="jumlah_0" readonly>
              </div>
            </div>
          </div>

          <button type="button" id="add-item" class="btn btn-info mb-3"><i class="fas fa-plus"></i> Tambah Item</button>

          <div class="action-buttons">
            <button type="submit" name="selesai" class="btn btn-primary">
              <i class="fas fa-check"></i> Selesai
            </button>
            <a href="pembeliandetail-lihat.php?id_pembelian=<?php echo $id_pembelian; ?>" class="btn btn-danger">
              <i class="fas fa-times"></i> Batal
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
      let itemCount = 0;

      // Function to format currency
      function formatCurrency(num) {
        return 'Rp ' + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }

      // Add new item row
      $('#add-item').click(function() {
        itemCount++;
        const newRow = `
          <div class="item-row" id="item-row-${itemCount}">
            <div class="form-group">
              <label class="form-label">BAHAN BAKU</label>
              <select class="form-control" name="kode_bahanbaku[]" id="kode_bahanbaku_${itemCount}" required>
                <option value="">-- Pilih Bahan Baku --</option>
                <?php
                $query_bahanbaku = mysqli_query($conn, "SELECT * FROM bahanbaku");
                while ($bahanbaku = mysqli_fetch_array($query_bahanbaku)) {
                    echo '<option value="' . htmlspecialchars($bahanbaku['kode_bahanbaku']) . '" data-harga="' . htmlspecialchars($bahanbaku['harga_satuan']) . '">';
                    echo htmlspecialchars($bahanbaku['kode_bahanbaku'] . ' - ' . $bahanbaku['nama_bahanbaku'] . ' (Rp ' . number_format($bahanbaku['harga_satuan'], 0, ',', '.') . ')');
                    echo '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">BANYAKNYA</label>
              <input type="number" class="form-control" name="banyaknya[]" id="banyaknya_${itemCount}" min="1" required>
            </div>

            <div class="form-group">
              <label class="form-label">HARGA SATUAN</label>
              <input type="text" class="form-control currency" id="harga_satuan_${itemCount}" readonly>
            </div>

            <div class="form-group">
              <label class="form-label">JUMLAH</label>
              <input type="text" class="form-control currency" id="jumlah_${itemCount}" readonly>
            </div>
            <button type="button" class="btn btn-danger remove-item" data-index="${itemCount}"><i class="fas fa-trash"></i> Hapus</button>
          </div>
        `;
        $('#item-container').append(newRow);

        // Initialize calculation for new row
        calculateTotal(itemCount);
      });

      // Remove item row
      $(document).on('click', '.remove-item', function() {
        const index = $(this).data('index');
        $('#item-row-' + index).remove();
      });

      // Calculate total for each row
      function calculateTotal(index) {
        const kodeBahanBaku = $('#kode_bahanbaku_' + index);
        const banyaknya = $('#banyaknya_' + index);
        const hargaSatuanField = $('#harga_satuan_' + index);
        const jumlahField = $('#jumlah_' + index);

        kodeBahanBaku.change(function() {
          const hargaSatuan = $(this).find(':selected').data('harga');
          const qty = banyaknya.val() || 0;
          if (hargaSatuan && qty > 0) {
            const jumlah = hargaSatuan * qty;
            hargaSatuanField.val(formatCurrency(hargaSatuan));
            jumlahField.val(formatCurrency(jumlah));
          } else {
            hargaSatuanField.val('');
            jumlahField.val('');
          }
        });

        banyaknya.change(function() {
          const hargaSatuan = kodeBahanBaku.find(':selected').data('harga');
          const qty = $(this).val() || 0;
          if (hargaSatuan && qty > 0) {
            const jumlah = hargaSatuan * qty;
            hargaSatuanField.val(formatCurrency(hargaSatuan));
            jumlahField.val(formatCurrency(jumlah));
          } else {
            hargaSatuanField.val('');
            jumlahField.val('');
          }
        });
      }

      // Initialize calculation for the first row
      calculateTotal(0);
    });
  </script>
</body>
</html>