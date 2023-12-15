<?php
// Sambungkan ke database
require_once "koneksi.php";
session_start();

// Periksa apakah variabel sesi id_komunitas terdefinisi
if (isset($_SESSION['id_komunitas'])) {
  // Jika ya, ambil nilainya
  $idKomunitas = $_SESSION['id_komunitas'];

  // Lakukan query untuk mendapatkan informasi komunitas berdasarkan $idKomunitas
  $sql = "SELECT * FROM komunitas WHERE id_komunitas = $idKomunitas";
  $result = mysqli_query($koneksi, $sql);

  // Inisialisasi variabel $foto dengan nilai default
  $foto = "assets/img/profil.jpg"; // Ganti "default.jpg" dengan nama file gambar default yang sesuai

  // Periksa apakah ada hasil
  if ($result && mysqli_num_rows($result) > 0) {
    // Ambil data dari baris hasil
    $row = mysqli_fetch_assoc($result);
    $namaKomunitas = $row['nama_komunitas'];
    $email = $row['email'];
    $ketua = $row['ketua'];
    $lokasi = $row['lokasi'];
    $tgl_berdiri = $row['tgl_berdiri'];
    $deskripsi = $row['deskripsi'];
    // Tambahkan logika lain sesuai kebutuhan

    // Check apakah 'foto' tidak kosong
    if (!empty($row['foto'])) {
      // Mengasumsikan gambar disimpan di direktori 'files_komunitas'
      $foto = "files_komunitas/" . $row['foto'];
    }
  } else {
    // Tampilkan pesan jika tidak ada data komunitas
    $namaKomunitas = "Belum ada komunitas";
  }
} else {
  // Jika id_komunitas tidak terdefinisi
  echo "ID Komunitas tidak valid.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Tangkap data dari formulir edit
  $namakomunitas = mysqli_real_escape_string($koneksi, $_POST["namakomunitas"]);
  $namaketua = mysqli_real_escape_string($koneksi, $_POST["namaketua"]);
  $deskripsi = mysqli_real_escape_string($koneksi, $_POST["deskripsi"]);
  $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
  $lokasi = mysqli_real_escape_string($koneksi, $_POST["lokasi"]);

  // Hapus laporan terkait dengan pendaftaran yang akan dihapus
  $deleteLaporanSql = "DELETE FROM laporan WHERE id_pendaftaran IN (SELECT id_pendaftaran FROM pendaftaran WHERE id_kegiatan IN (SELECT id_kegiatan FROM kegiatan WHERE nama_komunitas = '$namaKomunitas'))";
  $resultDeleteLaporan = mysqli_query($koneksi, $deleteLaporanSql);

  if (!$resultDeleteLaporan) {
    echo "Terjadi kesalahan saat menghapus laporan terkait.";
    // Handle error atau berikan pesan kesalahan sesuai kebutuhan
  } else {
    // Hapus pendaftaran terkait dengan kegiatan yang akan dihapus
    $deletePendaftaranSql = "DELETE FROM pendaftaran WHERE id_kegiatan IN (SELECT id_kegiatan FROM kegiatan WHERE nama_komunitas = '$namaKomunitas')";
    $resultDeletePendaftaran = mysqli_query($koneksi, $deletePendaftaranSql);

    if (!$resultDeletePendaftaran) {
      echo "Terjadi kesalahan saat menghapus pendaftaran terkait.";
      // Handle error atau berikan pesan kesalahan sesuai kebutuhan
    } else {
      // Hapus kegiatan yang terkait dengan komunitas tertentu
      $deleteKegiatanSql = "DELETE FROM kegiatan WHERE nama_komunitas = '$namaKomunitas'";
      $resultDeleteKegiatan = mysqli_query($koneksi, $deleteKegiatanSql);

      if (!$resultDeleteKegiatan) {
        echo "Terjadi kesalahan saat menghapus kegiatan terkait.";
        // Handle error atau berikan pesan kesalahan sesuai kebutuhan
      } else {
        // Penanganan file gambar
        if ($_FILES["profileImage"]["error"] == 0) {
          $uploadDir = "files_komunitas/";
          $uploadFile = $uploadDir . basename($_FILES["profileImage"]["name"]);

          // Pindahkan file gambar ke direktori upload
          if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $uploadFile)) {
            // File berhasil diunggah, perbarui nama file di database atau sesuai kebutuhan
            $updateSql = "UPDATE komunitas SET 
                                    nama_komunitas = '$namakomunitas',
                                    ketua = '$namaketua',
                                    deskripsi = '$deskripsi',
                                    email = '$email',
                                    lokasi = '$lokasi',
                                    foto = '" . basename($_FILES["profileImage"]["name"]) . "'
                                    WHERE id_komunitas = $idKomunitas";

            $result = mysqli_query($koneksi, $updateSql);

            if ($result) {
              echo "Perubahan profil berhasil disimpan.";
            } else {
              echo "Terjadi kesalahan. Silakan coba lagi.";
            }
          } else {
            echo "Terjadi kesalahan saat mengunggah file.";
          }
        } else {
          // Jika tidak ada file gambar diunggah, perbarui data lainnya
          $updateSql = "UPDATE komunitas SET 
                                    nama_komunitas = '$namakomunitas',
                                    ketua = '$namaketua',
                                    deskripsi = '$deskripsi',
                                    email = '$email',
                                    lokasi = '$lokasi'
                                    WHERE id_komunitas = $idKomunitas";

          $result = mysqli_query($koneksi, $updateSql);

          if ($result) {
            echo "Perubahan profil berhasil disimpan.";
          } else {
            echo "Terjadi kesalahan. Silakan coba lagi.";
          }
        }
      }
    }
  }
}
?>



<!DOCTYPE html>
<!-- ... (sisa kode HTML tetap sama) ... -->

</html>


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
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

  <body>
    <!-- ======= Header ======= -->
    <?php include('form/navbar.php'); ?><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link collapsed" href="dashboard_komunitas.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="buat_kegiatan.php">
            <i class="bi bi-activity"></i>
            <span>Buat Kegiatan</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="laporan_komunitas.php">
            <i class="bi bi-envelope"></i>
            <span>Laporan</span>
          </a>
        </li><!-- End laporan -->

        <li class="nav-item">
          <a class="nav-link" href="users-komunitas.php">
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
                  <?php echo $namaKomunitas; ?>
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
                    <h5 class="card-title">Tentang</h5>
                    <p class="small fst-italic">
                      <?php echo $deskripsi; ?>
                    </p>

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama Komunitas</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $namaKomunitas; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama Ketua</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $ketua; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $email; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Tanggal Berdiri</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $tgl_berdiri; ?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Lokasi</div>
                      <div class="col-lg-9 col-md-8">
                        <?php echo $lokasi; ?>
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

    <!-- Modal Pop Up -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Perubahan berhasil disimpan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Fungsi untuk menampilkan modal
      function showSuccessModal() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
      }

      // Tambahkan script berikut di bagian bawah body atau di bagian yang sesuai
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ... Kode pembaruan profil sebelumnya ...

        if ($result) {
          echo 'showSuccessModal();';
        }
      }
      ?>
    </script>
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


  </body>

</html>