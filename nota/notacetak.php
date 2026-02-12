<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="theme-color" content="#1a1a1a"> <!-- warna tab browser -->
  <link rel="icon" type="image/png" sizes="75x75" href="../images/logo3.PNG">
    <meta charset="UTF-8">
    <title>Cetak Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: left;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-address {
            font-size: 12px;
            line-height: 1.3;
        }

        .logo-container {
            text-align: right;
            margin-top: -20px;
        }

        .logo-container img {
            width: 150px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            text-align: center;
        }

        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .stamp {
            width: 185px; /* Diperbesar dari 200px */
            height: auto;
            display: inline-block;
            margin: 0;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-box {
            width: 48%;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .text-right {
            text-align: right;
        }

        .invoice-title {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="header-container">
    <div class="company-info">
        <div class="company-name">UD. ADI JAYA BERKAH</div>
        <div class="company-address">
            Jl. Johar Baru V/15 RT.015 RW.009<br>
            Kelurahan Johar Baru, Jakarta Pusat<br>
            Telp: 0878 8549 4985
        </div>
    </div>
    <div class="logo-container">
        <img src="../images/logo1.PNG" alt="Logo">
    </div>
</div>

<?php
include '../koneksi.php';

if (!isset($_GET['id_penjualan'])) {
    echo "<p>Error: ID penjualan tidak ditemukan.</p>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id_penjualan']);

$query = mysqli_query($conn, "
    SELECT p.*, pl.nama_pelanggan, pl.alamat, pl.no_telepon, pg.nama_pegawai
    FROM penjualan p
    JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
    JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
    WHERE p.id_penjualan = '$id'
");

if (!$query || mysqli_num_rows($query) == 0) {
    echo "<p>Data penjualan tidak ditemukan.</p>";
    exit;
}

$data = mysqli_fetch_assoc($query);
$tanggal = date('d/m/Y', strtotime($data['tanggal']));

$items = mysqli_query($conn, "
    SELECT b.nama_barang, dp.banyaknya, b.harga_satuan, dp.jumlah
    FROM detail_penjualan dp
    JOIN barang b ON dp.kode_barang = b.kode_barang
    WHERE dp.id_penjualan = '$id'
");
?>

<div class="invoice-title">
    <h1 style="margin: 5px 0; color: #333;">INVOICE PENJUALAN</h1>
    <h3 style="margin: 5px 0; color: #555;"><?= htmlspecialchars($data['id_penjualan']) ?></h3>
    <p style="margin: 5px 0; color: #777;">Tanggal: <?= $tanggal ?></p>
</div>

<div class="info-section">
    <div class="info-box">
        <div class="info-title">PELANGGAN:</div>
        <div><strong><?= htmlspecialchars($data['nama_pelanggan']) ?></strong></div>
        <div><?= htmlspecialchars($data['alamat']) ?></div>
        <div>Telp: <?= htmlspecialchars($data['no_telepon']) ?></div>
    </div>
    <div class="info-box">
        <div class="info-title">INFORMASI:</div>
        <div>Pegawai: <?= htmlspecialchars($data['nama_pegawai']) ?></div>
        
    </div>
</div>

<!-- Detail Barang -->
<div style="margin-top: 25px;">
    <div style="text-align: center; margin-bottom: 20px; position: relative;">
        <h3 style="margin: 0; color: #333; display: inline-block; padding: 0 15px; background: white; position: relative; z-index: 1;">
            DETAIL BARANG
        </h3>
        <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #ddd; z-index: 0; margin-top: -1px;"></div>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
        <thead>
            <tr style="background-color: #f5f5f5; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">
                <th style="padding: 10px 8px; text-align: center; width: 10%;">Qty</th>
                <th style="padding: 10px 8px; text-align: left; width: 45%;">Nama Barang</th>
                <th style="padding: 10px 8px; text-align: right; width: 20%;">Harga Satuan</th>
                <th style="padding: 10px 8px; text-align: right; width: 25%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal = 0;
            mysqli_data_seek($items, 0);
            while ($item = mysqli_fetch_assoc($items)) {
                $subtotal += $item['jumlah'];
            ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 8px; text-align: center;"><?= htmlspecialchars($item['banyaknya']) ?></td>
                <td style="padding: 8px; text-align: left;"><?= htmlspecialchars($item['nama_barang']) ?></td>
                <td style="padding: 8px; text-align: right;">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                <td style="padding: 8px; text-align: right;">Rp <?= number_format($item['jumlah'], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr style="border-top: 1px solid #ddd;">
                <td colspan="3" style="padding: 12px 8px; text-align: right; font-size: 14px;">
                    <strong>Subtotal:</strong>
                </td>
                <td style="padding: 12px 8px; text-align: right; font-size: 14px;">
                    <strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 8px; text-align: right; font-size: 14px;">
                    <strong>DP:</strong>
                </td>
                <td style="padding: 8px; text-align: right; font-size: 14px;">
                    Rp <?= number_format($data['dp'], 0, ',', '.') ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 8px; text-align: right; font-size: 14px;">
                    <strong>Sisa:</strong>
                </td>
                <td style="padding: 8px; text-align: right; font-size: 14px;">
                    Rp <?= number_format($data['sisa'], 0, ',', '.') ?>
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td colspan="3" style="padding: 12px 8px; text-align: right; font-size: 16px;">
                    <strong>TOTAL:</strong>
                </td>
                <td style="padding: 12px 8px; text-align: right; font-size: 16px;">
                    <strong>Rp <?= number_format($data['jumlah_rp'], 0, ',', '.') ?></strong>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Tanda Tangan - Hanya stempel yang diperbesar -->
<div class="signature">
    <div style="display: inline-block; text-align: center;">
        <img src="../images/logo6.PNG" alt="Stempel LUNAS" class="stamp">
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>