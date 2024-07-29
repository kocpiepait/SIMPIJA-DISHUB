<?php
session_start();

if (!isset($_SESSION['id_pengguna'])) {
  $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Simpan URL saat ini
  $_SESSION['error'] = "Anda harus login untuk mengakses halaman ini.";
  header("Location: autentikasi/login.php");
  exit();
}

require_once '../api/db.php'; // Sesuaikan dengan path file konfigurasi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_pengguna = $_SESSION['id_pengguna'];
  $nama_pengaju = $_POST['nama_pengaju'];
  $alamat_pengaju = $_POST['alamat_pengaju'];
  $lokasi_kegiatan = $_POST['lokasi_kegiatan'];
  $jenis_kegiatan = $_POST['jenis_kegiatan'];
  $durasi = $_POST['durasi'];
  $jalur_alternatif = $_POST['jalur_alternatif'];

  // Upload file
  $ktp = $_FILES['ktp']['name'];
  $ktp_tmp = $_FILES['ktp']['tmp_name'];
  $surat_keterangan = $_FILES['surat_keterangan']['name'];
  $surat_keterangan_tmp = $_FILES['surat_keterangan']['tmp_name'];
  $gambar_peta = $_FILES['gambar_peta_lokasi']['name'];
  $gambar_peta_tmp = $_FILES['gambar_peta_lokasi']['tmp_name'];
  $gambar_jalan = $_FILES['gambar_jalan_alternatif']['name'];
  $gambar_jalan_tmp = $_FILES['gambar_jalan_alternatif']['tmp_name'];

  $upload_dir = 'uploads/';
  move_uploaded_file($ktp_tmp, $upload_dir . $ktp);
  move_uploaded_file($surat_keterangan_tmp, $upload_dir . $surat_keterangan);
  move_uploaded_file($gambar_peta_tmp, $upload_dir . $gambar_peta);
  move_uploaded_file($gambar_jalan_tmp, $upload_dir . $gambar_jalan);

  // Insert data into the database
  $sql = "INSERT INTO pengajuan (id_pengguna, nama_pengaju, alamat_pengaju, lokasi_kegiatan, jenis_kegiatan, durasi, status, KTP, surat_keterangan, jalan_alternatif, gambar_peta_lokasi, gambar_jalan_alternatif, tanggal_dibuat) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('issssssssss', $id_pengguna, $nama_pengaju, $alamat_pengaju, $lokasi_kegiatan, $jenis_kegiatan, $durasi, $ktp, $surat_keterangan, $jalur_alternatif, $gambar_peta, $gambar_jalan);
  if ($stmt->execute()) {
    $_SESSION['success_message'] = "Pengajuan berhasil diajukan!";
    header("Location: Dashboard.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Terjadi kesalahan. Silakan coba lagi.";
    header("Location: pengajuan-izinjalan.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>SIMPIJA DISHUB</title>
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

  <!-- =======================================================
  * Template Name: Anyar
  * Template URL: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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
          <li><a class="nav-link scrollto" href="blog.php">Informasi</a></li>
          <li class="dropdown">
            <a class=" active" href="#"><span>Layanan</span> <i class="bi bi-chevron-down "></i></a>
            <ul>
              <li><a href="pages/pengajuan-izinjalan.php">Pengajuan Rekom</a></li>
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

  <main id="main">
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index.html">Home</a></li>
        </ol>
        <h2>Pengajuan Rekomendasi Izin Jalan - SIMPIJA DISHUB</h2>
      </div>
    </section>
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Panduan Pengajuan Izin Jalan</h2>
          <p>
            Panduan ini akan membantu Anda dalam proses pengajuan izin jalan
            di Dinas Perhubungan Kepulauan Sangihe.
          </p>
        </div>

        <div class="row">
          <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box">
              <i class="bi bi-map"></i>
              <h4><a href="#">Lokasi Kegiatan</a></h4>
              <p>
                <strong>Deskripsi:</strong> Tentukan lokasi lengkap dari kegiatan yang memerlukan izin penggunaan jalan.
                <br><strong>Contoh Pengisian:</strong> Jalan Raya Sangihe No. 123, Kelurahan Manente, Kecamatan Tahuna.
              </p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <i class="bi bi-file-earmark-text"></i>
              <h4><a href="#">Jenis Kegiatan</a></h4>
              <p>
                <strong>Deskripsi:</strong> Jelaskan jenis kegiatan yang akan dilaksanakan dan tujuannya.
                <br><strong>Contoh Pengisian:</strong> Pembangunan Jembatan, Pemeliharaan Jalan, Acara Karnaval.
              </p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <i class="bi bi-clock"></i>
              <h4><a href="#">Durasi Kegiatan</a></h4>
              <p>
                <strong>Deskripsi:</strong> Tentukan periode atau lama kegiatan yang membutuhkan izin penggunaan jalan.
                <br><strong>Contoh Pengisian:</strong> 1 minggu, 3 hari, 1 bulan.
              </p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="400">
            <div class="icon-box">
              <i class="bi bi-geo-alt"></i>
              <h4><a href="#">Jalur Alternatif</a></h4>
              <p>
                <strong>Deskripsi:</strong> Siapkan rencana jalur alternatif yang dapat digunakan jika ada penutupan jalan.
                <br><strong>Contoh Pengisian:</strong> Jalan Tinoor sebagai jalur alternatif jika Jalan Raya Sangihe ditutup.
              </p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box">
              <i class="bi bi-camera"></i>
              <h4><a href="#">Unggah Dokumen</a></h4>
              <p>
                <strong>Deskripsi:</strong> Siapkan dokumen-dokumen yang diperlukan seperti foto lokasi atau surat izin dari pemerintah setempat.
                <br><strong>Dokumen yang Diperlukan:</strong>
              <ul>
                <li>Scan KTP Pengaju</li>
                <li>Surat Keterangan dari RT/RW atau Pemerintah Setempat</li>
                <li>Foto Lokasi Kegiatan</li>
                <li>Foto Jalur Alternatif</li>
              </ul>
              </p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="600">
            <div class="icon-box">
              <i class="bi bi-file-richtext"></i>
              <h4><a href="#">Syarat Pengurusan</a></h4>
              <p>
                <strong>Deskripsi:</strong> Pastikan Anda memenuhi syarat-syarat pengurusan izin penggunaan jalan yang berlaku.
                <br><strong>Syarat-Syarat:</strong>
              <ul>
                <li>Pengaju adalah warga yang berdomisili di sekitar lokasi kegiatan.</li>
                <li>Memiliki identitas resmi seperti KTP.</li>
                <li>Melampirkan surat keterangan dari pihak berwenang.</li>
                <li>Mengunggah dokumen-dokumen yang diperlukan.</li>
              </ul>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Services Section -->

    <!-- ======= Portfoio Section ======= -->
    <section class="form-section">
      <div class="form-con">
        <div class="form-head">
          <h2>FORMULIR PENGAJUAN REKOMENDASI IZIN JALAN</h2>
        </div>
        <form id="izinForm" class="form-modern" action="pengajuan-izinjalan.php" method="POST" enctype="multipart/form-data" novalidate>
          <div class="form-group">
            <label for="namaPengaju"><i class="bx bxs-user"></i> Nama Pengaju:</label>
            <input type="text" id="namaPengaju" name="nama_pengaju" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="alamatPengaju"><i class="bx bxs-home"></i> Alamat Pengaju:</label>
            <input type="text" id="alamatPengaju" name="alamat_pengaju" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="lokasi_kegiatan"><i class="bx bxs-map-pin"></i> Lokasi Kegiatan:</label>
            <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="jenis_kegiatan"><i class="bx bxs-briefcase"></i> Jenis Kegiatan:</label>
            <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="durasi"><i class="bx bxs-time"></i> Durasi:</label>
            <input type="text" id="durasi" name="durasi" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="jalur_alternatif"><i class="bx bxs-directions"></i> Jalur Alternatif:</label>
            <input type="text" id="jalur_alternatif" name="jalan_alternatif" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="ktp"><i class="bx bxs-file"></i> Unggah KTP:</label>
            <input type="file" id="ktp" name="ktp" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="suratKeterangan"><i class="bx bxs-file"></i> Unggah Surat Keterangan:</label>
            <input type="file" id="suratKeterangan" name="surat_keterangan" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="gambarPeta"><i class="bx bxs-image"></i> Unggah Gambar Peta Lokasi:</label>
            <input type="file" id="gambarPeta" name="gambar_peta_lokasi" required />
            <small class="error-message"></small>
          </div>
          <div class="form-group">
            <label for="gambarJalan"><i class="bx bxs-image"></i> Unggah Gambar Jalan Alternatif:</label>
            <input type="file" id="gambarJalan" name="gambar_jalan_alternatif" required />
            <small class="error-message"></small>
          </div>
          <button type="submit" class="submit-button">Ajukan Rekomendasi</button>
        </form>
      </div>
    </section>
  </main>
  <!-- End #main -->

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
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>

</html>