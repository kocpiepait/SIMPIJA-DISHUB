<?php
session_start();
// Periksa apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION["id_pengguna"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
  // Jika tidak, arahkan ke halaman login
  header("Location: ../autentikasi/login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <link rel="stylesheet" href="/assets/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css" />
</head>

<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
    <div class="sidebar-logo">
      <h1>SIMPIJA</h1>
    </div>
    <ul class="sidebar-links">
      <li>
        <a href="../../index.php"><i class="bx bx-home"></i>kembali Ke Beranda</a>
      </li>
      <li>
        <a href="admin.html"><i class="bx bx-line-chart"></i> Dashboard</a>
      </li>
      <li>
        <a href="admin-informasi.html"><i class="bx bx-edit"></i> Update Informasi</a>
      </li>
      <li>
        <a href="admin-profil.html"><i class="bx bx-user"></i> Profil</a>
      </li>
      <li>
        <a href="../autentikasi/logout.php" id="logout-link"><i class="bx bx-log-out"></i> Logout</a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Dashboard Section -->
    <section id="dashboard-section" class="dashboard-section">
      <div class="container">
        <div class="dashboard-header">
          <h2>Dashboard Admin</h2>
        </div>
        <div class="dashboard-content">
          <div class="summary-cards">
            <div class="summary-card">
              <h3>Total Pengajuan</h3>
              <p id="totalPengajuan">0</p>
            </div>
            <div class="summary-card">
              <h3>Disetujui</h3>
              <p id="approvedPengajuan">0</p>
            </div>
            <div class="summary-card">
              <h3>Ditolak</h3>
              <p id="rejectedPengajuan">0</p>
            </div>
            <div class="summary-card">
              <h3>Pending</h3>
              <p id="pendingPengajuan">0</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Validasi Pengajuan Section -->
    <section id="pengajuan-section" class="pengajuan-section">
      <div class="container">
        <div class="pengajuan-header">
          <h2>Validasi Pengajuan</h2>
        </div>
        <div class="pengajuan-content">
          <div class="submission-list">
            <table class="progress-table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Lokasi</th>
                  <th>Jenis Kegiatan</th>
                  <th>Lama Kegiatan</th>
                  <th>Jalur Alternatif</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="pengajuanBody">
                <!-- Data will be populated here dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <p>&copy; 2024 SIMPIJA. All rights reserved.</p>
      </div>
    </footer>
  </div>

  <script src="../../assets/js/dashboard.js"></script>
</body>

</html>