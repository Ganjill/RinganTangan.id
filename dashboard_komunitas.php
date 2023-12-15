<?php
include 'koneksi.php';
session_start();

// Inisialisasi variabel dengan nilai default
$foto = "assets/img/profil.jpg"; // Ganti "default.jpg" dengan nama file gambar default yang sesuai
$namakomunitas = "Nama Komunitas Default"; // Ganti dengan nilai default yang sesuai

// Periksa apakah variabel sesi id_komunitas terdefinisi
if (isset($_SESSION['id_komunitas'])) {
    // Jika ya, ambil nilainya
    $id_komunitas = $_SESSION['id_komunitas'];

    // Ambil data komunitas terhubung
    $queryKomunitas = "SELECT * FROM komunitas WHERE id_komunitas = ?";
    $stmtKomunitas = mysqli_prepare($koneksi, $queryKomunitas);

    // Periksa apakah prepared statement berhasil dibuat
    if ($stmtKomunitas) {
        // Bind parameter ke prepared statement
        mysqli_stmt_bind_param($stmtKomunitas, "i", $id_komunitas);

        // Eksekusi prepared statement
        $resultKomunitas = mysqli_stmt_execute($stmtKomunitas);

        // Periksa apakah eksekusi berhasil
        if ($resultKomunitas) {
            $resultKomunitas = mysqli_stmt_get_result($stmtKomunitas);

            if (mysqli_num_rows($resultKomunitas) > 0) {
                // Ambil data komunitas ke dalam array
                $rowKomunitas = mysqli_fetch_assoc($resultKomunitas);

                $namakomunitas = $rowKomunitas['nama_komunitas'];

                // Check apakah 'foto' tidak kosong
                if (!empty($rowKomunitas['foto'])) {
                    $foto = "files_komunitas/" . $rowKomunitas['foto'];
                }
            } else {
                // Jika tidak ada data komunitas
                echo "Data Komunitas tidak ditemukan.";
            }
        } else {
            // Tampilkan pesan error SQL
            echo "Error: " . mysqli_stmt_error($stmtKomunitas);
        }

        // Tutup statement
        mysqli_stmt_close($stmtKomunitas);
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_error($koneksi);
    }

    // Ambil semua kegiatan untuk komunitas tersebut
    $queryKegiatan = "SELECT * FROM kegiatan WHERE id_komunitas = ? ORDER BY tanggalMulai DESC";
    $stmtKegiatan = mysqli_prepare($koneksi, $queryKegiatan);

    // Periksa apakah prepared statement berhasil dibuat
    if ($stmtKegiatan) {
        // Bind parameter ke prepared statement
        mysqli_stmt_bind_param($stmtKegiatan, "i", $id_komunitas);

        // Eksekusi prepared statement
        $resultKegiatan = mysqli_stmt_execute($stmtKegiatan);

        // Periksa apakah eksekusi berhasil
        if ($resultKegiatan) {
            $resultKegiatan = mysqli_stmt_get_result($stmtKegiatan);

            // Periksa apakah ada data kegiatan
            if (mysqli_num_rows($resultKegiatan) > 0) {
                // Ambil semua data kegiatan ke dalam array
                $kegiatan = mysqli_fetch_all($resultKegiatan, MYSQLI_ASSOC);
            } else {
                // Jika tidak ada kegiatan
                $kegiatan = array();
            }
        } else {
            // Tampilkan pesan error SQL
            echo "Error: " . mysqli_stmt_error($stmtKegiatan);
        }

        // Tutup statement
        mysqli_stmt_close($stmtKegiatan);
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika id_komunitas tidak terdefinisi
    echo "ID Komunitas tidak valid.";
}

// Hitung jumlah aktivitas
$queryAktivitas = "SELECT COUNT(*) AS jumlahAktivitas FROM kegiatan WHERE id_komunitas = ?";
$stmtAktivitas = mysqli_prepare($koneksi, $queryAktivitas);

// Periksa apakah prepared statement berhasil dibuat
if ($stmtAktivitas) {
    // Bind parameter ke prepared statement
    mysqli_stmt_bind_param($stmtAktivitas, "i", $id_komunitas);

    // Eksekusi prepared statement
    $resultAktivitas = mysqli_stmt_execute($stmtAktivitas);

    // Periksa apakah eksekusi berhasil
    if ($resultAktivitas) {
        $resultAktivitas = mysqli_stmt_get_result($stmtAktivitas);

        $dataAktivitas = mysqli_fetch_assoc($resultAktivitas);
        $jumlahAktivitas = $dataAktivitas['jumlahAktivitas'];
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_stmt_error($stmtAktivitas);
    }

    // Tutup statement
    mysqli_stmt_close($stmtAktivitas);
} else {
    // Tampilkan pesan error SQL
    echo "Error: " . mysqli_error($koneksi);
}

// Hitung jumlah kegiatan yang sudah selesai
$querySelesai = "SELECT COUNT(*) AS jumlahSelesai FROM kegiatan WHERE id_komunitas = ? AND tanggalBerakhir < NOW()";
$stmtSelesai = mysqli_prepare($koneksi, $querySelesai);

// Periksa apakah prepared statement berhasil dibuat
if ($stmtSelesai) {
    // Bind parameter ke prepared statement
    mysqli_stmt_bind_param($stmtSelesai, "i", $id_komunitas);

    // Eksekusi prepared statement
    $resultSelesai = mysqli_stmt_execute($stmtSelesai);

    // Periksa apakah eksekusi berhasil
    if ($resultSelesai) {
        $resultSelesai = mysqli_stmt_get_result($stmtSelesai);

        $dataSelesai = mysqli_fetch_assoc($resultSelesai);
        $jumlahSelesai = $dataSelesai['jumlahSelesai'];
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_stmt_error($stmtSelesai);
    }

    // Tutup statement
    mysqli_stmt_close($stmtSelesai);
} else {
    // Tampilkan pesan error SQL
    echo "Error: " . mysqli_error($koneksi);
}
// Misalnya, Anda ingin menghitung jumlah relawan berdasarkan id_komunitas
$sql_count_relawan = "SELECT COUNT(*) AS jumlahRelawan FROM pendaftaran WHERE id_komunitas = $id_komunitas";
$result_count_relawan = mysqli_query($koneksi, $sql_count_relawan);

// Inisialisasi variabel jumlah relawan
$jumlahRelawan = 0;

// Periksa apakah query berhasil dijalankan
if ($result_count_relawan) {
    // Ambil hasil query
    $row_count_relawan = mysqli_fetch_assoc($result_count_relawan);

    // Peroleh jumlah relawan dari hasil query
    $jumlahRelawan = $row_count_relawan['jumlahRelawan'];
}

// Hitung jumlah laporan
$queryLaporan = "SELECT COUNT(*) AS jumlahLaporan FROM laporan 
                 JOIN pendaftaran ON laporan.id_pendaftaran = pendaftaran.id_pendaftaran
                 WHERE pendaftaran.id_komunitas = ?";
$stmtLaporan = mysqli_prepare($koneksi, $queryLaporan);

// Periksa apakah prepared statement berhasil dibuat
if ($stmtLaporan) {
    // Bind parameter ke prepared statement
    mysqli_stmt_bind_param($stmtLaporan, "i", $id_komunitas);

    // Eksekusi prepared statement
    $resultLaporan = mysqli_stmt_execute($stmtLaporan);

    // Periksa apakah eksekusi berhasil
    if ($resultLaporan) {
        $resultLaporan = mysqli_stmt_get_result($stmtLaporan);

        $dataLaporan = mysqli_fetch_assoc($resultLaporan);
        $jumlahLaporan = $dataLaporan['jumlahLaporan'];
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_stmt_error($stmtLaporan);
    }

    // Tutup statement
    mysqli_stmt_close($stmtLaporan);
} else {
    // Tampilkan pesan error SQL
    echo "Error: " . mysqli_error($koneksi);
}

// Hitung jumlah pendaftaran
$queryPendaftaran = "SELECT COUNT(*) AS jumlahPendaftaran FROM pendaftaran WHERE id_komunitas = ?";
$stmtPendaftaran = mysqli_prepare($koneksi, $queryPendaftaran);

// Periksa apakah prepared statement berhasil dibuat
if ($stmtPendaftaran) {
    // Bind parameter ke prepared statement
    mysqli_stmt_bind_param($stmtPendaftaran, "i", $id_komunitas);

    // Eksekusi prepared statement
    $resultPendaftaran = mysqli_stmt_execute($stmtPendaftaran);

    // Periksa apakah eksekusi berhasil
    if ($resultPendaftaran) {
        $resultPendaftaran = mysqli_stmt_get_result($stmtPendaftaran);

        $dataPendaftaran = mysqli_fetch_assoc($resultPendaftaran);
        $jumlahPendaftaran = $dataPendaftaran['jumlahPendaftaran'];
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_stmt_error($stmtPendaftaran);
    }

    // Tutup statement
    mysqli_stmt_close($stmtPendaftaran);
} else {
    // Tampilkan pesan error SQL
    echo "Error: " . mysqli_error($koneksi);
}

// Hitung jumlah kegiatan yang sudah selesai
$querySelesai = "SELECT COUNT(*) AS jumlahSelesai FROM kegiatan WHERE id_komunitas = ? AND tanggalBerakhir < NOW()";
$stmtSelesai = mysqli_prepare($koneksi, $querySelesai);

// Periksa apakah prepared statement berhasil dibuat
if ($stmtSelesai) {
    // Bind parameter ke prepared statement
    mysqli_stmt_bind_param($stmtSelesai, "i", $id_komunitas);

    // Eksekusi prepared statement
    $resultSelesai = mysqli_stmt_execute($stmtSelesai);

    // Periksa apakah eksekusi berhasil
    if ($resultSelesai) {
        $resultSelesai = mysqli_stmt_get_result($stmtSelesai);

        $dataSelesai = mysqli_fetch_assoc($resultSelesai);
        $jumlahSelesai = $dataSelesai['jumlahSelesai'];
    } else {
        // Tampilkan pesan error SQL
        echo "Error: " . mysqli_stmt_error($stmtSelesai);
    }

    // Tutup statement
    mysqli_stmt_close($stmtSelesai);
} else {
    // Tampilkan pesan error SQL
    echo "Error: " . mysqli_error($koneksi);
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

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link" href="dashboard_komunitas.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="buat_kegiatan.php">
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

    <main id="main" class="main" style="background-color:  #EBE5CC;">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard" style="padding: 0;">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Profil Komunitas -->
                        <div class="col-xxl-4 col-md-4">

                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Profil Komunitas</h5>
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
                                                <?php echo $namakomunitas; ?>
                                            </p>
                                            <a href="users-komunitas.php">Lihat Profil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!--Profil Komunitas -->

                        <!-- Sales Card -->
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
                                            <span class="text-muted small pt-2 ps-1">Yang Dibuat</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card revenue-card">

                                <div class="card-body">
                                    <h5 class="card-title">Pendaftaran kegiatan </h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-fill-up"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $jumlahPendaftaran; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Yang Mendaftar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Relawan </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-fill-check"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $jumlahLaporan; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Yang Membuat Laporan</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Kegiatan</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $jumlahSelesai; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Yang Sudah Berakhir</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                    </div>
                </div><!-- End Left side columns -->



                <!-- kegiatan -->
                <?php
                // Gantilah "Nama Komunitas Default" dengan nama komunitas yang ingin Anda tampilkan
                $namaKomunitas = "Nama Komunitas Default";

                // Periksa apakah variabel sesi id_komunitas terdefinisi
                if (isset($_SESSION['id_komunitas'])) {
                    // Jika ya, ambil nilainya
                    $id_komunitas = $_SESSION['id_komunitas'];

                    // Kueri SQL untuk mendapatkan data kegiatan berdasarkan id_komunitas
                    $sql_kegiatan = "SELECT * FROM kegiatan WHERE id_komunitas = $id_komunitas";
                    $result_kegiatan = mysqli_query($koneksi, $sql_kegiatan);

                    // Inisialisasi array untuk menyimpan data kegiatan
                    $kegiatan = array();

                    // Periksa apakah ada hasil kegiatan
                    if (mysqli_num_rows($result_kegiatan) > 0) {
                        while ($row_kegiatan = mysqli_fetch_assoc($result_kegiatan)) {
                            // Gantilah ini dengan kolom-kolom yang sesuai di tabel kegiatan
                            $id_kegiatan = $row_kegiatan['id_kegiatan'];
                            $fotoKomunitas = $row_kegiatan['fotoKomunitas'];
                            $nama_komunitas = $row_kegiatan['nama_komunitas'];
                            $fotoKegiatan = $row_kegiatan['fotoKegiatan'];
                            $namaKegiatan = $row_kegiatan['namaKegiatan'];
                            $jenisKegiatan = $row_kegiatan['jenisKegiatan'];
                            $lokasi = $row_kegiatan['lokasi'];
                            $tanggalMulai = $row_kegiatan['tanggalMulai'];
                            $tanggalBerakhir = $row_kegiatan['tanggalBerakhir'];
                            $batasRegistrasi = $row_kegiatan['batasRegistrasi'];
                            $metodeBriefing = $row_kegiatan['metodeBriefing'];
                            $namaPekerjaan = $row_kegiatan['namaPekerjaan'];
                            $relawanDibutuhkan = $row_kegiatan['relawanDibutuhkan'];
                            $totalJamKerja = $row_kegiatan['totalJamKerja'];
                            $tugasRelawan = $row_kegiatan['tugasRelawan'];
                            $kriteriaRelawan = $row_kegiatan['kriteriaRelawan'];
                            $perlengkapanRelawan = $row_kegiatan['perlengkapanRelawan'];

                            // Tambahkan data kegiatan ke array
                            $kegiatan[$id_kegiatan][] = compact('id_kegiatan', 'fotoKomunitas', 'nama_komunitas', 'fotoKegiatan', 'namaKegiatan', 'jenisKegiatan', 'lokasi', 'tanggalMulai', 'tanggalBerakhir', 'batasRegistrasi', 'metodeBriefing', 'namaPekerjaan', 'relawanDibutuhkan', 'totalJamKerja', 'tugasRelawan', 'kriteriaRelawan', 'perlengkapanRelawan');
                        }
                    }
                } else {
                    // Jika id_komunitas tidak terdefinisi
                    echo "ID Komunitas tidak valid.";
                } // Cek apakah formulir edit kegiatan dikirim

                ?>

                <div class="col-12">
                    <div class="card recent-registrations overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Kegiatan</h5>
                            <?php
                            // Output HTML menggunakan data yang sudah diolah
                            if (isset($kegiatan) && !empty($kegiatan)) {
                                echo '<div class=" card info-card revenue-card border  p-2 mb-2 ">';
                                echo '<table class="table table-bordered ">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col">No</th>';
                                echo '<th scope="col">Nama Kegiatan</th>';
                                echo '<th scope="col">Jenis Kegiatan</th>';
                                echo '<th scope="col">Batas Registrasi</th>';
                                echo '<th scope="col">Status</th>';
                                echo '<th scope="col">Aksi</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $nomor = 1;

                                foreach ($kegiatan as $id_komunitas => $kegiatan_items) {
                                    foreach ($kegiatan_items as $index => $kegiatan_item) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . $nomor++ . '</th>';
                                        echo '<td>' . $kegiatan_item['namaKegiatan'] . '</td>';
                                        echo '<td>' . $kegiatan_item['jenisKegiatan'] . '</td>';
                                        echo '<td>' . $kegiatan_item['batasRegistrasi'] . '</td>';
                                        // Tambahkan logika untuk menentukan apakah kegiatan sudah berakhir atau masih berlangsung
                                        $tanggalBerakhir = strtotime($kegiatan_item['tanggalBerakhir']);
                                        $tanggalSekarang = strtotime(date('Y-m-d'));

                                        if ($tanggalBerakhir >= $tanggalSekarang) {
                                            // Jika tanggal berakhir masih lebih besar atau sama dengan tanggal sekarang, kegiatan masih berlangsung
                                            echo '<td class="text-success">Sedang Berlangsung</td>';
                                        } else {
                                            // Jika tanggal berakhir lebih kecil dari tanggal sekarang, kegiatan sudah berakhir
                                            echo '<td class="text-danger">Sudah Berakhir</td>';
                                        }
                                        echo '<td>
              <a href="#" class="edit-btn bg-success edit-kegiatan-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id-kegiatan="' . $kegiatan_item['id_kegiatan'] . '"
    
              data-nama-kegiatan="' . $kegiatan_item['namaKegiatan'] . '"
    data-jenis-kegiatan="' . $kegiatan_item['jenisKegiatan'] . '"
    data-lokasi="' . $kegiatan_item['lokasi'] . '"
    data-tanggal-mulai="' . $kegiatan_item['tanggalMulai'] . '"
    data-tanggal-berakhir="' . $kegiatan_item['tanggalBerakhir'] . '"
    data-batas-registrasi="' . $kegiatan_item['batasRegistrasi'] . '"
    data-metode-briefing="' . $kegiatan_item['metodeBriefing'] . '"
data-nama-pekerjaan="' . $kegiatan_item['namaPekerjaan'] . '"
data-relawan-dibutuhkan="' . $kegiatan_item['relawanDibutuhkan'] . '"
data-total-jam-kerja="' . $kegiatan_item['totalJamKerja'] . '"
data-tugas-relawan="' . $kegiatan_item['tugasRelawan'] . '"
data-kriteria-relawan="' . $kegiatan_item['kriteriaRelawan'] . '"
data-perlengkapan-relawan="' . $kegiatan_item['perlengkapanRelawan'] . '"
 onclick="setEditModalValues(' . $kegiatan_item['id_kegiatan'] . ')">
    <i class="bi bi-pencil-square"></i> Edit
</a>
                |
<a href="ubah/delete-kegiatan.php?id=' . $kegiatan_item['id_kegiatan'] . '" class="delete-btn bg-danger">
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
                                echo '<h3 style= "font-weight: bold">Masih kosong nih!!!</h3>';
                                echo '<span class="text-muted small pt-2 ps-1">Ayo</span>';
                                echo '<a href="buat_kegiatan.php" class="btn btn-warning">Buat Kegiatan</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Kegiatan -->
                <div class="modal fade" id="editModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-scrollable" style="color: black; font-weight: bold;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kegiatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Isi form edit kegiatan sesuai kebutuhan -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_kegiatan" id="inputIdKegiatan" value="">
                                    <div class="form-group" style="width: 100%;">
                                        <label for="fotoKegiatan">Foto Kegiatan</label>
                                        <input type="file" class="form-control" id="fotoKegiatan" name="fotoKegiatan" accept="image/*">
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="namaKegiatan">Nama Kegiatan</label>
                                        <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="jenisKegiatan">Jenis Kegiatan</label>
                                        <input type="text" class="form-control" id="jenisKegiatan" name="jenisKegiatan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="lokasi">Lokasi</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="tanggalMulai">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="tanggalBerakhir">Tanggal Berakhir</label>
                                        <input type="date" class="form-control" id="tanggalBerakhir" name="tanggalBerakhir" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="batasRegistrasi">Batas Registrasi</label>
                                        <input type="date" class="form-control" id="batasRegistrasi" name="batasRegistrasi" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="metodeBriefing">Metode Briefing</label>
                                        <input type="text" class="form-control" id="metodeBriefing" name="metodeBriefing" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="namaPekerjaan">Nama Pekerjaan</label>
                                        <input type="text" class="form-control" id="namaPekerjaan" name="namaPekerjaan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="relawanDibutuhkan">Relawan Dibutuhkan</label>
                                        <input type="text" class="form-control" id="relawanDibutuhkan" name="relawanDibutuhkan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="totalJamKerja">Total Jam Kerja</label>
                                        <input type="text" class="form-control" id="totalJamKerja" name="totalJamKerja" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="tugasRelawan">Tugas Relawan</label>
                                        <input type="text" class="form-control" id="tugasRelawan" name="tugasRelawan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="kriteriaRelawan">Kriteria Relawan</label>
                                        <input type="text" class="form-control" id="kriteriaRelawan" name="kriteriaRelawan" required>
                                    </div>
                                    <div class="form-group" style="width: 100%;">
                                        <label for="perlengkapanRelawan">Perlengkapan Relawan</label>
                                        <input type="text" class="form-control" id="perlengkapanRelawan" name="perlengkapanRelawan" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="update">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                if (isset($_POST['update'])) {
                    // Ambil data dari formulir
                    $id_kegiatan = $_POST['id_kegiatan'];

                    // Pastikan $id_kegiatan tidak kosong
                    if (!empty($id_kegiatan)) {
                        // Ambil nilai-nilai lainnya
                        $namaKegiatan = $_POST['namaKegiatan'];
                        $jenisKegiatan = $_POST['jenisKegiatan'];
                        $lokasi = $_POST['lokasi'];
                        $tanggalMulai = $_POST['tanggalMulai'];
                        $tanggalBerakhir = $_POST['tanggalBerakhir'];
                        $batasRegistrasi = $_POST['batasRegistrasi'];
                        $metodeBriefing = $_POST['metodeBriefing'];
                        $namaPekerjaan = $_POST['namaPekerjaan'];
                        $relawanDibutuhkan = $_POST['relawanDibutuhkan'];
                        $totalJamKerja = $_POST['totalJamKerja'];
                        $tugasRelawan = $_POST['tugasRelawan'];
                        $kriteriaRelawan = $_POST['kriteriaRelawan'];
                        $perlengkapanRelawan = $_POST['perlengkapanRelawan'];


                        // Inisialisasi $queryUpdate
                        $queryUpdate = "UPDATE kegiatan SET
    namaKegiatan = '$namaKegiatan',
    jenisKegiatan = '$jenisKegiatan',
    lokasi = '$lokasi',
    tanggalMulai = '$tanggalMulai',
    tanggalBerakhir = '$tanggalBerakhir',
    batasRegistrasi = '$batasRegistrasi',
    metodeBriefing = '$metodeBriefing',
    namaPekerjaan = '$namaPekerjaan',
    relawanDibutuhkan = '$relawanDibutuhkan',
    totalJamKerja = '$totalJamKerja',
    tugasRelawan = '$tugasRelawan',
    kriteriaRelawan = '$kriteriaRelawan',
    perlengkapanRelawan = '$perlengkapanRelawan'";

                        // Periksa apakah foto baru diunggah
                        if (!empty($_FILES['fotoKegiatan']['name'])) {
                            // Tangani unggahan foto
                            $uploadDir = '../files_kegiatan'; // Ganti ini dengan direktori unggahan yang sesungguhnya
                            $uploadFile = $uploadDir . basename($_FILES['fotoKegiatan']['name']);

                            if (move_uploaded_file($_FILES['fotoKegiatan']['tmp_name'], $uploadFile)) {
                                // Perbarui database dengan nama file foto baru
                                $photoFilename = basename($_FILES['fotoKegiatan']['name']);
                                $queryUpdate .= ", fotoKegiatan = '$photoFilename'";
                            } else {
                                // Tampilkan pesan kesalahan jika gagal mengunggah foto
                                echo '<script>alert("Terjadi kesalahan saat mengunggah foto.");</script>';
                            }
                        }

                        // Lengkapi kueri
                        $queryUpdate .= " WHERE id_kegiatan = $id_kegiatan";

                        // Eksekusi query update
                        $resultUpdate = mysqli_query($koneksi, $queryUpdate);

                        // Periksa apakah update berhasil
                        if ($resultUpdate) {
                            echo '<script>alert("Perubahan berhasil disimpan!");</script>';
                        } else {
                            // Tampilkan pesan kesalahan SQL untuk debugging
                            echo '<script>alert("Error: ' . mysqli_error($koneksi) . '");</script>';
                            echo '<script>alert("Terjadi kesalahan, perubahan gagal disimpan.");</script>';
                        }
                    } else {
                        // Jika $id_kegiatan kosong, tampilkan pesan kesalahan
                        echo '<div class="alert alert-danger" role="alert">
            ID Kegiatan tidak valid.
        </div>';
                    }
                }

                // Ambil id_kegiatan dari data yang dikirim oleh tombol edit
                if (isset($_POST['edit'])) {
                    $id_kegiatan_edit = $_POST['edit'];
                    // Debugging: Tampilkan nilai id_kegiatan_edit untuk memastikan semuanya benar
                    echo 'Nilai $id_kegiatan_edit: ' . $id_kegiatan_edit . '<br>';
                    // Lakukan kueri untuk mendapatkan data kegiatan berdasarkan id_kegiatan
                    $queryEdit = "SELECT * FROM kegiatan WHERE id_kegiatan = $id_kegiatan_edit";
                    $resultEdit = mysqli_query($koneksi, $queryEdit);

                    // Periksa apakah query berhasil
                    if ($resultEdit) {
                        $kegiatan_item = mysqli_fetch_assoc($resultEdit);
                    } else {
                        // Tampilkan pesan kesalahan jika query tidak berhasil
                        echo '<div class="alert alert-danger" role="alert">
            Terjadi kesalahan, data kegiatan tidak dapat diambil.
        </div>';
                    }
                }
                ?>




                <!-- Pendaftaran -->
                <?php
                // Gantilah "Nama Komunitas Default" dengan nama komunitas yang ingin Anda tampilkan
                $namaKomunitas = "Nama Komunitas Default";

                // Periksa apakah variabel sesi id_komunitas terdefinisi
                if (isset($_SESSION['id_komunitas'])) {
                    // Jika ya, ambil nilainya
                    $id_komunitas = $_SESSION['id_komunitas'];

                    // Kueri SQL untuk mendapatkan data pendaftaran relawan berdasarkan id_komunitas
                    $sql_pendaftaran = "SELECT * FROM pendaftaran WHERE id_komunitas = $id_komunitas";
                    $result_pendaftaran = mysqli_query($koneksi, $sql_pendaftaran);

                    // Inisialisasi array untuk menyimpan data pendaftaran
                    $pendaftaran = array();

                    // Periksa apakah ada hasil pendaftaran
                    if (mysqli_num_rows($result_pendaftaran) > 0) {
                        while ($row_pendaftaran = mysqli_fetch_assoc($result_pendaftaran)) {
                            // Gantilah ini dengan kolom-kolom yang sesuai di tabel pendaftaran
                            $id_pendaftaran = $row_pendaftaran['id_pendaftaran'];
                            $id_kegiatan = $row_pendaftaran['id_kegiatan'];
                            $namaKomunitas = $row_pendaftaran['namaKomunitas'];
                            $namaKegiatan = $row_pendaftaran['namaKegiatan'];
                            $nama_relawan = $row_pendaftaran['nama_relawan'];
                            $email = $row_pendaftaran['email'];
                            $alasan = $row_pendaftaran['alasan'];

                            // Tambahkan data pendaftaran ke array
                            $pendaftaran[$id_kegiatan][] = compact('id_pendaftaran', 'namaKomunitas', 'namaKegiatan', 'nama_relawan', 'email', 'alasan');
                        }
                    }
                } else {
                    // Jika id_komunitas tidak terdefinisi
                    echo "ID Komunitas tidak valid.";
                }
                ?>
                <div class="col-12">
                    <div class="card recent-registrations overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Pendaftaran Relawan</h5>
                            <?php
                            // Output HTML menggunakan data yang sudah diolah
                            if (isset($pendaftaran) && !empty($pendaftaran)) {
                                foreach ($pendaftaran as $id_kegiatan => $pendaftaran_items) {
                                    echo ' <div class=" card info-card revenue-card border  p-2 mb-2 ">';
                                    echo '<table class="table table-bordered">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col">No</th>';
                                    echo '<th scope="col">Nama Kegiatan</th>';
                                    echo '<th scope="col">Nama Relawan</th>';
                                    echo '<th scope="col">Email</th>';
                                    echo '<th scope="col">Alasan</th>';
                                    echo '<th scope="col">Aksi</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    foreach ($pendaftaran_items as $index => $pendaftaran_item) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . ($index + 1) . '</th>';
                                        echo '<td>' . $pendaftaran_item['namaKegiatan'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['nama_relawan'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['email'] . '</td>';
                                        echo '<td>' . $pendaftaran_item['alasan'] . '</td>';
                                        echo '<td>
                                                    <a href="ubah/delete-pendaftaran-komunitas.php?id=' . $pendaftaran_item['id_pendaftaran'] . '" class="delete-btn bg-danger">
                                        <i class="bi bi-x-circle"></i> Tolak
                                        </a>
                                                    </td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Belum ada pendaftaran relawan untuk kegiatan.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->
    <script>
        function setEditModalValues(idKegiatan) {
            // Set nilai input tersembunyi dengan id_kegiatan yang sesuai
            document.getElementById('inputIdKegiatan').value = idKegiatan;
        }
    </script>
    <script>
        $(document).ready(function() {
            // Tangkap event klik pada tombol edit
            $('.edit-kegiatan-btn').click(function() {
                var idKegiatan = $(this).data('id-kegiatan');
                var namaKegiatan = $(this).data('nama-kegiatan');
                var jenisKegiatan = $(this).data('jenis-kegiatan');
                var lokasi = $(this).data('lokasi');
                var tanggalMulai = $(this).data('tanggal-mulai');
                var tanggalBerakhir = $(this).data('tanggal-berakhir');
                var batasRegistrasi = $(this).data('batas-registrasi');
                var metodeBriefing = $(this).data('metode-briefing');
                var namaPekerjaan = $(this).data('nama-pekerjaan');
                var relawanDibutuhkan = $(this).data('relawan-dibutuhkan');
                var totalJamKerja = $(this).data('total-jam-kerja');
                var tugasRelawan = $(this).data('tugas-relawan');
                var kriteriaRelawan = $(this).data('kriteria-relawan');
                var perlengkapanRelawan = $(this).data('perlengkapan-relawan');

                // Isi formulir edit dengan data kegiatan yang dipilih
                $('#id_kegiatan').val(idKegiatan);
                $('#namaKegiatan').val(namaKegiatan);
                $('#jenisKegiatan').val(jenisKegiatan);
                $('#lokasi').val(lokasi);
                $('#tanggalMulai').val(tanggalMulai);
                $('#tanggalBerakhir').val(tanggalBerakhir);
                $('#batasRegistrasi').val(batasRegistrasi);
                $('#metodeBriefing').val(metodeBriefing);
                $('#namaPekerjaan').val(namaPekerjaan);
                $('#relawanDibutuhkan').val(relawanDibutuhkan);
                $('#totalJamKerja').val(totalJamKerja);
                $('#tugasRelawan').val(tugasRelawan);
                $('#kriteriaRelawan').val(kriteriaRelawan);
                $('#perlengkapanRelawan').val(perlengkapanRelawan);

                // Tampilkan pop-up
                $('#editModal').modal('show');
            });
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