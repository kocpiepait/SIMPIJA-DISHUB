<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Informasi - SIMPIJA DISHUB</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <link href="../assets/img/logo/logo.png" rel="icon" />
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet" />
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/pengajuan.css" rel="stylesheet" />
</head>

<body>
  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="fixed-top d-flex align-items-center topbar-inner-pages">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">info@example.com</a>
        <i class="bi bi-phone-fill phone-icon"></i> +1 5589 55488 55
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="logo">
        <img src="../assets/img/logo/logo.png" alt="Logo Dishub" />
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li>
            <a class="nav-link scrollto " href="../index.php">Beranda</a>
          </li>
          <li><a class="nav-link scrollto active" href="blog.html">Informasi</a></li>
          <li class="dropdown">
            <a href="#"><span>Layanan</span> <i class="bi bi-chevron-down "></i></a>
            <ul>
              <li><a href="pengajuan-izinjalan.php">Pengajuan Rekom</a></li>
              <li><a href="#">Jalan Alteratif</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="kontak.html">Kontak</a></li>
          <?php if (!isset($_SESSION['id_pengguna'])) : ?>
            <li><a class="btn-custom" href="pages/autentikasi/login.php">Masuk</a></li>
            <li><a class="btn-custom" href="pages/autentikasi/registrasi.php">Daftar</a></li>
          <?php else : ?>
            <?php if ($_SESSION['role'] == 'admin') : ?>
              <li><a class="btn-custom" href="Admin-panel/admin.php">Dashboard Admin</a></li>
            <?php else : ?>
              <li><a class="btn-custom" href="Dashboard.php">Dashboard Pengguna</a></li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>


      <!-- .navbar -->
    </div>
  </header>
  <!-- End Header -->

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="../index.php">Home</a></li>
      </ol>
      <h2>Informasi</h2>
    </div>
  </section>
  <!-- End Breadcrumbs -->

  <!-- ======= Info Section ======= -->
  <section id="info" class="info-section">
    <div class="container info-container">
      <div class="main-container">
        <div class="info-card" data-aos="fade-up" data-aos-delay="5000">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-info-circle icon"></i>
            <h3>Apa itu SIMPIJA?</h3>
          </div>
          <div class="info-content">
            <p>
              SIMPIJA adalah singkatan dari Sistem Informasi Manajemen
              Perizinan Jalan. Ini adalah platform yang dikembangkan untuk
              memudahkan proses pengajuan izin jalan di Sangihe Islands.
            </p>
          </div>
        </div>
        <div class="info-card" data-aos="fade-up" data-aos-delay="5000">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-list-ul icon"></i>
            <h3>Persyaratan Izin</h3>
          </div>
          <div class="info-content">
            <ul>
              <li>Dokumen identitas (KTP/SIM/Paspor).</li>
              <li>Surat permohonan izin dari pemohon.</li>
              <li>Rencana kebutuhan dan alasan pengajuan izin.</li>
              <li>
                Izin dari pemilik lahan atau instansi terkait (jika
                diperlukan).
              </li>
            </ul>
          </div>
        </div>
        <div class="info-card" data-aos="fade-up" data-aos-delay="5000">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-map icon"></i>
            <h3>Panduan Pengajuan</h3>
          </div>
          <div class="info-content">
            <ol>
              <li>Masuk ke platform SIMPIJA dan buat akun pengguna.</li>
              <li>Isi formulir pengajuan izin jalan dengan lengkap.</li>
              <li>Unggah dokumen-dokumen yang diperlukan.</li>
              <li>
                Tunggu proses verifikasi dan persetujuan dari pihak terkait.
              </li>
              <li>
                Setelah disetujui, izin jalan akan diterbitkan dan dapat
                diunduh dari platform.
              </li>
            </ol>
          </div>
        </div>
        <div class="info-card" data-aos="fade-up" data-aos-delay="5000">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-phone icon"></i>
            <h3>Informasi Tambahan</h3>
          </div>
          <div class="info-content">
            <p>
              Untuk informasi lebih lanjut atau bantuan dalam proses pengajuan
              izin jalan, silakan hubungi kami melalui telepon di
              <a href="tel:+628123456789" style="color: #054a85">+62 812-3456-789</a>.
            </p>
          </div>
        </div>
      </div>
      <div class="sidebar-container">
        <div class="info-card">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-user icon"></i>
            <h3>Admin 1</h3>
          </div>
          <div class="info-content">
            <p>Nama: John Doe</p>
            <p>Email: johndoe@example.com</p>
            <p>
              Telepon:
              <a href="tel:+628123456789" style="color: #054a85">+62 812-3456-789</a>
            </p>
          </div>
        </div>
        <div class="info-card">
          <div class="info-header" style="background-color: #054a85">
            <i class="bx bx-user icon"></i>
            <h3>Admin 2</h3>
          </div>
          <div class="info-content">
            <p>Nama: Jane Smith</p>
            <p>Email: janesmith@example.com</p>
            <p>
              Telepon:
              <a href="tel:+628987654321" style="color: #054a85">+62 812-9876-54321</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Info Section -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h4>Our Newsletter</h4>
            <p>
              Tamen quem nulla quae legam multos aute sint culpa legam noster
              magna
            </p>
          </div>
          <div class="col-lg-6">
            <form action="" method="post">
              <input type="email" name="email" /><input type="submit" value="Subscribe" />
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">Home</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">About us</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">Services</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="#">Terms of service</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="#">Privacy policy</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">Web Design</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="#">Web Development</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="#">Product Management</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">Marketing</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="#">Graphic Design</a>
              </li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br />
              New York, NY 535022<br />
              United States <br /><br />
              <strong>Phone:</strong> +1 5589 55488 55<br />
              <strong>Email:</strong> info@example.com<br />
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>About Anyar</h3>
            <p>
              Cras fermentum odio eu feugiat lide par naso tierra. Justo eget
              nada terra videa magna derita valies darta donna mare fermentum
              iaculis eu non diam phasellus.
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Anyar</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/purecounter/purecounter.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>

</html>