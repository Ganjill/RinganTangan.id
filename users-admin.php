<?php
// Sambungkan ke database
require_once "koneksi.php";
session_start();

// Periksa apakah variabel sesi id_admin terdefinisi
if (isset($_SESSION['id_admin'])) {
  // Jika ya, ambil nilainya
  $id_admin = $_SESSION['id_admin'];

  // Lakukan query untuk mendapatkan informasi admin berdasarkan $id_admin
  $sql = "SELECT * FROM admin WHERE id_admin = $id_admin ORDER BY id_admin DESC";
  $result = mysqli_query($koneksi, $sql);

  // Inisialisasi variabel dengan nilai default
  $foto = "assets/img/profil.jpg"; // Ganti "default.jpg" dengan nama file gambar default yang sesuai
  $deskripsi = "Tidak ada Deskripsi";

  // Periksa apakah ada hasil
  if ($result && mysqli_num_rows($result) > 0) {
    // Ambil data dari baris hasil
    $row = mysqli_fetch_assoc($result);
    $namaAdmin = $row['nama_admin'];
    $email = $row['email'];

    // Check apakah 'foto' tidak kosong
    if (!empty($row['foto'])) {
      // Mengasumsikan gambar disimpan di direktori 'files_admin'
      $foto = "files_admin/" . $row['foto'];
    }
    // Tambahkan logika lain sesuai kebutuhan
  } else {
    // Tampilkan pesan jika tidak ada data admin
    $namaAdmin = "Belum ada admin";
    $deskripsi = "Tidak ada Deskripsi";
  }
} else {
  // Jika id_admin tidak terdefinisi
  echo "ID Admin tidak valid.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <?php include('form/head.php'); ?>
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>

  <body>

    <?php include('form/navbar.php'); ?>

    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link collapsed" href="dashboard_admin.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link" href="users-admin.php">
            <i class="bi bi-person"></i>
            <span>Profile</span>
          </a>
        </li><!-- End Profile Page Nav -->
      </ul>

    </aside><!-- End Sidebar-->


    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
        </nav>
      </div><!-- End Page Title -->

      <section class="section profile">
        <div class="row">
          <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <?php
                // Tentukan path gambar default
                $gambarDefault = "assets/img/profil.jpg";
                // Cek apakah ada gambar yang diunggah
                $gambarProfil = isset($foto) ? $foto : $gambarDefault;
                ?>
                <img src="<?php echo $gambarProfil; ?>" alt="Profile" class="" style="border-radius: 50%;">
                <h2>
                  <?php echo $namaAdmin; ?>
                </h2>
              </div>
            </div>


          </div>

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h5 class="card-title">Profile Details</h5>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $namaAdmin; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $email; ?>
                      </div>
                    </div>
                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
        </div>
      </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('form/footer.php'); ?>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/dashboard.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
      function uploadProfileImage() {
        var fileInput = document.getElementById('profileImage');
        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('profileImage', file);

        $.ajax({
          url: 'form/upload.php', // Ganti dengan URL backend Anda
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            // Handle the response, e.g., update the profile image on the page
            $('#previewImage').attr('src', 'assets/img/profil.jpg'); // Ganti dengan path yang sesuai
          },
          error: function(error) {
            console.log('Error uploading profile image:', error);
          }
        });
      }

      function removeProfileImage() {
        // Tambahkan logika untuk menghapus gambar profil dari database
      }
    </script>


  </body>

</html>