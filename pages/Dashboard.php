<?php
session_start();
require_once '../api/db.php';

// Periksa apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION["id_pengguna"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "user") {
  // Jika tidak, arahkan ke halaman login
  header("Location: autentikasi/login.php");
  exit();
}

// Mendapatkan pesan sukses jika ada
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

// Mendapatkan data pengajuan pengguna dari database
$id_pengguna = $_SESSION['id_pengguna'];
$sql = "SELECT * FROM pengajuan WHERE id_pengguna = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
$pengajuan = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Pengguna</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css" />
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
        <a href="../index.php"><i class="bx bx-home"></i>Kembali Ke Beranda</a>
      </li>
      <li>
        <a href="#progress-section"><i class="bx bx-line-chart"></i> Dashboard</a>
      </li>
      <li>
        <a href="profil.html"><i class="bx bx-user"></i> Profil</a>
      </li>
      <li>
        <a href="autentikasi/logout.php" id="logout-link"><i class="bx bx-log-out"></i> Logout</a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Dashboard Section -->
    <section id="dashboard-section" class="dashboard-section">
      <div class="container">
        <div class="dashboard-header">
          <h2>Dashboard Pengguna</h2>
        </div>
        <?php if ($success_message) : ?>
          <div class="success">
            <?php echo $success_message; ?>
          </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])) : ?>
          <div class="success-message">
            Data berhasil diupdate.
          </div>
        <?php endif; ?>
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

          <div id="progress-section" class="submission-list">
            <h3>Progress Pengajuan</h3>
            <button id="addDataBtn" class="btn-add"><i class="bx bx-plus"></i> Tambah Pengajuan</button>
            <div class="progress-table">
              <table>
                <thead>
                  <tr>
                    <th>ID Pengajuan</th>
                    <th>Nama Pengaju</th>
                    <th>Alamat Pengaju</th>
                    <th>Lokasi Kegiatan</th>
                    <th>Jenis Kegiatan</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="progressBody">
                  <?php foreach ($pengajuan as $row) : ?>
                    <tr>
                      <td><?php echo $row['id_pengajuan']; ?></td>
                      <td><?php echo $row['nama_pengaju']; ?></td>
                      <td><?php echo $row['alamat_pengaju']; ?></td>
                      <td><?php echo $row['lokasi_kegiatan']; ?></td>
                      <td><?php echo $row['jenis_kegiatan']; ?></td>
                      <td><?php echo $row['durasi']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                      <td><?php echo $row['tanggal_dibuat']; ?></td>
                      <td class="action-buttons">
                        <button class="btn-edits" data-id="<?php echo $row['id_pengajuan']; ?>">
                          <i class="bx bxs-edit"></i>Edit
                        </button>
                        <button class="btn-delete"><i class="bx bxs-trash"></i>Hapus</button>
                        <button class="btn-detail" data-id="<?php echo $row['id_pengajuan']; ?>">
                          <i class="bx bxs-detail"></i>Detail
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
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

  <!-- Modal Detail -->
  <div id="detailModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Detail Pengajuan</h2>
      <p id="detailContent"></p>
    </div>
  </div>

  <!-- Modal untuk tambah data -->
  <div id="addDataModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form id="izinForm" class="form-modern" action="tambah-pengajuan.php" method="POST" enctype="multipart/form-data" novalidate>
        <div class="form-group">
          <label for="namaPengaju"><i class="bx bxs-user"></i> Nama Pengaju:</label>
          <input type="text" id="namaPengaju" name="nama_pengaju" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="alamatPengaju"><i class="bx bxs-home"></i> Alamat Pengaju:</label>
          <input type="text" id="alamatPengaju" name="alamat_pengaju" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="lokasi_kegiatan"><i class="bx bxs-map-pin"></i> Lokasi Kegiatan:</label>
          <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="jenis_kegiatan"><i class="bx bxs-briefcase"></i> Jenis Kegiatan:</label>
          <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="durasi"><i class="bx bxs-time"></i> Durasi:</label>
          <input type="text" id="durasi" name="durasi" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="jalur_alternatif"><i class="bx bxs-directions"></i> Jalur Alternatif:</label>
          <input type="text" id="jalur_alternatif" name="jalan_alternatif" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="ktp"><i class="bx bxs-file"></i> Unggah KTP:</label>
          <input type="file" id="ktp" name="ktp" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="suratKeterangan"><i class="bx bxs-file"></i> Unggah Surat Keterangan:</label>
          <input type="file" id="suratKeterangan" name="surat_keterangan" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="gambarPeta"><i class="bx bxs-image"></i> Unggah Gambar Peta Lokasi:</label>
          <input type="file" id="gambarPeta" name="gambar_peta_lokasi" required />
          <span class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="gambarJalan"><i class="bx bxs-image"></i> Unggah Gambar Jalan Alternatif:</label>
          <input type="file" id="gambarJalan" name="gambar_jalan_alternatif" required />
          <span class="error-message"></span>
        </div>
        <button type="submit" class="submit-button">Ajukan Rekomendasi</button>
      </form>
    </div>
  </div>

  <!-- Toast Notification -->
  <div id="toast" class="toast"></div>

  <!-- <div id="preloader"></div> -->

  <script src="../assets/js/dashboard.js"></script>
</body>

</html>