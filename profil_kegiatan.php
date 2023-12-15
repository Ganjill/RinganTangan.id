<?php
include 'koneksi.php';
session_start();
$isRelawanLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'];

// Ambil ID dari URL
$idKegiatan = isset($_GET['id']) ? intval($_GET['id']) : 0; // Pastikan nilai ID adalah integer

if ($idKegiatan > 0) {
  // Query untuk mendapatkan detail kegiatan menggunakan ID
  $sqlKegiatan = "SELECT * FROM kegiatan WHERE id_kegiatan = ?";
  $stmt = mysqli_prepare($koneksi, $sqlKegiatan);
  mysqli_stmt_bind_param($stmt, 'i', $idKegiatan);
  mysqli_stmt_execute($stmt);

  $resultKegiatan = mysqli_stmt_get_result($stmt);

  if ($resultKegiatan && mysqli_num_rows($resultKegiatan) > 0) {
    $rowKegiatan = mysqli_fetch_assoc($resultKegiatan);
    $fotoKegiatan = $rowKegiatan['fotoKegiatan'];
    $idKomunitas = $rowKegiatan['id_komunitas'];

    // Query untuk mendapatkan data komunitas
    $sqlKomunitas = "SELECT * FROM komunitas WHERE id_komunitas = ?";
    $stmtKomunitas = mysqli_prepare($koneksi, $sqlKomunitas);
    mysqli_stmt_bind_param($stmtKomunitas, 'i', $idKomunitas);
    mysqli_stmt_execute($stmtKomunitas);

    $resultKomunitas = mysqli_stmt_get_result($stmtKomunitas);

    if ($resultKomunitas && mysqli_num_rows($resultKomunitas) > 0) {
      $rowKomunitas = mysqli_fetch_assoc($resultKomunitas);
      $fotoKomunitas = $rowKomunitas['foto'];
    } else {
      // Handle jika data komunitas tidak ditemukan
      $fotoKomunitas = 'default.jpg'; // Ganti dengan nama default gambar jika diperlukan
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmtKomunitas);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>RinganTangan</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <?php include('form/head.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include('form/navbar_dashboard.php'); ?>
  <main id="main">


    <!-- ======= Blog Details Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row g-5">

          <div class="col-lg-8">

            <article class="blog-details">
              <div class="post-img">
                <img src="./files_kegiatan/<?php echo $fotoKegiatan; ?>" alt="Foto Kegiatan" class="" style="width: 100%;">
              </div>

              <!-- Nama komunitas -->
              <div class="d-flex align-items-center">
                <img src="./files_komunitas/<?php echo $fotoKomunitas; ?>" alt="Foto Komunitas" class="rounded-circle flex-shrink-0" style="max-width: 40px; margin-right: 10px;">
                <div>
                  <h6>
                    <?php echo $rowKegiatan['nama_komunitas']; ?>
                  </h6>
                  <!-- Sesuaikan tautan berikut dengan URL ke halaman profil komunitas -->
                  <h6 style="margin-bottom: 5px; line-height: 1.2;"> <a href="profil_komunitas.php?id=<?php echo $rowKegiatan['id_komunitas']; ?>">Lihat Profil
                      Komunitas</a></h6>
                  <div class="social-links">
                    <!-- Mungkin Anda ingin menambahkan tautan media sosial komunitas di sini -->
                  </div>
                </div>
              </div>
              <!-- Nama komunitas -->

              <!-- Detail Aktivitas -->
              <div class="sidebar my-4">
                <div class="sidebar-item recent-posts">
                  <h3 class="sidebar-title my-3">Pekerjaan</h3>
                  <div class="d-flex " style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 163px; min-height: 20px;">Metode Briefing</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data pekerjaan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['metodeBriefing'])) {
                        echo $rowKegiatan['metodeBriefing'];
                      } else {
                        echo "Metode Briefing Tidak Ditemukan";
                      }
                      ?>
                    </p>
                  </div>
                </div>
                <hr>
                <div class="sidebar-item recent-posts">
                  <h3 class="sidebar-title d-flex">Detail Aktivitas</h3>

                  <div class="d-flex my-3" style="font-size: 10px">
                    <p style="margin-right: 160px;">Metode Briefing</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data metode briefing tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['metodeBriefing'])) {
                        echo $rowKegiatan['metodeBriefing'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>

                  <hr>

                  <div class="d-flex " style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 163px; min-height: 20px;">Nama Pekerjaan</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data nama pekerjaan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['namaPekerjaan'])) {
                        echo $rowKegiatan['namaPekerjaan'];
                      } else {
                        echo "Pekerjaan tidak ditemukan";
                      }
                      ?>
                    </p>
                  </div>

                  <div class="d-flex" style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 131px; min-height: 20px;">Relawan Dibutuhkan</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data relawan dibutuhkan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['relawanDibutuhkan'])) {
                        echo $rowKegiatan['relawanDibutuhkan'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>

                  <div class="d-flex" style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 173px; min-height: 20px;">Total Jam Kerja</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data total jam kerja tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['totalJamKerja'])) {
                        echo $rowKegiatan['totalJamKerja'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>
                  <div class="d-flex" style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 170px; min-height: 20px;">Tugas Relawan</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data tugas relawan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['tugasRelawan'])) {
                        echo $rowKegiatan['tugasRelawan'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>

                  <div class="d-flex" style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 160px; min-height: 20px;">Kriteria Relawan</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data kriteria relawan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['kriteriaRelawan'])) {
                        echo $rowKegiatan['kriteriaRelawan'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>

                  <div class="d-flex" style="font-size: 10px; margin-bottom: 5px;">
                    <p style="margin-right: 115px; min-height: 20px;">Perlengkapan Relawan</p>
                    <p style="min-height: 20px; margin-right: auto;">
                      <?php
                      // Cek apakah data perlengkapan relawan tersedia dalam $rowKegiatan
                      if (isset($rowKegiatan['perlengkapanRelawan'])) {
                        echo $rowKegiatan['perlengkapanRelawan'];
                      } else {
                        echo "Informasi tidak tersedia";
                      }
                      ?>
                    </p>
                  </div>
                </div>
                <hr>
                <div class="sidebar-item recent-posts">
                  <h3 class="sidebar-title d-flex">Relawan</h3>
                  <div class="d-flex my-3" style="font-size: 10px">
                    <p style="margin-right: 160px;">Jumlah Relawan</p>
                    <p>Online</p>
                  </div>
                </div>
                <!-- Detail Aktivitas -->
            </article><!-- End blog post -->

          </div>

          <div class="col-lg-4">


            <div class="sidebar">

              <div class="sidebar-item categories">
                <h3 class="sidebar-title">Categories</h3>
                <ul class="mt-3">
                  <li>Jenis Kegiatan:
                    <?php echo isset($rowKegiatan['jenisKegiatan']) ? $rowKegiatan['jenisKegiatan'] : "Belum Ditetapkan"; ?>
                  </li>
                  <li>Tanggal Mulai:
                    <?php echo isset($rowKegiatan['tanggalMulai']) ? $rowKegiatan['tanggalMulai'] : "Belum Ditetapkan"; ?>
                  </li>
                  <li>Tanggal Berakhir:
                    <?php echo isset($rowKegiatan['tanggalBerakhir']) ? $rowKegiatan['tanggalBerakhir'] : "Belum Ditetapkan"; ?>
                  </li>
                  <li>Lokasi:
                    <?php echo isset($rowKegiatan['lokasi']) ? $rowKegiatan['lokasi'] : "Belum Ditetapkan"; ?>
                  </li>
                  <li style="color:red">Batas Registrasi:
                    <?php echo isset($rowKegiatan['batasRegistrasi']) ? $rowKegiatan['batasRegistrasi'] : "Belum Ditetapkan"; ?>
                  </li>
                  <div class="sidebar-item tags d-flex w-100 my-1">
                    <ul class="w-100">
                      <li class="w-100">
                        <?php
                        // Tampilkan status kegiatan (berakhir atau belum)
                        $status = isset($rowKegiatan['status']) ? $rowKegiatan['status'] : "Belum Ditetapkan";
                        ?>
                        <a class="w-100 d-block text-center btn <?php echo $status === "Berakhir" ? "btn-danger" : "btn-success"; ?>" style="color: white;">
                          <?php
                          echo $status === "Berakhir" ? "Sudah Berakhir" : "Belum Berakhir";
                          ?>
                        </a>
                      </li>
                    </ul>
                  </div><!-- End sidebar tags -->

                </ul>
              </div><!-- End sidebar categories-->

              <?php
              $batasRegistrasi = isset($rowKegiatan['batasRegistrasi']) ? strtotime($rowKegiatan['batasRegistrasi']) : null;

              echo '<div class="sidebar-item tags d-flex w-100">';
              echo '<ul class="w-100">';
              echo '<li class="w-100">';
              if ($batasRegistrasi && time() < $batasRegistrasi) {
                // Jika batas waktu pendaftaran belum berlalu
                if ($isRelawanLoggedIn) {
                  echo '<a href="#" class="w-100 d-block text-center btn btn-warning" style="color: black;" onclick="showPopup()">Ayo Daftar Jadi Relawan</a>';
                } else {
                  echo '<a href="login.php" class="w-100 d-block text-center btn btn-warning" style="color: black;">Login untuk Jadi Relawan</a>';
                }
              } else {
                // Jika batas waktu pendaftaran telah berlalu
                echo '<a class="w-100 d-block text-center btn btn-danger" style="color: white;">Pendaftaran telah ditutup</a>';
              }
              echo '</li>';
              echo '</ul>';
              echo '</div>';

              ?>

            </div><!-- End Blog Sidebar -->
          </div>
        </div>

      </div>
    </section><!-- End Blog Details Section -->

    <!-- pop up -->
    <div id="popup" class="popup-container">
      <div class="form my-4">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-offset-3 col-md-6">
              <div class="form-container">
                <span class="close" onclick="closePopup()">&times;</span>
                <h3 style="color: #000;font-size: 25px;font-weight: 600;text-transform: capitalize;margin: 0 0 25px;text-align: center; padding-bottom: 10px; border-bottom: 3px solid #00A9EF;">
                  Pendaftaran Kegiatan</h3>
                <form class="form-horizontal" method="post">
                  <div class="form-group" style="width: 100%;">
                    <label>Nama Komunitas</label>
                    <input type="text" class="form-control" name="namaKomunitas" value="<?php echo isset($rowKegiatan['nama_komunitas']) ? $rowKegiatan['nama_komunitas'] : ''; ?>" readonly>
                  </div>

                  <div class="form-group" style="width: 100%;">
                    <label>Nama Kegiatan</label>
                    <input type="text" class="form-control" name="namaKegiatan" value="<?php echo isset($rowKegiatan['namaKegiatan']) ? $rowKegiatan['namaKegiatan'] : ''; ?>" readonly>
                  </div>

                  <div class="form-group" style="width: 100%;">
                    <label>Nama Relawan</label>
                    <input type="text" class="form-control" name="namaRelawan" value="<?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : ''; ?>" readonly>
                  </div>


                  <div class="form-group" style="width: 100%;">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly>>
                  </div>

                  <div class="form-group" style="width: 100%;">
                    <label>Alasan</label>
                    <textarea class="form-control" name="alasan" placeholder="Mengapa Anda Tertarik Mengikuti Kegiatan ini?" rows="3" required></textarea>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn signup" style="width: max-content;" name="submit_form">Kirim
                      Formulir Pendaftaran</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- pop up -->


    <!-- Modal Keberhasilan -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Pendaftaran Berhasil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="successMessage">Terima kasih telah mendaftar! Pendaftaran Anda untuk kegiatan ini berhasil.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>


  </main><!-- End #main -->


  <?php
  // Menangani pengiriman formulir
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_form'])) {
      $email = mysqli_real_escape_string($koneksi, $_POST['email']);
      $alasan = mysqli_real_escape_string($koneksi, $_POST['alasan']);

      // Pastikan untuk menyesuaikan nilai dari kolom lain sesuai dengan kebutuhan
      $id_kegiatan = isset($rowKegiatan['id_kegiatan']) ? $rowKegiatan['id_kegiatan'] : 0;
      $id_komunitas = isset($rowKegiatan['id_komunitas']) ? $rowKegiatan['id_komunitas'] : 0;

      $namaKomunitas = isset($rowKegiatan['nama_komunitas']) ? $rowKegiatan['nama_komunitas'] : '';
      $namaKegiatan = isset($rowKegiatan['namaKegiatan']) ? $rowKegiatan['namaKegiatan'] : '';

      // Retrieve the volunteer's name from the session
      $namaRelawan = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';

      // Periksa apakah relawan sudah mendaftar sebelumnya
      $sqlCheckPendaftaran = "SELECT * FROM pendaftaran WHERE id_kegiatan = '$id_kegiatan' AND email = '$email'";
      $resultCheckPendaftaran = mysqli_query($koneksi, $sqlCheckPendaftaran);

      if ($resultCheckPendaftaran && mysqli_num_rows($resultCheckPendaftaran) > 0) {
        // Relawan sudah mendaftar sebelumnya, tampilkan pesan kesalahan
        echo '<script type="text/javascript">
              document.addEventListener("DOMContentLoaded", function() {
                alert("Anda sudah mendaftar untuk kegiatan ini sebelumnya.");
              });
            </script>';
      } else {
        // Relawan belum mendaftar, lanjutkan penyimpanan data
        $sqlInsertPendaftaran = "INSERT INTO pendaftaran (id_kegiatan, id_komunitas, namaKomunitas, namaKegiatan, nama_relawan, email, alasan) 
                          VALUES ('$id_kegiatan', '$id_komunitas', '$namaKomunitas', '$namaKegiatan', '$namaRelawan', '$email', '$alasan')";

        if (mysqli_query($koneksi, $sqlInsertPendaftaran)) {
          // Ganti dengan pemanggilan fungsi untuk menampilkan modal keberhasilan
          echo '<script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                  showSuccessModal();
                  closePopup(); // Menutup pop-up formulir setelah menampilkan modal keberhasilan
                  // Mengganti teks pesan keberhasilan di dalam modal
                  document.getElementById("successMessage").innerHTML = "Anda berhasil mendaftar!";
                });
              </script>';
        } else {
          // Gagal menyimpan data
          echo "Error: " . $sqlInsertPendaftaran . "<br>" . mysqli_error($koneksi);
        }
      }
    }
  }
  ?>



  <script>
    $(document).ready(function() {
      // Function to show the success modal
      function showSuccessModal() {
        $('#successModal').modal('show');
      }

      // Function to show the popup
      function showPopup() {
        $('#popup').css('display', 'block');
      }

      // Function to close the popup
      function closePopup() {
        $('#popup').css('display', 'none');
      }

      // Call showSuccessModal function when the form is submitted successfully
      <?php
      // Menangani pengiriman formulir
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit_form'])) {
          // ... (proses validasi dan penyimpanan ke database)

          // Panggil fungsi showSuccessModal setelah formulir terkirim
          echo 'showSuccessModal();';
        }
      }
      ?>
    });
  </script>

  <!-- ======= Footer ======= -->
  <?php include('form/footer.php'); ?>
</body>

</html>