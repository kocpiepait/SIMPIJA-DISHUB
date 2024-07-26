<?php
// Sertakan file koneksi database
include_once '../../api/db.php';

// Mulai sesi
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil nilai dari input form
  $nama_pengguna = $_POST['nama_pengguna'];
  $password = $_POST['password'];

  // Periksa pengguna di database
  $stmt = $conn->prepare("SELECT id_pengguna, password, role FROM pengguna WHERE nama_pengguna = ?");
  $stmt->bind_param("s", $nama_pengguna);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id_pengguna, $hashed_password, $role);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
      // Set sesi pengguna
      $_SESSION['id_pengguna'] = $id_pengguna;
      $_SESSION['role'] = $role;

      // Arahkan pengguna berdasarkan peran mereka
      if ($role === 'admin') {
        header("Location: ../../Admin-panel/admin.php");
      } else {
        header("Location: ../Dashboard.php");
      }
      exit();
    } else {
      $error = "Password salah";
    }
  } else {
    $error = "Nama pengguna tidak ditemukan";
  }
  $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../../assets/css/autentikasi.css">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="auth-container">
    <div class="auth-card">
      <img src="../../assets/img/logo/logo.png" alt="Logo" class="auth-logo">
      <h2>Login</h2>
      <form id="login-form" action="login.php" method="POST">
        <div class="input-group">
          <label for="nama_pengguna">Nama Pengguna:</label>
          <input type="text" id="username" name="nama_pengguna" placeholder="Masukkan nama pengguna Anda" value="<?php echo isset($_POST['nama_pengguna']) ? $_POST['nama_pengguna'] : ''; ?>">
          <small class="error" id="username-error"><?php echo ($error == "Nama pengguna tidak ditemukan") ? $error : ''; ?></small>
        </div>
        <div class="input-group">
          <label for="password">Password:</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Masukkan password">
            <i class='bx bx-show eye-icon' id="togglePassword"></i>
          </div>
          <small class="error" id="password-error"><?php echo ($error == "Password salah") ? $error : ''; ?></small>
        </div>
        <button type="submit" class="btn-primary">Login</button>
      </form>
      <div class="auth-link">
        <p>Belum punya akun? <a href="registrasi.php">Register di sini</a></p>
      </div>
    </div>
  </div>

  <script src="../../assets/js/autentikasi.js"></script>
</body>

</html>