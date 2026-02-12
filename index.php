<!doctype html>
<html lang="en">
  <head>
    <title>Adi Jaya Berkah - Furniture Kayu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
      html, body {
        height: 100%;
        font-family: 'Lato', sans-serif;
      }
      .hero-section {
        height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                    url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        color: white;
      }
      .logo {
        width: 200px;
        height: auto;
        margin-bottom: 30px;
      }
      .btn-primary {
        background-color: #8B4513;
        border: none;
        font-weight: 600;
        padding: 12px 30px;
      }
      .btn-primary:hover {
        background-color: #A0522D;
      }
      .btn-outline-light {
        padding: 12px 30px;
        margin-left: 15px;
      }
      .feature-box {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        margin: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
      }
      .feature-box:hover {
        transform: translateY(-10px);
      }
      .feature-icon {
        font-size: 2.5rem;
        color: #8B4513;
        margin-bottom: 20px;
      }
      .section-title {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
      }
      .section-title:after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #8B4513;
      }
      .navbar {
        background-color: rgba(0, 0, 0, 0.8) !important;
      }
      .navbar-brand img {
        height: 40px;
      }
      .product-card {
        margin-bottom: 30px;
        transition: all 0.3s;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      .product-card:hover {
        transform: translateY(-10px);
      }
      .product-img {
        height: 200px;
        object-fit: cover;
      }
      .price {
        color: #8B4513;
        font-weight: bold;
      }
      footer {
        background-color: #343a40;
        color: white;
        padding: 50px 0;
      }
      .social-icon {
        color: white;
        font-size: 1.5rem;
        margin: 0 10px;
        transition: all 0.3s;
      }
      .social-icon:hover {
        color: #8B4513;
      }
    </style>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="images/logo1.PNG" alt="Adi Jaya Berkah">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Kontak</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container text-center">
        <img src="images/logo1.PNG" alt="Adi Jaya Berkah" class="logo">
        <h1 class="display-4 mb-4">Furniture Kayu Berkualitas</h1>
        <p class="lead mb-5">Menyediakan berbagai macam furniture kayu dengan kualitas terbaik dan harga terjangkau</p>
        <a href="#" class="btn btn-primary">Lihat Produk</a>
        <a href="#" class="btn btn-outline-light">Tentang Kami</a>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="feature-box text-center">
              <div class="feature-icon">
                <i class="fa fa-tree"></i>
              </div>
              <h3>Kayu Berkualitas</h3>
              <p>Menggunakan kayu pilihan dengan kualitas terbaik untuk furniture yang tahan lama</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-box text-center">
              <div class="feature-icon">
                <i class="fa fa-cogs"></i>
              </div>
              <h3>Handmade</h3>
              <p>Dibuat oleh pengrajin berpengalaman dengan ketelitian tinggi</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-box text-center">
              <div class="feature-icon">
                <i class="fa fa-truck"></i>
              </div>
              <h3>Gratis Pengiriman</h3>
              <p>Gratis pengiriman untuk wilayah tertentu dengan minimal pembelian</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Products Section -->
    <section class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center section-title">Produk Unggulan</h2>
        <div class="row">
          <!-- Product 1 -->
          <div class="col-md-4">
            <div class="card product-card">
              <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top product-img" alt="Meja Makan">
              <div class="card-body">
                <h5 class="card-title">Meja Makan Minimalis</h5>
                <p class="card-text">Meja makan kayu jati dengan desain minimalis dan elegan.</p>
                <p class="price">Rp 3.500.000</p>
                <a href="#" class="btn btn-primary">Detail</a>
              </div>
            </div>
          </div>
          <!-- Product 2 -->
          <div class="col-md-4">
            <div class="card product-card">
              <img src="https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top product-img" alt="Kursi Tamu">
              <div class="card-body">
                <h5 class="card-title">Kursi Tamu Klasik</h5>
                <p class="card-text">Set kursi tamu kayu mahoni dengan bantalan nyaman.</p>
                <p class="price">Rp 2.800.000</p>
                <a href="#" class="btn btn-primary">Detail</a>
              </div>
            </div>
          </div>
          <!-- Product 3 -->
          <div class="col-md-4">
            <div class="card product-card">
              <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img-top product-img" alt="Lemari Pakaian">
              <div class="card-body">
                <h5 class="card-title">Lemari Pakaian</h5>
                <p class="card-text">Lemari pakaian kayu sonokeling dengan 3 pintu.</p>
                <p class="price">Rp 5.200.000</p>
                <a href="#" class="btn btn-primary">Detail</a>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-4">
          <a href="#" class="btn btn-outline-dark">Lihat Semua Produk</a>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="img-fluid rounded" alt="Tentang Kami">
          </div>
          <div class="col-md-6">
            <h2 class="section-title">Tentang Adi Jaya Berkah</h2>
            <p>Adi Jaya Berkah adalah usaha furniture kayu yang berdiri sejak tahun 2005. Kami berkomitmen untuk menyediakan produk furniture kayu berkualitas dengan harga terjangkau.</p>
            <p>Dengan pengalaman lebih dari 15 tahun, kami telah melayani ribuan pelanggan baik perorangan maupun perusahaan. Setiap produk kami dibuat dengan teliti oleh pengrajin berpengalaman.</p>
            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4 mb-md-0">
            <img src="images/logo1.PNG" alt="Adi Jaya Berkah" class="logo mb-3">
            <p>Menyediakan furniture kayu berkualitas dengan harga terjangkau sejak 2005.</p>
            <div class="mt-4">
              <a href="#" class="social-icon"><i class="fa fa-facebook"></i></a>
              <a href="#" class="social-icon"><i class="fa fa-instagram"></i></a>
              <a href="#" class="social-icon"><i class="fa fa-whatsapp"></i></a>
            </div>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <h5>Kontak Kami</h5>
            <ul class="list-unstyled">
              <li><i class="fa fa-map-marker me-2"></i> Jl. Raya Furniture No. 123, Jakarta</li>
              <li><i class="fa fa-phone me-2"></i> (021) 12345678</li>
              <li><i class="fa fa-envelope me-2"></i> info@adijayaberkah.com</li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5>Jam Buka</h5>
            <ul class="list-unstyled">
              <li>Senin - Jumat: 08.00 - 17.00</li>
              <li>Sabtu: 08.00 - 15.00</li>
              <li>Minggu & Hari Besar: Tutup</li>
            </ul>
          </div>
        </div>
        <hr class="my-4 bg-light">
        <div class="text-center">
          <p class="mb-0">&copy; 2023 Adi Jaya Berkah. All Rights Reserved.</p>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
      // Navbar background change on scroll
      $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
          $('.navbar').css('background-color', 'rgba(0, 0, 0, 0.9)');
        } else {
          $('.navbar').css('background-color', 'rgba(0, 0, 0, 0.8)');
        }
      });
    </script>
  </body>
</html>