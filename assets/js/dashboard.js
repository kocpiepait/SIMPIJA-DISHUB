document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.createElement("button");
  sidebarToggle.className = "sidebar-toggle";
  sidebarToggle.innerHTML = '<i class="bx bx-menu"></i>';
  document.body.appendChild(sidebarToggle);

  const sidebar = document.querySelector(".sidebar");
  sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });

  const logoutLink = document.querySelector('a[href="autentikasi/logout.php"]');
  if (logoutLink) {
    logoutLink.addEventListener("click", (e) => {
      e.preventDefault();
      const confirmLogout = confirm("Apakah Anda yakin ingin logout?");
      if (confirmLogout) {
        window.location.href = logoutLink.href;
      }
    });
  }

  // Event listener untuk tombol edit
  document.querySelectorAll(".btn-edits").forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.getAttribute("data-id");
      // Panggil fungsi untuk menangani pengeditan
      handleEdit(id);
    });
  });

  // Event listener untuk tombol detail
  document.querySelectorAll(".btn-detail").forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.getAttribute("data-id");
      // Panggil fungsi untuk menangani detail
      handleDetail(id);
    });
  });

  // Modal elements
  const modal = document.getElementById("detailModal");
  const span = document.getElementsByClassName("close")[0];

  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  function handleEdit(id) {
    // Lakukan sesuatu untuk pengeditan, misalnya arahkan ke halaman pengeditan
    window.location.href = `edit.php?id=${id}`;
  }

  function handleDetail(id) {
    // Lakukan permintaan AJAX untuk mendapatkan data detail
    fetch(`get-detail.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        // Isi konten modal dengan data detail
        const detailContent = document.getElementById("detailContent");
        detailContent.innerHTML = `
          <p><strong>Nama Pengaju:</strong> ${data.nama_pengaju}</p>
          <p><strong>Alamat Pengaju:</strong> ${data.alamat_pengaju}</p>
          <p><strong>Lokasi Kegiatan:</strong> ${data.lokasi_kegiatan}</p>
          <p><strong>Jenis Kegiatan:</strong> ${data.jenis_kegiatan}</p>
          <p><strong>Durasi:</strong> ${data.durasi}</p>
          <p><strong>Jalur Alternatif:</strong> ${data.jalur_alternatif}</p>
          <p><strong>Status:</strong> ${data.status}</p>
          <p><strong>Tanggal Dibuat:</strong> ${data.tanggal_dibuat}</p>
        `;
        modal.style.display = "block";
      })
      .catch((error) => {
        console.error("Error fetching detail:", error);
      });
  }

  const rows = document.querySelectorAll("#progressBody tr");
  const totalPengajuan = document.getElementById("totalPengajuan");
  const approvedPengajuan = document.getElementById("approvedPengajuan");
  const rejectedPengajuan = document.getElementById("rejectedPengajuan");
  const pendingPengajuan = document.getElementById("pendingPengajuan");

  let total = 0;
  let approved = 0;
  let rejected = 0;
  let pending = 0;

  rows.forEach((row) => {
    total++;
    const status = row.cells[6].textContent.trim().toLowerCase();
    if (status === "disetujui") {
      approved++;
    } else if (status === "ditolak") {
      rejected++;
    } else if (status === "pending") {
      pending++;
    }
  });

  totalPengajuan.textContent = total;
  approvedPengajuan.textContent = approved;
  rejectedPengajuan.textContent = rejected;
  pendingPengajuan.textContent = pending;

  // Event listener untuk tombol tambah data
  const addDataBtn = document.getElementById("addDataBtn");
  const addDataModal = document.getElementById("addDataModal");
  const addDataForm = document.getElementById("addDataForm");

  addDataBtn.onclick = function () {
    addDataModal.style.display = "block";
  };

  const closeModalButtons = document.querySelectorAll(".close");
  closeModalButtons.forEach((button) => {
    button.onclick = function () {
      addDataModal.style.display = "none";
      modal.style.display = "none";
    };
  });

  window.onclick = function (event) {
    if (event.target == addDataModal) {
      addDataModal.style.display = "none";
    }
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  // Event listener untuk form submission
  const izinForm = document.getElementById("izinForm");
  if (izinForm) {
    izinForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(izinForm);

      // Reset error messages
      const errorMessages = document.querySelectorAll(".error-message");
      errorMessages.forEach((message) => {
        message.textContent = "";
      });

      try {
        const response = await fetch("tambah-pengajuan.php", {
          method: "POST",
          body: formData,
        });

        // Pastikan response adalah JSON
        const result = await response.json();

        if (result.success) {
          // Tutup modal
          addDataModal.style.display = "none";
          // Tampilkan pesan sukses
          alert(result.message);
          // Reset form
          izinForm.reset();
          // Update tabel tanpa refresh halaman
          updateTable(result.data);
        } else {
          // Tampilkan pesan kesalahan
          const errors = result.errors;
          for (let field in errors) {
            const errorMessage = document.querySelector(
              `[name="${field}"]`
            ).nextElementSibling;
            if (errorMessage) {
              errorMessage.textContent = errors[field];
            }
          }
          // Logging error untuk debugging
          if (result.error) {
            console.error("Database error:", result.error);
          }
        }
      } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat mengajukan pengajuan.");
      }
    });
  }

  function updateTable(data) {
    const tableBody = document.getElementById("progressBody");
    const newRow = document.createElement("tr");

    newRow.innerHTML = `
      <td>${data.id}</td>
      <td>${data.nama_pengaju}</td>
      <td>${data.alamat_pengaju}</td>
      <td>${data.lokasi_kegiatan}</td>
      <td>${data.jenis_kegiatan}</td>
      <td>${data.durasi}</td>
      <td>${data.jalur_alternatif}</td>
      <td>${data.status}</td>
      <td>${data.tanggal_dibuat}</td>
    `;

    tableBody.appendChild(newRow);
  }
});
