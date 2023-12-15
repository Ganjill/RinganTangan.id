<?php
session_start();
require_once "koneksi.php";


// Periksa apakah variabel sesi id_relawan terdefinisi
if (isset($_SESSION['id_relawan'])) {
    // Jika ya, ambil nilainya
    $id_relawan = $_SESSION['id_relawan'];

    // Lakukan query untuk mendapatkan informasi relawan berdasarkan $id_relawan
    $sql_relawan = "SELECT * FROM relawan WHERE id_relawan = $id_relawan ORDER BY id_relawan DESC";
    $result_relawan = mysqli_query($koneksi, $sql_relawan);

    // Inisialisasi variabel dengan nilai default
    $foto = "assets/img/profil.jpg"; // Ganti "default.jpg" dengan nama file gambar default yang sesuai

    // Periksa apakah ada hasil
    if ($result_relawan && mysqli_num_rows($result_relawan) > 0) {
        // Ambil data dari baris hasil
        $row_relawan = mysqli_fetch_assoc($result_relawan);
        $namaRelawan = $row_relawan['nama'];

        // Check apakah 'foto' tidak kosong
        if (!empty($row_relawan['foto'])) {
            // Mengasumsikan gambar disimpan di direktori 'files_relawan'
            $foto = "files_relawan/" . $row_relawan['foto'];
        }
    } else {
        // Tampilkan pesan jika tidak ada data relawan
        $namaRelawan = "Belum ada relawan";
    }
} else {
    // Jika id_relawan tidak terdefinisi
    echo "ID Relawan tidak valid.";
}

$jumlahAktivitas = 0;
// Kueri SQL untuk mendapatkan data pendaftaran relawan
$sql_pendaftaran = "SELECT * FROM pendaftaran WHERE nama_relawan = '" . $namaRelawan . "'";
$result_pendaftaran = mysqli_query($koneksi, $sql_pendaftaran);

// Inisialisasi array untuk menyimpan data pendaftaran
$pendaftaran = array();

// Periksa apakah ada hasil pendaftaran
if (mysqli_num_rows($result_pendaftaran) > 0) {
    while ($row_pendaftaran = mysqli_fetch_assoc($result_pendaftaran)) {
        $kegiatan_id = $row_pendaftaran['id_kegiatan'];
        $pendaftaran_item = array(
            'id_pendaftaran' => $row_pendaftaran['id_pendaftaran'],
            'id_kegiatan' => $row_pendaftaran['id_kegiatan'],
            'namaKomunitas' => $row_pendaftaran['namaKomunitas'],
            'namaKegiatan' => $row_pendaftaran['namaKegiatan'],
            'nama_relawan' => $row_pendaftaran['nama_relawan'],
            'email' => $row_pendaftaran['email'],
            'alasan' => $row_pendaftaran['alasan'],
        );

        // Tambahkan data pendaftaran ke array
        $pendaftaran[$kegiatan_id][] = $pendaftaran_item;

        // Tambahkan 1 ke jumlah aktivitas
        $jumlahAktivitas++;
    }
}

$jumlahLaporan = 0;

// Kueri SQL untuk mendapatkan data laporan relawan
$sql_laporan = "SELECT * FROM laporan WHERE id_relawan = '" . $id_relawan . "'";
$result_laporan = mysqli_query($koneksi, $sql_laporan);

// Inisialisasi array untuk menyimpan data laporan
$laporan = array();

// Periksa apakah ada hasil laporan
if ($result_laporan && mysqli_num_rows($result_laporan) > 0) {
    while ($row_laporan = mysqli_fetch_assoc($result_laporan)) {
        $pendaftaran_id = $row_laporan['id_pendaftaran'];
        $laporan_item = array(
            'id_laporan' => $row_laporan['id_laporan'],
            'id_pendaftaran' => $row_laporan['id_pendaftaran'],
            'nama_komunitas' => $row_laporan['nama_komunitas'],
            'namaKegiatan' => $row_laporan['namaKegiatan'],
            'nama_relawan' => $row_laporan['nama_relawan'],
            'komentar' => $row_laporan['komentar'],
            'tanggal' => $row_laporan['tanggal'],
            // ... tambahkan field laporan lainnya sesuai kebutuhan
        );

        // Tambahkan data laporan ke array
        $laporan[$pendaftaran_id][] = $laporan_item;

        // Tambahkan 1 ke jumlah laporan
        $jumlahLaporan++;
    }
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
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
                <a class="nav-link" href="dashboard_relawan.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="laporan_relawan.php">
                    <i class="bi bi-envelope"></i>
                    <span>Buat Laporan</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main" style="background-color:  #EBE5CC;">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">

                        <!-- Left side columns -->
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Profil</h5>
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
                                                <?php echo $namaRelawan; ?>
                                            </p>
                                            <a href="users-profile.php">Lihat Profil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Left side columns -->

                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Kegiatan</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-fill-add"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $jumlahAktivitas; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Yang Diikuti</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Laporan</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-envelope-arrow-up"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $jumlahLaporan; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Laporan Yang Dibuat</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card recent-registrations overflow-auto">
                        <div class="card-body">
                            <h4 class="card-title"> Laporan </h4>
                            <?php
                            // Check if there are laporan
                            if (isset($laporan) && is_array($laporan) && count($laporan) > 0) {
                                echo '<div class="card info-card revenue-card border p-2 mb-2">';
                                echo '<table class="table table-bordered">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col">No</th>';
                                echo '<th scope="col">Nama Komunitas</th>';
                                echo '<th scope="col">Nama Kegiatan</th>';
                                echo '<th scope="col">Komentar</th>';
                                echo '<th scope="col">Aksi</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $nomor = 1;

                                foreach ($laporan as $laporan_i => $laporan_items) {
                                    foreach ($laporan_items as $index => $laporan_item) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . $nomor++ . '</th>';
                                        echo '<td>' . $laporan_item['nama_komunitas'] . '</td>';
                                        echo '<td>' . $laporan_item['namaKegiatan'] . '</td>';
                                        echo '<td>' . $laporan_item['komentar'] . '</td>';
                                        echo '<td>
                            <a href="ubah/delete-laporan.php?id=' . $laporan_item['id_laporan'] . '" class="delete-btn bg-danger">
                                <i class="bi bi-trash3-fill"></i> Hapus
                            </a>
                        </td>';
                                        echo '</tr>';
                                    }
                                }

                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                // Jika belum ada laporan
                                echo '<p>Belum ada Laporan.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>





                <div class="col-lg-12">
                    <div class="card recent-registrations overflow-auto">
                        <div class="card-body">
                            <h4 class="card-title"> Kegiatan Yang Diikuti </h4>

                            <?php
                            // Check if there are registrations for the activities
                            if (isset($pendaftaran) && is_array($pendaftaran) && count($pendaftaran) > 0) {
                                echo '<div class="card info-card revenue-card border p-2 mb-2">';
                                echo '<table class="table table-bordered">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col">No</th>';
                                echo '<th scope="col">Nama Komunitas</th>';
                                echo '<th scope="col">Nama Kegiatan</th>';
                                echo '<th scope="col">Alasan</th>';
                                echo '<th scope="col">Status</th>';
                                echo '<th scope="col">Aksi</th>';
                                echo '<th scope="col">Laporan</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $nomor = 1;

                                foreach ($pendaftaran as $kegiatan_i => $pendaftaran_items) {
                                    foreach ($pendaftaran_items as $index => $pendaftaran_item) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . $nomor++ . '</th>';
                                        echo '<td>' . $pendaftaran_item['namaKomunitas'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['namaKegiatan'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['alasan'] . '</td>';

                                        // Periksa apakah kunci 'id_kegiatan' ada dalam array
                                        if (isset($pendaftaran_item['id_kegiatan'])) {
                                            $id_kegiatan = $pendaftaran_item['id_kegiatan'];
                                            $sql_kegiatan = "SELECT * FROM kegiatan WHERE id_kegiatan = $id_kegiatan";
                                            $result_kegiatan = mysqli_query($koneksi, $sql_kegiatan);

                                            // Periksa apakah query berhasil dan hasilnya lebih dari 0
                                            if ($result_kegiatan && mysqli_num_rows($result_kegiatan) > 0) {
                                                $row_kegiatan = mysqli_fetch_assoc($result_kegiatan);
                                                $tanggalBerakhir = strtotime($row_kegiatan['tanggalBerakhir']);
                                                $tanggalSekarang = strtotime(date('Y-m-d'));

                                                // Tambahkan logika untuk menentukan apakah kegiatan sudah berakhir atau masih berlangsung
                                                if ($tanggalBerakhir >= $tanggalSekarang) {
                                                    // Jika tanggal berakhir masih lebih besar atau sama dengan tanggal sekarang, kegiatan masih berlangsung
                                                    echo '<td class="text-success">Sedang Berlangsung</td>';
                                                } else {
                                                    // Jika tanggal berakhir lebih kecil dari tanggal sekarang, kegiatan sudah berakhir
                                                    echo '<td class="text-danger">Sudah Berakhir</td>';
                                                }
                                            } else {
                                                // Handle kesalahan jika query kegiatan gagal atau tidak ada hasil
                                                echo '<td class="text-warning">Status tidak diketahui</td>';
                                            }
                                        } else {
                                            // Handle jika kunci 'id_kegiatan' tidak ditemukan dalam array
                                            echo '<td class="text-warning">ID Kegiatan tidak valid</td>';
                                        }

                                        echo '<td>
                            <a href="ubah/delete-pendaftaran.php?id=' . $pendaftaran_item['id_pendaftaran'] . '" class="delete-btn bg-danger">
                                <i class="bi bi-x-circle"></i> Keluar
                            </a>
                        </td>';

                                        if (empty($pendaftaran_item['laporan'])) {
                                            // Check apakah ada entri yang sesuai di tabel "laporan"
                                            $sql_check_laporan = "SELECT * FROM laporan WHERE id_pendaftaran = " . $pendaftaran_item['id_pendaftaran'];
                                            $result_check_laporan = mysqli_query($koneksi, $sql_check_laporan);

                                            if ($result_check_laporan && mysqli_num_rows($result_check_laporan) == 0) {
                                                // Jika tidak ada entri laporan, tampilkan tombol "Buat Laporan"
                                                echo '<td><a href="laporan_relawan.php" class="btn btn-primary" data-id-pendaftaran="' . $pendaftaran_item['id_pendaftaran'] . '" data-nama-komunitas="' . $pendaftaran_item['namaKomunitas'] . '" data-nama-kegiatan="' . $pendaftaran_item['namaKegiatan'] . '" onclick="showPopupAndFillForm(this)">Buat Laporan</a></td>';
                                            } else {
                                                // Jika sudah ada entri laporan, tampilkan badge "Selesai"
                                                echo '<td><span class="badge bg-success">Selesai</span></td>';
                                            }
                                        } else {
                                            // Jika sudah ada laporan pada entri pendaftaran, tampilkan badge "Selesai"
                                            echo '<td><span class="badge bg-success">Selesai</span></td>';
                                        }

                                        echo '</tr>';
                                    }
                                }

                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                // Jika belum ada pendaftaran
                                echo '<h3 style="font-weight: bold">Masih kosong nih!!!</h3>';
                                echo '<span class="text-muted small pt-2 ps-1">Ayo</span>';
                                echo '<a href="kegiatan.php" class="btn btn-warning">Cari Kegiatan</a>';
                            }
                            ?>
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