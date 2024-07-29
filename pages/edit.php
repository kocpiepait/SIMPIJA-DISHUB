<?php
require '../api/db.php'; // Sesuaikan dengan file konfigurasi database Anda

// Cek apakah parameter id ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil semua kolom dari tabel pengajuan berdasarkan id
    $sql = "SELECT * FROM pengajuan WHERE id_pengajuan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $pengajuan = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan";
        exit;
    }
} else {
    echo "ID tidak disediakan di URL";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan</title>
    <link rel="stylesheet" href="../assets/css/userdata.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css" />

</head>

<body>
    <div class="container">
        <div class="main-content">
            <section class="form-section">
                <div class="form-con">
                    <div class="form-head">
                        <h2>FORMULIR PENGAJUAN REKOMENDASI IZIN JALAN</h2>
                    </div>
                    <form id="izinForm" class="form-modern" action="update-pengajuan.php" method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id_pengajuan" value="<?php echo $pengajuan['id_pengajuan']; ?>">
                        <div class="form-group">
                            <label for="namaPengaju"><i class="bx bxs-user"></i> Nama Pengaju:</label>
                            <input type="text" id="namaPengaju" name="nama_pengaju" value="<?php echo $pengajuan['nama_pengaju']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="alamatPengaju"><i class="bx bxs-home"></i> Alamat Pengaju:</label>
                            <input type="text" id="alamatPengaju" name="alamat_pengaju" value="<?php echo $pengajuan['alamat_pengaju']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="lokasi_kegiatan"><i class="bx bxs-map-pin"></i> Lokasi Kegiatan:</label>
                            <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" value="<?php echo $pengajuan['lokasi_kegiatan']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kegiatan"><i class="bx bxs-briefcase"></i> Jenis Kegiatan:</label>
                            <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" value="<?php echo $pengajuan['jenis_kegiatan']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="durasi"><i class="bx bxs-time"></i> Durasi:</label>
                            <input type="text" id="durasi" name="durasi" value="<?php echo $pengajuan['durasi']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="jalur_alternatif"><i class="bx bxs-directions"></i> Jalur Alternatif:</label>
                            <input type="text" id="jalur_alternatif" name="jalan_alternatif" value="<?php echo $pengajuan['jalan_alternatif']; ?>" required />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="ktp"><i class="bx bxs-file"></i> Unggah KTP:</label>
                            <input type="file" id="ktp" name="ktp" value="<?php echo $pengajuan['KTP']; ?>" />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="suratKeterangan"><i class="bx bxs-file"></i> Unggah Surat Keterangan:</label>
                            <input type="file" id="suratKeterangan" name="surat_keterangan" value="<?php echo $pengajuan['surat_keterangan']; ?>" />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="gambarPeta"><i class="bx bxs-image"></i> Unggah Gambar Peta Lokasi:</label>
                            <input type="file" id="gambarPeta" name="gambar_peta_lokasi" value="<?php echo $pengajuan['gambar_peta_lokasi']; ?>" />
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="gambarJalan"><i class="bx bxs-image"></i> Unggah Gambar Jalan Alternatif:</label>
                            <input type="file" id="gambarJalan" name="gambar_jalan_alternatif" value="<?php echo $pengajuan['gambar_jalan_alternatif']; ?>" />
                            <small class="error-message"></small>
                        </div>
                        <button type="submit" class="submit-button">Simpan Perubahan</button>
                        <a href="dashboard.php" class="btn btn-back">Kembali</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="path/to/your/scripts.js"></script>
</body>

</html>