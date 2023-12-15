<?php
include 'koneksi.php';
session_start();


if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true && isset($_SESSION['id_komunitas'])) {
    $id_komunitas_login = $_SESSION['id_komunitas'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnBuatKegiatan'])) {
        // Ambil data dari formulir
        $namaKegiatan = isset($_POST['namaKegiatan']) ? $_POST['namaKegiatan'] : '';
        $jenisKegiatan = isset($_POST['jenisKegiatan']) ? $_POST['jenisKegiatan'] : '';
        $lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
        $tanggalMulai = isset($_POST['tanggalMulai']) ? $_POST['tanggalMulai'] : '';
        $tanggalBerakhir = isset($_POST['tanggalBerakhir']) ? $_POST['tanggalBerakhir'] : '';
        $batasRegistrasi = isset($_POST['batasRegistrasi']) ? $_POST['batasRegistrasi'] : '';
        $metodeBriefing = isset($_POST['metodeBriefing']) ? $_POST['metodeBriefing'] : '';
        $namaPekerjaan = isset($_POST['namaPekerjaan']) ? $_POST['namaPekerjaan'] : '';
        $relawanDibutuhkan = isset($_POST['relawanDibutuhkan']) ? $_POST['relawanDibutuhkan'] : '';
        $totalJamKerja = isset($_POST['totalJamKerja']) ? $_POST['totalJamKerja'] : '';
        $tugasRelawan = isset($_POST['tugasRelawan']) ? $_POST['tugasRelawan'] : '';
        $kriteriaRelawan = isset($_POST['kriteriaRelawan']) ? $_POST['kriteriaRelawan'] : '';
        $perlengkapanRelawan = isset($_POST['perlengkapanRelawan']) ? $_POST['perlengkapanRelawan'] : '';

        // Ambil data komunitas dari database berdasarkan id komunitas yang login
        $sqlKomunitas = "SELECT id_komunitas, nama_komunitas, foto FROM komunitas WHERE id_komunitas = ?";
        $stmtKomunitas = mysqli_prepare($koneksi, $sqlKomunitas);
        mysqli_stmt_bind_param($stmtKomunitas, "i", $id_komunitas_login);
        mysqli_stmt_execute($stmtKomunitas);
        $resultKomunitas = mysqli_stmt_get_result($stmtKomunitas);

        if ($resultKomunitas && mysqli_num_rows($resultKomunitas) > 0) {
            $rowKomunitas = mysqli_fetch_assoc($resultKomunitas);
            $idKomunitas = $rowKomunitas['id_komunitas'];
            $namaKomunitas = $rowKomunitas['nama_komunitas'];
            $fotokomunitas = $rowKomunitas['foto'];

            // Simpan file foto kegiatan ke direktori 'files_kegiatan'
            $folder_kegiatan = "./files_kegiatan/";
            $fotoKegiatan = isset($_FILES['fotoKegiatan']['name']) ? $_FILES['fotoKegiatan']['name'] : '';

            // Pengecekan apakah file foto kegiatan telah diunggah
            if (!empty($fotoKegiatan)) {
                $path_foto_kegiatan = $folder_kegiatan . $fotoKegiatan;
                move_uploaded_file($_FILES['fotoKegiatan']['tmp_name'], $path_foto_kegiatan);
            }

            // Insert data ke database menggunakan prepared statement
            $sqlInsert = "INSERT INTO kegiatan (id_komunitas, nama_komunitas, fotoKomunitas, namaKegiatan, jenisKegiatan, lokasi, tanggalMulai, tanggalBerakhir, batasRegistrasi, metodeBriefing, namaPekerjaan, relawanDibutuhkan, totalJamKerja, tugasRelawan, kriteriaRelawan, perlengkapanRelawan, fotoKegiatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = mysqli_prepare($koneksi, $sqlInsert);

            // Sesuaikan urutan variabel dengan jumlah tanda tanya
            mysqli_stmt_bind_param($stmtInsert, "issssssssssssssss", $idKomunitas, $namaKomunitas, $fotokomunitas, $namaKegiatan, $jenisKegiatan, $lokasi, $tanggalMulai, $tanggalBerakhir, $batasRegistrasi, $metodeBriefing, $namaPekerjaan, $relawanDibutuhkan, $totalJamKerja, $tugasRelawan, $kriteriaRelawan, $perlengkapanRelawan, $fotoKegiatan);

            if (mysqli_stmt_execute($stmtInsert)) {
                // Tampilkan pesan sukses
                echo "<script>alert('Kegiatan berhasil dibuat!');</script>";
            } else {
                // Tampilkan pesan error
                echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
            }
        } else {
            // Handle jika data komunitas tidak ditemukan
            die("Error: Data komunitas tidak ditemukan");
        }
    }
} else {
    // Jika pengguna belum login atau tidak memiliki sesi id_komunitas
    echo "Silakan login dan pilih komunitas terlebih dahulu.";
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
    <link rel="stylesheet" href="assets/css/dashboard.css">
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
                <a class="nav-link" href="buat_kegiatan.php">
                    <i class="bi bi-activity"></i>
                    <span>Membuat Kegiatan</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="laporan_komunitas.php">
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
            <h1>Buat Kegiatan</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-8" style="margin: 0 auto;">
                    <div class="card" style="width: 100%; max-width: 800px;">
                        <div class="card-body">
                            <h5 class="card-title text-center">Buat Kegiatan</h5>
                            <!-- Vertical Form -->
                            <form class="row g-3" action="buat_kegiatan.php" method="post" id="buatKegiatanForm" enctype="multipart/form-data">
                                <input type="hidden" name="idKomunitas" value="<?php echo $idKomunitas; ?>">
                                <input type="hidden" name="idKomunitas" value="<?php echo $fotoKomunitas; ?>">
                                <input type="hidden" name="idKomunitas" value="<?php echo $namaKomunitas; ?>">

                                <div class="form-group" style="width: 100%;">
                                    <label for="fotoKegiatan">Foto Kegiatan</label>
                                    <input type="file" class="form-control" id="fotoKegiatan" name="fotoKegiatan" placeholder="Foto Kegiatan" required>

                                </div>

                                <div class="form-group" style="width: 100%;">
                                    <label for="namaKegiatan">Nama Kegiatan</label>
                                    <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" placeholder="Nama Kegiatan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="jenisKegiatan">Jenis Kegiatan</label>
                                    <input type="text" class="form-control" id="jenisKegiatan" name="jenisKegiatan" placeholder="Jenis Kegiatan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="tanggalMulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" placeholder="Tanggal Mulai" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="tanggalBerakhir">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="tanggalBerakhir" name="tanggalBerakhir" placeholder="Tanggal Berakhir" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="batasRegistrasi">Batas Registrasi</label>
                                    <input type="date" class="form-control" id="batasRegistrasi" name="batasRegistrasi" placeholder="Batas Registrasi" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="metodeBriefing">Metode Briefing</label>
                                    <input type="text" class="form-control" id="metodeBriefing" name="metodeBriefing" placeholder="Metode Briefing" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="namaPekerjaan">Nama Pekerjaan</label>
                                    <input type="text" class="form-control" id="namaPekerjaan" name="namaPekerjaan" placeholder="Nama Pekerjaan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="relawanDibutuhkan">Relawan Dibutuhkan</label>
                                    <input type="text" class="form-control" id="relawanDibutuhkan" name="relawanDibutuhkan" placeholder="Jumlah Relawan Dibutuhkan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="totalJamKerja">Total Jam Kerja</label>
                                    <input type="text" class="form-control" id="totalJamKerja" name="totalJamKerja" placeholder="Total Jam Kerja" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="tugasRelawan">Tugas Relawan</label>
                                    <input type="text" class="form-control" id="tugasRelawan" name="tugasRelawan" placeholder="Tugas Relawan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="kriteriaRelawan">Kriteria Relawan</label>
                                    <input type="text" class="form-control" id="kriteriaRelawan" name="kriteriaRelawan" placeholder="Kriteria Relawan" required>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label for="perlengkapanRelawan">Perlengkapan Relawan</label>
                                    <input type="text" class="form-control" id="perlengkapanRelawan" name="perlengkapanRelawan" placeholder="Perlengkapan Relawan" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" style="width: max-content" id="btnBuatKegiatan" name="btnBuatKegiatan">Buat Kegiatan</button>
                                </div>
                            </form><!-- Vertical Form -->
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



</body>

</html>