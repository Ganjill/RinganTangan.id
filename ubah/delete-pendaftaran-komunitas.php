<?php
// Sertakan file koneksi database
include '../koneksi.php';

// Pastikan bahwa id_pendaftaran dikirim melalui parameter GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Ambil id_pendaftaran dari parameter GET
    $id_pendaftaran = $_GET['id'];

    // Cek apakah ada data terkait di tabel laporan
    $queryCheckLaporan = "SELECT * FROM laporan WHERE id_pendaftaran = ?";
    $stmtCheckLaporan = mysqli_prepare($koneksi, $queryCheckLaporan);
    mysqli_stmt_bind_param($stmtCheckLaporan, "i", $id_pendaftaran);
    mysqli_stmt_execute($stmtCheckLaporan);
    $resultCheckLaporan = mysqli_stmt_get_result($stmtCheckLaporan);

    // Jika ada data terkait di tabel laporan
    if (mysqli_num_rows($resultCheckLaporan) > 0) {
        echo '<script>alert("Maaf, tidak dapat menghapus karena terdapat data terkait di tabel laporan.");</script>';
    } else {
        // Hapus data terkait di tabel laporan
        $queryDeleteLaporan = "DELETE FROM laporan WHERE id_pendaftaran = ?";
        $stmtDeleteLaporan = mysqli_prepare($koneksi, $queryDeleteLaporan);
        mysqli_stmt_bind_param($stmtDeleteLaporan, "i", $id_pendaftaran);
        mysqli_stmt_execute($stmtDeleteLaporan);

        // Hapus data di tabel pendaftaran
        $queryDeletePendaftaran = "DELETE FROM pendaftaran WHERE id_pendaftaran = ?";
        $stmtDeletePendaftaran = mysqli_prepare($koneksi, $queryDeletePendaftaran);
        mysqli_stmt_bind_param($stmtDeletePendaftaran, "i", $id_pendaftaran);
        $resultDeletePendaftaran = mysqli_stmt_execute($stmtDeletePendaftaran);

        // Cek apakah penghapusan berhasil
        if ($resultDeletePendaftaran) {
            echo '<script>alert("Pendaftaran kegiatan berhasil dibatalkan.");</script>';
        } else {
            echo '<script>alert("Pendaftaran kegiatan tidak berhasil dibatalkan.");</script>';
        }

        // Tutup prepared statement
        mysqli_stmt_close($stmtDeleteLaporan);
        mysqli_stmt_close($stmtDeletePendaftaran);
    }

    // Tutup prepared statement
    mysqli_stmt_close($stmtCheckLaporan);

    // Redirect kembali ke halaman dashboard
    echo '<script>window.location.href = "../dashboard_komunitas.php";</script>';
} else {
    echo '<div class="alert alert-danger" role="alert">
        ID Pendaftaran tidak valid.
    </div>';
}
?>