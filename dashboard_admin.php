<?php
session_start();
require_once "koneksi.php";


// Periksa apakah variabel sesi id_admin terdefinisi
if (isset($_SESSION['id_admin'])) {
    // Jika ya, ambil nilainya
    $id_admin = $_SESSION['id_admin'];

    // Lakukan query untuk mendapatkan informasi admin berdasarkan $id_admin
    $sql_admin = "SELECT * FROM admin WHERE id_admin = $id_admin ORDER BY id_admin DESC";
    $result_admin = mysqli_query($koneksi, $sql_admin);

    // Inisialisasi variabel dengan nilai default
    $foto = "assets/img/profil.jpg"; // Ganti "default.jpg" dengan nama file gambar default yang sesuai

    // Periksa apakah ada hasil
    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        // Ambil data dari baris hasil
        $row_admin = mysqli_fetch_assoc($result_admin);
        $namaAdmin = $row_admin['nama_admin'];

        // Check apakah 'foto' tidak kosong
        if (!empty($row_admin['foto'])) {
            // Mengasumsikan gambar disimpan di direktori 'files_admin'
            $foto = "files_admin/" . $row_admin['foto'];
        }

        // Tambahkan kondisi untuk memeriksa apakah pengguna adalah admin
        // Pada contoh ini, kita mengasumsikan bahwa tidak perlu melakukan tindakan tambahan untuk admin
    } else {
        // Tampilkan pesan jika tidak ada data admin
        $namaAdmin = "Belum ada admin";
    }
} else {
    // Jika id_admin tidak terdefinisi
    echo "ID Admin tidak valid.";
}

// Query untuk mendapatkan semua data relawan
$sql_relawan = "SELECT * FROM relawan ORDER BY id_relawan DESC";
$result_relawan = mysqli_query($koneksi, $sql_relawan);

// Query untuk mendapatkan semua data komunitas
$sql_komunitas = "SELECT * FROM komunitas ORDER BY id_komunitas DESC";
$result_komunitas = mysqli_query($koneksi, $sql_komunitas);


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
        .edit-btn {
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .delete-btn {
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>

    <?php include('form/navbar.php'); ?>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="dashboard_admin.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-admin.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main" style="background-color:  #EBE5CC;">
        <div class="pagetitle">
            <h1>Dashboard</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tabel Relawan</h5>
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Relawan</th>
                                            <th scope="col">Tanggal Lahir</th>
                                            <th scope="col">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Loop untuk menampilkan semua data relawan
                                        $counter_relawan = 1;
                                        while ($row_relawan = mysqli_fetch_assoc($result_relawan)) {
                                            echo '<tr>';
                                            echo '<th scope="row">' . $counter_relawan . '</th>';
                                            echo '<td>' . $row_relawan['nama'] . '</td>';
                                            echo '<td>' . $row_relawan['tanggal_lahir'] . '</td>';
                                            echo '<td>' . $row_relawan['alamat'] . '</td>';
                                            echo '</tr>';
                                            $counter_relawan++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- End Primary Color Bordered Table -->
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tabel Komunitas</h5>
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Komunitas</th>
                                            <th scope="col">Tanggal Berdiri</th>
                                            <th scope="col">Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Loop untuk menampilkan semua data komunitas
                                        $counter_komunitas = 1;
                                        while ($row_komunitas = mysqli_fetch_assoc($result_komunitas)) {
                                            echo '<tr>';
                                            echo '<th scope="row">' . $counter_komunitas . '</th>';
                                            echo '<td>' . $row_komunitas['nama_komunitas'] . '</td>';
                                            echo '<td>' . $row_komunitas['tgl_berdiri'] . '</td>';
                                            echo '<td>' . $row_komunitas['lokasi'] . '</td>';
                                            echo '</tr>';
                                            $counter_komunitas++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- End Primary Color Bordered Table -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Query untuk mendapatkan jumlah relawan
                $sql_jumlah_relawan = "SELECT COUNT(*) as total_relawan FROM relawan";
                $result_jumlah_relawan = mysqli_query($koneksi, $sql_jumlah_relawan);
                $row_jumlah_relawan = mysqli_fetch_assoc($result_jumlah_relawan);
                $total_relawan = isset($row_jumlah_relawan['total_relawan']) ? $row_jumlah_relawan['total_relawan'] : 0;

                // Query untuk mendapatkan jumlah komunitas
                $sql_jumlah_komunitas = "SELECT COUNT(*) as total_komunitas FROM komunitas";
                $result_jumlah_komunitas = mysqli_query($koneksi, $sql_jumlah_komunitas);
                $row_jumlah_komunitas = mysqli_fetch_assoc($result_jumlah_komunitas);
                $total_komunitas = isset($row_jumlah_komunitas['total_komunitas']) ? $row_jumlah_komunitas['total_komunitas'] : 0;
                ?>

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Rangkuman</h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <?php
                                    // Tentukan path gambar default
                                    $gambarDefault = "assets/img/profil.jpg";
                                    // Cek apakah ada gambar yang diunggah
                                    $gambarProfil = isset($foto) ? $foto : $gambarDefault;
                                    ?>
                                    <img src="<?php echo $gambarProfil; ?>" class="rounded-circle flex-shrink-0" alt="Profil" style="max-width: 60px; margin-right: 10px;">
                                </div>
                                <div class="ps-3">
                                    <p>
                                        <?php echo $namaAdmin; ?>
                                    </p>
                                    <a href="users-admin.php">Lihat Profil</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center my-5">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php echo $total_relawan; ?>
                                    </h6>
                                    <span class="text-muted small pt-2 ps-1">Jumlah Relawan</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center my-5">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php echo $total_komunitas; ?>
                                    </h6>
                                    <span class="text-muted small pt-2 ps-1">Jumlah Komunitas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Right side columns -->
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