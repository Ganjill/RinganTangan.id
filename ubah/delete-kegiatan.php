<?php
// Sertakan file koneksi database
include '../koneksi.php';

// Pastikan bahwa id_kegiatan dikirim melalui parameter GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Ambil id_kegiatan dari parameter GET
    $id_kegiatan = $_GET['id'];

    // Lakukan kueri untuk menghapus kegiatan berdasarkan id_kegiatan
    $queryDelete = "DELETE FROM kegiatan WHERE id_kegiatan = $id_kegiatan";

    // Eksekusi query delete
    $resultDelete = mysqli_query($koneksi, $queryDelete);

    // Cek apakah penghapusan berhasil
    if ($resultDelete) {
        echo '<script>alert("Penghapusan kegiatan berhasil.");</script>';
    } else {
        echo '<script>alert("Penghapusan kegiatan dibatalkan.");</script>';
    }

    // Redirect kembali ke halaman dashboard
    echo '<script>window.location.href = "../dashboard_komunitas.php";</script>';
} else {
    echo '<div class="alert alert-danger" role="alert">
        ID Kegiatan tidak valid.
    </div>';
}
?>