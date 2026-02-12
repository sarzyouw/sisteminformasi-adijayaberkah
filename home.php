<!doctype html>
<html lang="en">

<head>
  <title>Dashboard Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#1a1a1a">
  <link rel="icon" type="image/png" sizes="75x75" href="images/logo3.PNG">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #f39c12;
      --light: #f8f9fa;
      --dark: #343a40;
      --success: #28a745;
      --danger: #dc3545;
      --info: #17a2b8;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      min-height: 100vh;
    }
    
    #sidebar {
      background: var(--primary);
      color: white;
      transition: all 0.3s;
      min-width: 250px;
      max-width: 250px;
      min-height: 100vh;
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
      color: var(--secondary);
      background-color: #34495e;
      border-left: 3px solid var(--secondary);
    }
    
    #sidebar .components .active a {
      color: var(--secondary);
      background-color: #34495e;
      border-left: 3px solid var(--secondary);
    }
    
    .logo-img {
      width: 130px;
      height: auto;
      border-radius: 50%;
      border: 3px solid var(--secondary);
      padding: 5px;
      background: white;
    }
    
    .main-content {
      padding: 20px;
      width: 100%;
    }
    
    .card {
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: transform 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card-icon {
      font-size: 1.8rem;
      color: var(--secondary);
    }
    
    .card-value {
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .page-header {
      margin-bottom: 30px;
    }
    
    .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--dark);
    }
    
    .activity-card, .tool-card {
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      padding: 20px;
      height: 100%;
    }
    
    .activity-header, .tool-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .activity-icon, .tool-icon {
      font-size: 1.8rem;
      color: var(--secondary);
      margin-right: 15px;
    }
    
    .activity-title, .tool-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin: 0;
    }
    
    .item-details {
      list-style: none;
      padding: 0;
      margin: 0 0 20px 0;
    }
    
    .item-details li {
      margin-bottom: 10px;
      display: flex;
    }
    
    .item-label {
      font-weight: 600;
      min-width: 100px;
    }
    
    .log-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
    }
    
    .log-table th, .log-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #eee;
      vertical-align: top;
    }
    
    .log-table th {
      font-weight: 600;
      background-color: #f8f9fa;
    }
    
    .log-action {
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 600;
      color: white;
      display: inline-block;
    }
    
    .log-create { background-color: var(--success); }
    .log-read { background-color: var(--info); }
    .log-update { background-color: var(--secondary); }
    .log-delete { background-color: var(--danger); }
    
    .log-details {
      font-size: 0.8rem;
      color: #6c757d;
      margin-top: 3px;
    }
    
    .log-entity {
      font-weight: 600;
      color: var(--primary);
    }
    
    .btn-danger {
      background-color: var(--danger);
      border-color: var(--danger);
    }
    
    .footer p {
      color: #bdc3c7;
      font-size: 0.8rem;
    }
    
    .tool-form {
      margin-top: 15px;
    }
    
    .tool-form .form-group {
      margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
      .main-content { padding: 15px; }
      .activity-row, .tool-row { flex-direction: column; }
      .activity-col, .tool-col { margin-bottom: 20px; }
      .log-table { display: block; overflow-x: auto; }
    }
  </style>
</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
      <div class="p-4 pt-5 text-center">
        <img src="images/logo1.png" alt="Logo" class="logo-img mb-4">
        <ul class="list-unstyled components mb-5">
          <li class="active"><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
          <li><a href="pelanggan/pelanggan-lihat.php"><i class="fas fa-users"></i> Pelanggan</a></li>
          <li><a href="bahanbaku/bahanbaku-lihat.php"><i class="fas fa-cubes"></i> Bahan Baku</a></li>
          <li><a href="supplier/supplier-lihat.php"><i class="fas fa-truck"></i> Supplier</a></li>
          <li><a href="pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i> Pegawai</a></li>
          <li><a href="barang/barang-lihat.php"><i class="fas fa-box"></i> Barang</a></li>
          <li><a href="pembelian/pembelian-lihat.php"><i class="fas fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="nota/nota-lihat.php"><i class="fas fa-file-invoice"></i> Nota</a></li>
          <li>
            <a href="index.php" onclick="return confirm('yakin keluar?')"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
        <div class="footer">
          <p>
            Mbd ©<script>document.write(new Date().getFullYear());</script>
          </p>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
      <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">Dashboard Admin</h1>
        <small class="text-muted">
          Terakhir diperbarui: <?php echo date('d M Y, H:i A', strtotime('10:49 AM WIB')); ?> WIB
        </small>
      </div>

      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <div class="card-icon mb-3"><i class="fas fa-users"></i></div>
              <h5 class="card-title">Total Pelanggan</h5>
              <div class="card-value mb-2">
                <?php
                include 'koneksi.php';
                $query = "SELECT COUNT(*) AS total FROM pelanggan";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
              </div>
              <small class="text-muted"><?php echo date('M Y'); ?></small>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <div class="card-icon mb-3"><i class="fas fa-cubes"></i></div>
              <h5 class="card-title">Total Bahan Baku</h5>
              <div class="card-value mb-2">
                <?php
                $query = "SELECT COUNT(*) AS total FROM bahanbaku";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
              </div>
              <small class="text-muted"><?php echo date('M Y'); ?></small>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <div class="card-icon mb-3"><i class="fas fa-box"></i></div>
              <h5 class="card-title">Total Barang</h5>
              <div class="card-value mb-2">
                <?php
                $query = "SELECT COUNT(*) AS total FROM barang";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
              </div>
              <small class="text-muted"><?php echo date('M Y'); ?></small>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <div class="card-icon mb-3"><i class="fas fa-user-tie"></i></div>
              <h5 class="card-title">Total Pegawai</h5>
              <div class="card-value mb-2">
                <?php
                $query = "SELECT COUNT(*) AS total FROM pegawai";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
              </div>
              <small class="text-muted"><?php echo date('M Y'); ?></small>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts and Tools -->
      <div class="row">
        <!-- Last Sale -->
        <div class="col-md-6 mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-receipt"></i></div>
              <h4 class="activity-title">Penjualan Terakhir</h4>
            </div>
            <?php
            $query_last_sale = "SELECT id_penjualan, tanggal, jumlah_rp FROM penjualan ORDER BY tanggal DESC LIMIT 1";
            $result_last_sale = mysqli_query($conn, $query_last_sale);
            $last_sale = mysqli_fetch_assoc($result_last_sale);
            ?>
            <ul class="item-details">
              <li><span class="item-label">Kode Penjualan:</span> <span><?php echo $last_sale['id_penjualan'] ?? '-'; ?></span></li>
              <li><span class="item-label">Tanggal:</span> <span><?php echo $last_sale['tanggal'] ? date('d M Y', strtotime($last_sale['tanggal'])) : '-'; ?></span></li>
              <li><span class="item-label">Total Harga:</span> <span>Rp <?php echo $last_sale['jumlah_rp'] ? number_format($last_sale['jumlah_rp'], 0, ',', '.') : '0'; ?></span></li>
            </ul>
            <a href="nota/nota-lihat.php" class="btn btn-danger btn-block">
              <i class="fas fa-list"></i> Lihat Semua Penjualan
            </a>
          </div>
        </div>
        
<!-- Last Stock Update -->
        <div class="col-md-6 mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-warehouse"></i></div>
              <h4 class="activity-title">Barang Terakhir Diperbarui</h4>
            </div>
            <?php
          $query_last_stock = "SELECT kode_barang, nama_barang, harga_satuan FROM barang ORDER BY updated_at DESC LIMIT 1";

           $query_last_stock = "SELECT kode_barang, nama_barang, harga_satuan FROM barang ORDER BY kode_barang DESC LIMIT 1";

            ?>
            <ul class="item-details">
              <li><span class="item-label">Kode Barang:</span> <span><?php echo $last_stock['kode_barang'] ?? '-'; ?></span></li>
              <li><span class="item-label">Nama Barang:</span> <span><?php echo $last_stock['nama_barang'] ?? '-'; ?></span></li>
              <li><span class="item-label">Harga Satuan:</span> <span><?php echo $last_stock['harga_satuan'] ?? '0'; ?> unit</span></li>
            </ul>
            <a href="barang/barang-lihat.php" class="btn btn-danger btn-block">
              <i class="fas fa-list"></i> Lihat Semua Barang
            </a>
          </div>
        </div>

        <!-- Revenue Report -->
        <div class="col-md-6 mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-money-bill-wave"></i></div>
              <h4 class="activity-title">Laporan Pendapatan (Bulan Ini)</h4>
            </div>
            <?php
            $month_start = date('Y-m-01');
            $month_end = date('Y-m-t');
            $query_revenue = "SELECT SUM(jumlah_rp) AS total FROM penjualan WHERE tanggal BETWEEN '$month_start' AND '$month_end'";
            $result_revenue = mysqli_query($conn, $query_revenue);
            $revenue = mysqli_fetch_assoc($result_revenue);
            ?>
            <h5 class="text-center mb-3">Rp <?php echo number_format($revenue['total'] ?? 0, 0, ',', '.'); ?></h5>
            <a href="nota/nota-lihat.php" class="btn btn-danger btn-block">
              <i class="fas fa-file-pdf"></i> Lihat Laporan Lengkap
            </a>
          </div>
        </div>

        <!-- Production Cost Calculator -->
        <div class="col-md-6 mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-calculator"></i></div>
              <h4 class="activity-title">Kalkulator Biaya Produksi</h4>
            </div>
            <form class="tool-form" id="costCalculator" onsubmit="calculateCost(event)">
              <div class="form-group">
                <label for="itemSelect">Pilih Barang:</label>
                <select class="form-control" id="itemSelect" required>
                  <option value="">-- Pilih Barang --</option>
                  <?php
                  $query_items = "SELECT kode_barang, nama_barang FROM barang";
                  $result_items = mysqli_query($conn, $query_items);
                  while ($item = mysqli_fetch_assoc($result_items)) {
                      echo "<option value='{$item['kode_barang']}'>{$item['nama_barang']}</option>";
                  }
                  ?>
                </select>
              </div>
              <button type="submit" class="btn btn-success btn-block">Hitung Biaya</button>
            </form>
            <div id="costResult" class="mt-3"></div>
          </div>
        </div>
      </div>

      <!-- Recent Activity Section -->
      <div class="row mt-4 activity-row">
        <!-- Latest Item Added -->
        <div class="col-md-6 activity-col mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-box"></i></div>
              <h4 class="activity-title">Bahan Baku Terakhir Ditambahkan</h4>
            </div>
            <?php
            $query_last_item = "SELECT * FROM bahanbaku ORDER BY kode_bahanbaku DESC LIMIT 1";
            $result_last_item = mysqli_query($conn, $query_last_item);
            $last_item = mysqli_fetch_assoc($result_last_item);
            ?>
            <ul class="item-details">
              <li><span class="item-label">Kode:</span> <span><?php echo $last_item['kode_bahanbaku'] ?? '-'; ?></span></li>
              <li><span class="item-label">Nama:</span> <span><?php echo $last_item['nama_bahanbaku'] ?? '-'; ?></span></li>
              <li><span class="item-label">Harga Satuan:</span> <span>Rp <?php echo isset($last_item['harga_satuan']) ? number_format($last_item['harga_satuan'], 0, ',', '.') : '-'; ?></span></li>
            </ul>
            <a href="bahanbaku/bahanbaku-lihat.php" class="btn btn-danger btn-block">
              <i class="fas fa-list"></i> Lihat Semua Bahan Baku
            </a>
          </div>
        </div>
        
        <!-- Activity Log -->
        <div class="col-md-6 activity-col mb-4">
          <div class="activity-card">
            <div class="activity-header">
              <div class="activity-icon"><i class="fas fa-clipboard-list"></i></div>
              <h4 class="activity-title">Aktivitas Sistem</h4>
            </div>
            <table class="log-table">
              <thead>
                <tr><th>Aksi</th><th>Detail</th></tr>
              </thead>
              <tbody>
                <?php
                $create_table = "CREATE TABLE IF NOT EXISTS activity_log (
                  id INT AUTO_INCREMENT PRIMARY KEY,
                  username VARCHAR(50) NOT NULL,
                  action_type ENUM('CREATE', 'READ', 'UPDATE', 'DELETE') NOT NULL,
                  entity_type VARCHAR(50) NOT NULL,
                  entity_id VARCHAR(50),
                  description TEXT,
                  ip_address VARCHAR(45),
                  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                mysqli_query($conn, $create_table);
                
                $query_log = "SELECT * FROM activity_log ORDER BY timestamp DESC LIMIT 5";
                $result_log = mysqli_query($conn, $query_log);
                if(mysqli_num_rows($result_log) > 0) {
                  while($log = mysqli_fetch_assoc($result_log)) {
                    $action_icon = '';
                    switch($log['action_type']) {
                      case 'CREATE': $action_icon = 'fa-plus-circle'; break;
                      case 'READ': $action_icon = 'fa-eye'; break;
                      case 'UPDATE': $action_icon = 'fa-edit'; break;
                      case 'DELETE': $action_icon = 'fa-trash-alt'; break;
                    }
                    echo '<tr><td><span class="log-action ';
                    echo ($log['action_type'] == 'CREATE' ? 'log-create' : ($log['action_type'] == 'READ' ? 'log-read' : ($log['action_type'] == 'UPDATE' ? 'log-update' : 'log-delete')));
                    echo '"><i class="fas '.$action_icon.' mr-1"></i>'.$log['action_type'].'</span></td><td><span class="log-entity">'.htmlspecialchars($log['entity_type']).'</span>';
                    echo ($log['entity_id'] ? '#' . htmlspecialchars($log['entity_id']) : '').'<div class="log-details">'.htmlspecialchars($log['description'] ?? '').'</div></td></tr>';
                  }
                } else {
                  echo '<tr><td colspan="2" class="text-center">Tidak ada aktivitas terakhir</td></tr>';
                }
                ?>
              </tbody>
            </table>
            <a href="log/log-lihat.php" class="btn btn-danger btn-block mt-3">
              <i class="fas fa-list"></i> Lihat Semua Aktivitas
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Production Cost Calculator
    function calculateCost(event) {
      event.preventDefault();
      const itemCode = document.getElementById('itemSelect').value;
      if (!itemCode) return;

      fetch(`get_production_cost.php?kode_barang=${itemCode}`)
        .then(response => response.json())
        .then(data => {
          const resultDiv = document.getElementById('costResult');
          if (data.error) {
            resultDiv.innerHTML = `<p class="text-danger">${data.error}</p>`;
          } else {
            resultDiv.innerHTML = `<p class="text-success">Biaya Produksi: Rp ${data.cost.toLocaleString()}</p>`;
          }
        })
        .catch(error => {
          document.getElementById('costResult').innerHTML = `<p class="text-danger">Error: ${error.message}</p>`;
        });
    }
  </script>
</body>
</html>