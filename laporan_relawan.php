<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION['id_relawan'])) {
    $id_relawan = $_SESSION['id_relawan'];

    $sql_relawan = "SELECT * FROM relawan WHERE id_relawan = $id_relawan ORDER BY id_relawan DESC";
    $result_relawan = mysqli_query($koneksi, $sql_relawan);

    $foto = "assets/img/profil.jpg";

    if ($result_relawan && mysqli_num_rows($result_relawan) > 0) {
        $row_relawan = mysqli_fetch_assoc($result_relawan);
        $namaRelawan = $row_relawan['nama'];

        if (!empty($row_relawan['foto'])) {
            $foto = "files_relawan/" . $row_relawan['foto'];
        }
    } else {
        $namaRelawan = "Belum ada relawan";
    }
} else {
    echo "ID Relawan tidak valid.";
}

$jumlahAktivitas = 0;
$namaKegiatan = '';

$sql_pendaftaran = "SELECT * FROM pendaftaran WHERE nama_relawan = '" . $namaRelawan . "'";
$result_pendaftaran = mysqli_query($koneksi, $sql_pendaftaran);

$pendaftaran = array();

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

        $nama_komunitas = $row_pendaftaran['namaKomunitas'];
        $nama_kegiatan = $row_pendaftaran['namaKegiatan'];
        $nama_relawan = $row_pendaftaran['nama_relawan'];

        $pendaftaran[$kegiatan_id][] = $pendaftaran_item;
        $jumlahAktivitas++;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPopupAndFillForm(element) {
            console.log('Fungsi showPopupAndFillForm dijalankan.');

            // Mendapatkan data dari atribut data pada tombol "Buat Laporan"
            var idPendaftaran = element.getAttribute('data-id-pendaftaran');
            var namaKomunitas = element.getAttribute('data-nama-komunitas');
            var namaKegiatan = element.getAttribute('data-nama-kegiatan');
            var idKegiatan = element.getAttribute('data-id-kegiatan');

            console.log('Data atribut:');
            console.log('idPendaftaran:', idPendaftaran);
            console.log('namaKomunitas:', namaKomunitas);
            console.log('namaKegiatan:', namaKegiatan);
            console.log('idKegiatan:', idKegiatan);

            // Fill form fields with data
            document.getElementById('id_pendaftaran').value = idPendaftaran;
            document.getElementById('namaKomunitas').value = namaKomunitas;
            document.getElementById('namaKegiatan').value = namaKegiatan;
            document.getElementById('id_kegiatan').value = idKegiatan;



            // Show the popup
            showPopup();
        }
    </script>
    <style>
        .form-group label {
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>
    <?php include('form/navbar.php'); ?>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="dashboard_relawan.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link" href="laporan_relawan.php">
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

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Buat Laporan</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-12">
                    <div class="card recent-registrations overflow-auto">
                        <div class="card-body">
                            <h4 style="font-weight: bold; margin-top: 10px;">Laporan Kegiatan</h4>
                            <?php
                            // Check if there are registrations for the activities
                            if (isset($pendaftaran) && is_array($pendaftaran) && count($pendaftaran) > 0) {
                                echo '<div class="card info-card revenue-card border border-success p-2 mb-2 table-bordered border-success">';
                                echo '<table class="table table-borderless">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col">No</th>';
                                echo '<th scope="col">Nama Komunitas</th>';
                                echo '<th scope="col">Nama Kegiatan</th>';
                                echo '<th scope="col">Alasan</th>';
                                echo '<th scope="col">Laporan</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $counter = 0;
                                foreach ($pendaftaran as $kegiatan_i => $pendaftaran_items) {
                                    foreach ($pendaftaran_items as $index => $pendaftaran_item) {
                                        $counter++;
                                        echo '<tr>';
                                        echo '<th scope="row">' . $counter . '</th>';
                                        echo '<td>' . $pendaftaran_item['namaKomunitas'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['namaKegiatan'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['alasan'] . '</td>';
                                        // Tambahkan logika untuk menampilkan tombol "Buat Laporan" jika belum ada laporan
                                        if (empty($pendaftaran_item['laporan'])) {
                                            // Check apakah ada entri yang sesuai di tabel "laporan"
                                            $sql_check_laporan = "SELECT * FROM laporan WHERE id_pendaftaran = " . $pendaftaran_item['id_pendaftaran'];
                                            $result_check_laporan = mysqli_query($koneksi, $sql_check_laporan);

                                            if ($result_check_laporan && mysqli_num_rows($result_check_laporan) == 0) {
                                                // Jika tidak ada entri laporan, tampilkan tombol "Buat Laporan"
                                                echo '<td><a href="#" class="btn btn-primary" data-id-pendaftaran="' . $pendaftaran_item['id_pendaftaran'] . '" data-id-kegiatan="' . $pendaftaran_item['id_kegiatan'] . '" data-nama-komunitas="' . $pendaftaran_item['namaKomunitas'] . '"  data-nama-kegiatan=" ' . $pendaftaran_item['namaKegiatan'] . ' " onclick="showPopupAndFillForm(this)">Buat Laporan</a></td>';
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


        </section>


    </main><!-- End #main -->


    <!-- pop up -->
    <div id="popup" class="popup-container" style="display: <?php echo $displayPopup; ?>">
        <div class="form my-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="form-container">
                            <span class="close" onclick="closePopup()">&times;</span>
                            <h3 style="color: #000;font-size: 25px;font-weight: 600;text-transform: capitalize;margin: 0 0 25px;text-align: center; padding-bottom: 10px; border-bottom: 3px solid #00A9EF;">
                                Laporan Kegiatan </h3>
                            <form class="form-horizontal" method="post" id="laporanForm">
                                <input type="hidden" name="id_pendaftaran" id="id_pendaftaran" value="">
                                <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="">

                                <input type="hidden" name="idKomunitas" value="<?php echo $pendaftaran_item['nama_relawan'] ?>">

                                <div class="form-group" style="width: 100%;">
                                    <label>Komentar</label>
                                    <textarea rows="" class="form-control" name="alasan" placeholder="Tuliskan Laporan Anda" rows="3" required></textarea>
                                </div>
                                <div class="form-group" style="width: 100%;">
                                    <label>Nama Komunitas</label>
                                    <input type="text" class="form-control" name="namaKomunitas" id="namaKomunitas" value="<?php echo $pendaftaran_item['namaKomunitas'] ?>" readonly>
                                </div>

                                <div class="form-group" style="width: 100%;">
                                    <label>Nama Kegiatan</label>
                                    <input type="text" class="form-control" name="namaKegiatan" id="namaKegiatan" value="<?php echo $pendaftaran_item['namaKegiatan'] ?>" readonly>
                                </div>

                                <div class="form-group" style="width: 100%;">
                                    <label>Tanggal Hari ini</label>
                                    <input type="text" class="form-control" name="tanggalHariIni" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn signup" style="width: max-content;" name="submit_form">Kirim
                                        Laporan</button>
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
                    <h5 class="modal-title" id="successModalLabel">Laporan Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="successMessage">Terima kasih telah Membuat Laporan! Laporan Anda untuk kegiatan ini berhasil.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    </main><!-- End #main -->

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit_form'])) {
            // Ambil ID Pendaftaran dari formulir
            $id_pendaftaran = isset($_POST['id_pendaftaran']) ? mysqli_real_escape_string($koneksi, $_POST['id_pendaftaran']) : null;

            // Cek apakah $id_pendaftaran sudah terdefinisi dan tidak kosong
            if (!empty($id_pendaftaran)) {
                // Ambil komentar dari formulir
                $komentar = isset($_POST['alasan']) ? mysqli_real_escape_string($koneksi, $_POST['alasan']) : null;

                // Dapatkan data pendaftaran untuk mendapatkan nilai yang diperlukan
                $sql_pendaftaran_detail = "SELECT * FROM pendaftaran WHERE id_pendaftaran = ?";
                $stmt_pendaftaran_detail = mysqli_prepare($koneksi, $sql_pendaftaran_detail);

                // Bind parameter
                mysqli_stmt_bind_param($stmt_pendaftaran_detail, "i", $id_pendaftaran);

                // Eksekusi statement
                mysqli_stmt_execute($stmt_pendaftaran_detail);

                // Ambil hasil query
                $result_pendaftaran_detail = mysqli_stmt_get_result($stmt_pendaftaran_detail);

                // Fetch data
                if ($row_pendaftaran_detail = mysqli_fetch_assoc($result_pendaftaran_detail)) {
                    // Ambil nilai yang sesuai untuk laporan
                    $nama_komunitas = $row_pendaftaran_detail['namaKomunitas'];
                    $nama_kegiatan = $row_pendaftaran_detail['namaKegiatan'];
                    $nama_relawan = $row_pendaftaran_detail['nama_relawan'];
                    $id_kegiatan = $row_pendaftaran_detail['id_kegiatan'];

                    // Eksekusi query untuk memasukkan data laporan ke dalam database
                    $sqlInsertLaporan = "INSERT INTO laporan (id_relawan, id_pendaftaran, id_kegiatan, nama_komunitas, namaKegiatan, nama_relawan, komentar, tanggal) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

                    $stmt_insert_laporan = mysqli_prepare($koneksi, $sqlInsertLaporan);

                    // Bind parameter
                    mysqli_stmt_bind_param($stmt_insert_laporan, "iiissss", $id_relawan, $id_pendaftaran, $id_kegiatan, $nama_komunitas, $nama_kegiatan, $nama_relawan, $komentar);

                    // Eksekusi statement
                    if (mysqli_stmt_execute($stmt_insert_laporan)) {
                        // Jika berhasil, tampilkan modal keberhasilan
                        echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            showSuccessModal();
                            // Ganti teks pesan keberhasilan di dalam modal laporan
                            document.getElementById("successMessage").innerHTML = "Laporan berhasil dibuat!";
                        });
                    </script>';
                    } else {
                        // Tangani kesalahan saat menyimpan data laporan
                        echo "Error: " . mysqli_stmt_error($stmt_insert_laporan);
                    }
                }
            } else {
                // Tampilkan pesan jika $id_pendaftaran tidak valid
                echo "ID Pendaftaran tidak valid.";
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