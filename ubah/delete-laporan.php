<?php
// Sertakan file koneksi database
include '../koneksi.php';

// Pastikan bahwa id_laporan dikirim melalui parameter GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Ambil id_laporan dari parameter GET
    $id_laporan = $_GET['id'];

    // Hapus data di tabel laporan
    $queryDeleteLaporan = "DELETE FROM laporan WHERE id_laporan = ?";
    $stmtDeleteLaporan = mysqli_prepare($koneksi, $queryDeleteLaporan);
    mysqli_stmt_bind_param($stmtDeleteLaporan, "i", $id_laporan);
    $resultDeleteLaporan = mysqli_stmt_execute($stmtDeleteLaporan);

    // Cek apakah penghapusan berhasil
    if ($resultDeleteLaporan) {
        echo '<script>alert("Laporan berhasil dihapus.");</script>';
    } else {
        echo '<script>alert("Kegiatan tidak berhasil dihapus.");</script>';
    }

    // Tutup prepared statement
    mysqli_stmt_close($stmtDeleteLaporan);

    // Redirect kembali ke halaman dashboard atau halaman lain yang diinginkan
    echo '<script>window.location.href = "../dashboard_relawan.php";</script>';
} else {
    echo '<div class="alert alert-danger" role="alert">
        ID Kegiatan tidak valid.
    </div>';
}
