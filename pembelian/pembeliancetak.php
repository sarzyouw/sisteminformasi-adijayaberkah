<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="theme-color" content="#1a1a1a">
    <link rel="icon" type="image/png" sizes="75x75" href="../images/logo3.PNG">
    <meta charset="UTF-8">
    <title>Cetak Invoice Pembelian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 10mm 10mm 10mm 10mm;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
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
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .company-address {
            font-size: 12px;
            line-height: 1.3;
            color: #34495e;
        }
        .logo-container {
            text-align: right;
            margin-top: -20px;
        }
        .logo-container img {
            width: 150px;
            height: auto;
        }
        .invoice-title {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
        }
        .invoice-title h1 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
        }
        .invoice-title h3 {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .invoice-title p {
            margin: 5px 0;
            color: #777;
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
            background-color: #f9f9f9;
        }
        .info-title {
            font-weight: 600;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: #2c3e50;
        }
        .detail-section {
            margin-top: 25px;
        }
        .detail-header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .detail-header h3 {
            margin: 0;
            color: #333;
            display: inline-block;
            padding: 0 15px;
            background: white;
            position: relative;
            z-index: 1;
            font-size: 14px;
            font-weight: 600;
        }
        .detail-header div {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
            z-index: 0;
            margin-top: -1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 500;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: 600;
            background-color: #f9f9f9;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px; /* Ditambah padding untuk konsistensi */
            background-color: #f9f9f9;
            box-sizing: border-box; /* Pastikan padding tidak mengubah ukuran total */
        }
        .signature-box h4 {
            font-size: 12px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px; /* Jarak sebelum gambar */
        }
        .signature-box img {
            max-width: 150px; /* Ukuran konsisten dengan logo */
            height: auto; /* Menjaga proporsi */
            margin-bottom: 10px; /* Jarak sebelum nama */
        }
        .signature-name {
            font-size: 11px;
            color: #34495e;
            margin-top: 0; /* Disesuaikan agar rapi */
        }
        @media print {
            body {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
            .header-container {
                border-bottom: 2px solid #2c3e50;
            }
        }
    </style>
</head>
<body>

<?php
include '../koneksi.php';

if (!isset($_GET['id_pembelian'])) {
    die("ID Pembelian tidak ditemukan.");
}

$id_pembelian = mysqli_real_escape_string($conn, $_GET['id_pembelian']);

$queryPembelian = mysqli_query($conn, "
    SELECT p.*, s.nama_supplier, pg.nama_pegawai
    FROM pembelian p
    JOIN supplier s ON p.id_supplier = s.id_supplier
    JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
    WHERE p.id_pembelian = '$id_pembelian'
");
$data = mysqli_fetch_assoc($queryPembelian);
$tanggal = date('d/m/Y', strtotime($data['tanggal']));

$queryDetail = mysqli_query($conn, "
    SELECT dp.*, b.nama_bahanbaku, b.harga_satuan
    FROM detail_pembelian dp
    JOIN bahanbaku b ON dp.kode_bahanbaku = b.kode_bahanbaku
    WHERE dp.id_pembelian = '$id_pembelian'
");
$subtotal = 0;
while ($row = mysqli_fetch_assoc($queryDetail)) {
    $subtotal += $row['jumlah'];
}
?>

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

<div class="invoice-title">
    <h1>INVOICE PEMBELIAN</h1>
    <h3><?php echo htmlspecialchars($data['id_pembelian']); ?></h3>
    <p>Tanggal: <?php echo $tanggal; ?></p>
</div>

<div class="info-section">
    <div class="info-box">
        <div class="info-title">SUPPLIER:</div>
        <div><strong><?php echo htmlspecialchars($data['nama_supplier']); ?></strong></div>
    </div>
    <div class="info-box">
        <div class="info-title">INFORMASI:</div>
        <div>Penerima: <?php echo htmlspecialchars($data['nama_pegawai']); ?></div>
    </div>
</div>

<div class="detail-section">
    <div class="detail-header">
        <h3>DETAIL BAHAN BAKU</h3>
        <div></div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Qty</th>
                <th style="width: 50%;">Nama Barang</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($queryDetail, 0);
            while ($row = mysqli_fetch_assoc($queryDetail)) {
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo htmlspecialchars($row['banyaknya']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_bahanbaku']); ?></td>
                    <td class="text-right">Rp <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="signature-section">
    <div class="signature-box">
        <h4>TANDA TANGAN SUPPLIER</h4>
        <img src="../images/ttdsupplier.jpg" alt="Tanda Tangan Supplier" style="max-width: 150px; height: auto;">
        <div class="signature-name"><?php echo htmlspecialchars($data['nama_supplier']); ?></div>
    </div>
    <div class="signature-box">
        <h4>TANDA TANGAN PENERIMA</h4>
        <img src="../images/ttds.png" alt="Tanda Tangan Penerima" style="max-width: 150px; height: auto;">
        <div class="signature-name"><?php echo htmlspecialchars($data['nama_pegawai']); ?></div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>