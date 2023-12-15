<?php
include 'koneksi.php';
session_start();
// Tambahan: Periksa apakah variabel $id_komunitas sudah didefinisikan
if (isset($_SESSION['id_komunitas'])) {
    $id_komunitas = $_SESSION['id_komunitas'];

    // ... (sisa kode Anda)
    // Selanjutnya, gunakan variabel $id_komunitas dalam kueri SQL Anda
} else {
    // Variabel $id_komunitas tidak terdefinisi, lakukan tindakan yang sesuai
    echo "ID Komunitas tidak valid.";
}
?>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .form-group label {
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>


    <?php include('form/navbar.php'); ?>

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
                <a class="nav-link" href="laporan_komunitas.php">
                    <i class="bi bi-envelope"></i>
                    <span>Laporan</span>
                </a>
            </li><!-- End laporan -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-komunitas.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Laporan</h1>
            <nav>
            </nav>
        </div><!-- End Page Title -->

        <section id="blog" class="blog dashboard">
            <div class="card info-card customers-card">
                <div class="col-lg-12">
                    <div class="comments">
                        <?php
                        // Kueri SQL untuk mendapatkan data laporan dan relawan

                        $sql_laporan = "SELECT laporan.*, relawan.nama AS nama_relawan, relawan.id_relawan, relawan.foto AS foto_relawan, kegiatan.namaKegiatan, kegiatan.nama_komunitas
                FROM laporan
                LEFT JOIN relawan ON laporan.id_relawan = relawan.id_relawan
                LEFT JOIN kegiatan ON laporan.id_kegiatan = kegiatan.id_kegiatan
                WHERE laporan.namaKegiatan IS NOT NULL AND kegiatan.id_komunitas = $id_komunitas
                ORDER BY laporan.tanggal DESC"; // Sesuaikan dengan kolom yang sesuai di tabel laporan

                        $result_laporan = mysqli_query($koneksi, $sql_laporan);
                        // Periksa apakah ada data laporan
                        if ($result_laporan && mysqli_num_rows($result_laporan) > 0) {
                            echo '<h4 class="comments-count">' . mysqli_num_rows($result_laporan) . ' Laporan</h4>';

                            while ($row_laporan = mysqli_fetch_assoc($result_laporan)) {
                                $namaRelawan = $row_laporan['nama_relawan'];
                                $tanggal = $row_laporan['tanggal'];
                                $komentar = $row_laporan['komentar'];
                                $idRelawan = $row_laporan['id_relawan'];
                                $namaKegiatan = $row_laporan['namaKegiatan']; // Sesuaikan dengan kolom yang sesuai di tabel laporan
                                $namaKomunitas = $row_laporan['nama_komunitas']; // Sesuaikan dengan kolom yang sesuai di tabel kegiatan

                                // Mendapatkan nama file foto relawan dari database
                                $namaFileFoto = $row_laporan['foto_relawan'];

                                // Mendapatkan URL lengkap foto relawan
                                $urlFotoRelawan = 'files_relawan/' . $namaFileFoto;

                                // Jika nama file foto tidak ada, gunakan foto default
                                if (empty($namaFileFoto) || !file_exists($urlFotoRelawan)) {
                                    $urlFotoRelawan = 'assets/img/profil.jpg';
                                }
                        ?>
                                <div class="comment" id="comment-<?php echo $idRelawan; ?>">
                                    <div class="d-flex">
                                        <div class="comment-img"><img src="<?php echo $urlFotoRelawan; ?>" alt="Foto Relawan"></div>
                                        <div>
                                            <h5><a href="#"><?php echo $namaRelawan; ?></a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a></h5>
                                            <p style="margin-bottom: 0px; font-size: 14px; font-weight: bold; color: #00b6a1;">
                                                <?php echo $namaKegiatan; ?>
                                            </p>
                                            <time datetime="<?php echo $tanggal; ?>"><?php echo $tanggal; ?></time>
                                            <p>
                                                <?php echo $komentar; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div><!-- End comment -->
                        <?php
                            }
                        } else {
                            echo '<h4 class="comments-count mx-3">Belum ada laporan.</h4>';
                        }
                        ?>
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




</body>

</html>