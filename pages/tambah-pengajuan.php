<?php
session_start();
require_once('../api/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil ID pengguna dari sesi
    if (!isset($_SESSION['id_pengguna'])) {
        $_SESSION['error_message'] = "Anda harus login terlebih dahulu.";
        header("Location: login.php");
        exit();
    }

    $id_pengguna = $_SESSION['id_pengguna'];
    $nama_pengaju = $_POST['nama_pengaju'] ?? '';
    $alamat_pengaju = $_POST['alamat_pengaju'] ?? '';
    $lokasi_kegiatan = $_POST['lokasi_kegiatan'] ?? '';
    $jenis_kegiatan = $_POST['jenis_kegiatan'] ?? '';
    $durasi = $_POST['durasi'] ?? '';
    $jalan_alternatif = $_POST['jalan_alternatif'] ?? '';

    // Upload file
    $upload_dir = 'uploads/';
    $ktp = $upload_dir . basename($_FILES['ktp']['name']);
    $ktp_tmp = $_FILES['ktp']['tmp_name'];
    $surat_keterangan = $upload_dir . basename($_FILES['surat_keterangan']['name']);
    $surat_keterangan_tmp = $_FILES['surat_keterangan']['tmp_name'];
    $gambar_peta = $upload_dir . basename($_FILES['gambar_peta_lokasi']['name']);
    $gambar_peta_tmp = $_FILES['gambar_peta_lokasi']['tmp_name'];
    $gambar_jalan = $upload_dir . basename($_FILES['gambar_jalan_alternatif']['name']);
    $gambar_jalan_tmp = $_FILES['gambar_jalan_alternatif']['tmp_name'];

    // Memeriksa apakah file berhasil di-upload
    if (move_uploaded_file($ktp_tmp, $ktp) && move_uploaded_file($surat_keterangan_tmp, $surat_keterangan) && move_uploaded_file($gambar_peta_tmp, $gambar_peta) && move_uploaded_file($gambar_jalan_tmp, $gambar_jalan)) {
        // Insert data into the database
        $sql = "INSERT INTO pengajuan (id_pengguna, nama_pengaju, alamat_pengaju, lokasi_kegiatan, jenis_kegiatan, durasi, status, KTP, surat_keterangan, jalan_alternatif, gambar_peta_lokasi, gambar_jalan_alternatif, tanggal_dibuat) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issssssssss', $id_pengguna, $nama_pengaju, $alamat_pengaju, $lokasi_kegiatan, $jenis_kegiatan, $durasi, $ktp, $surat_keterangan, $jalan_alternatif, $gambar_peta, $gambar_jalan);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Pengajuan berhasil diajukan!";
            header("Location: Dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
            // Logging error untuk debugging
            error_log("Database error: " . $stmt->error);
        }
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan saat meng-upload file. Silakan coba lagi.";
    }

    header("Location: pengajuan-izinjalan.php");
    exit();
}
