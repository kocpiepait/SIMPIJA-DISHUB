<?php
require '../api/db.php'; // Sesuaikan dengan file konfigurasi database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = $_POST['id_pengajuan'];
    $nama_pengaju = $_POST['nama_pengaju'];
    $alamat_pengaju = $_POST['alamat_pengaju'];
    $lokasi_kegiatan = $_POST['lokasi_kegiatan'];
    $jenis_kegiatan = $_POST['jenis_kegiatan'];
    $durasi = $_POST['durasi'];
    $jalur_alternatif = $_POST['jalan_alternatif'];

    // Lakukan update di database
    $sql = "UPDATE pengajuan SET nama_pengaju=?, alamat_pengaju=?, lokasi_kegiatan=?, jenis_kegiatan=?, durasi=?, jalan_alternatif=? WHERE id_pengajuan=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nama_pengaju, $alamat_pengaju, $lokasi_kegiatan, $jenis_kegiatan, $durasi, $jalur_alternatif, $id_pengajuan);

    if ($stmt->execute()) {
        // Redirect dengan pesan sukses
        header("Location: Dashboard.php?success=1");
        exit();
    } else {
        echo "Terjadi kesalahan saat mengupdate data.";
    }
}
