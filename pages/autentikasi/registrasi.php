<?php
// Sertakan file koneksi database
include_once '../../api/db.php';

// Mulai sesi
session_start();

// Inisialisasi variabel
$is_admin_registered = false;
$success_message = "";
$error_messages = [];

// Periksa apakah ada admin yang sudah terdaftar
$query = "SELECT COUNT(*) as count FROM pengguna WHERE role = 'admin'";
$result = mysqli_query($conn, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  if ($row['count'] > 0) {
    $is_admin_registered = true;
  }
}

// Tentukan kode verifikasi admin
$admin_verification_code = 'admin123';

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validasi input
  $errors = [];

  // Ambil nilai dari input form dan validasi
  $nama_pengguna = isset($_POST['nama_pengguna']) ? $_POST['nama_pengguna'] : null;
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $password = isset($_POST['password']) ? $_POST['password'] : null;
  $confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : null;
  $admin_code = isset($_POST['admin-code']) ? $_POST['admin-code'] : '';

  // Cek jika username atau email sudah ada di database
  $stmt = $conn->prepare("SELECT COUNT(*) as count FROM pengguna WHERE nama_pengguna = ? OR email = ?");
  $stmt->bind_param("ss", $nama_pengguna, $email);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    $errors['username_exists'] = "Username atau email sudah terdaftar";
  }

  // Tambahkan pengguna ke database jika tidak ada kesalahan
  if (empty($errors)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Periksa kode verifikasi admin jika belum ada admin
    if (!$is_admin_registered && !empty($admin_code) && $admin_code === $admin_verification_code) {
      $role = 'admin';
    }

    $stmt = $conn->prepare("INSERT INTO pengguna (nama_pengguna, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_pengguna, $email, $hashed_password, $role);
    if ($stmt->execute()) {
      $success_message = "Registrasi berhasil! Anda akan diarahkan ke halaman login.";
      // Hapus pesan error jika ada
      unset($_SESSION['error_messages']);
      // Arahkan ke halaman login setelah 3 detik
      echo "<script>
              setTimeout(function() {
                window.location.href = 'login.php';
              }, 3000);
            </script>";
    } else {
      $error_messages[] = "Terjadi kesalahan saat registrasi: " . $stmt->error;
    }
    $stmt->close();
  } else {
    $error_messages = $errors;
    // Simpan pesan error di sesi
    $_SESSION['error_messages'] = $error_messages;
  }
} else {
  // Ambil pesan error dari sesi jika ada
  $error_messages = isset($_SESSION['error_messages']) ? $_SESSION['error_messages'] : [];
  // Hapus pesan error dari sesi setelah diambil
  unset($_SESSION['error_messages']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../../assets/css/autentikasi.css">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="auth-container">
    <div class="auth-card">
      <img src="../../assets/img/logo/logo.png" alt="Logo" class="auth-logo">
      <h2>Register</h2>
      <?php if ($success_message) : ?>
        <p class="success"><?php echo $success_message; ?></p>
      <?php endif; ?>
      <form id="register-form" action="registrasi.php" method="POST">
        <div class="input-group">
          <label for="nama_pengguna">Username:</label>
          <input type="text" id="username" name="nama_pengguna" placeholder="Masukkan username Anda">
          <small class="error" id="username-error"><?php echo isset($error_messages['username_exists']) ? $error_messages['username_exists'] : ''; ?></small>
        </div>
        <div class="input-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email Anda">
          <small class="error" id="email-error"><?php echo isset($error_messages['username_exists']) ? $error_messages['username_exists'] : ''; ?></small>
        </div>
        <div class="input-group">
          <label for="password">Password:</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Masukkan password">
            <i class='bx bx-show eye-icon' id="togglePassword"></i>
          </div>
          <small class="error" id="password-error"></small>
        </div>
        <div class="input-group">
          <label for="confirm-password">Konfirmasi Password:</label>
          <div class="password-wrapper">
            <input type="password" id="confirm-password" name="confirm-confirm-password" placeholder="Konfirmasi password">
            <i class='bx bx-show eye-icon' id="toggleConfirmPassword"></i>
          </div>
          <small class="error" id="confirm-password-error"></small>
        </div>
        <?php if (!$is_admin_registered) : ?>
          <div class="input-group">
            <label for="admin-code">Kode Verifikasi Admin (Opsional):</label>
            <input type="text" id="admin-code" name="admin-code" placeholder="Masukkan kode verifikasi jika Anda admin">
            <small class="error" id="admin-code-error"></small>
          </div>
        <?php endif; ?>
        <button type="submit" class="btn-primary">Register</button>
      </form>
      <p class="auth-link">Sudah punya akun? <a href="login.php">Login disini</a></p>
    </div>
  </div>
  <script src="../../assets/js/autentikasi.js"></script>
</body>

</html>