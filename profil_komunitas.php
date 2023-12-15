<?php
include 'koneksi.php';
session_start();

// Ambil ID Komunitas dari URL
$idKomunitas = isset($_GET['id']) ? $_GET['id'] : null;

if ($idKomunitas) {
    // Query untuk mendapatkan detail komunitas menggunakan ID
    $sqlKomunitas = "SELECT * FROM komunitas WHERE id_komunitas = $idKomunitas";
    $resultKomunitas = mysqli_query($koneksi, $sqlKomunitas);

    if ($resultKomunitas && mysqli_num_rows($resultKomunitas) > 0) {
        // Ambil detail komunitas
        $rowKomunitas = mysqli_fetch_assoc($resultKomunitas);
        $foto = $rowKomunitas['foto'];
        // Sekarang Anda dapat menggunakan $rowKomunitas untuk menampilkan detailnya di halaman Anda
        // ...
    } else {
        echo "Komunitas tidak ditemukan.";
    }
} else {
    echo "ID Komunitas tidak valid.";
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
</head>

<body>
    <?php include('form/navbar_dashboard.php'); ?>

    <main id="main">
        <!-- ======= Blog Details Section ======= -->
        <section id="blog" class="blog">
            <div class="section-header" style="margin-bottom: 0; padding-bottom: 10px;">
                <h2>Profil Komunitas</h2>
            </div>
            <div class="container-fluid" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <article class="blog-details">
                            <div class="post-author d-flex align-items-center">
                                <img src="./files_komunitas/<?php echo $foto; ?>" class="rounded-circle flex-shrink-0"
                                    alt="Profil Komunitas" style="border-radius: 50%;">
                                <div>
                                    <h4>
                                        <?php echo $rowKomunitas['nama_komunitas']; ?>
                                    </h4>
                                    <p style="margin-top: 10px;">
                                        <?php echo $rowKomunitas['deskripsi']; ?>
                                    </p>
                                </div>
                            </div><!-- End post author -->

                            <!-- Profil Komunitas -->
                            <div class="row komunitas" style="margin-top: 40px;">
                                <div class="d-flex col-md-4">
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-person-badge" style="font-size:40px;"></i>
                                        <div style="margin-left: 10px;">
                                            <h6 style="margin: 0; padding: 0;">Ketua</h6>
                                            <p style="margin: 0;">
                                                <?php echo $rowKomunitas['ketua']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-md-4">
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-calendar" style="font-size:40px;"></i>
                                        <div style="margin-left: 10px;">
                                            <h6 style="margin: 0; padding: 0;">Tanggal Berdiri</h6>
                                            <p style="margin: 0;">
                                                <?php echo $rowKomunitas['tgl_berdiri']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-md-4">
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-envelope-fill" style="font-size:40px;"></i>
                                        <div style="margin-left: 10px;">
                                            <h6 style="margin: 0; padding: 0;">Email Komunitas</h6>
                                            <p style="margin: 0;">
                                                <?php echo $rowKomunitas['email']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-md-4">
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-geo-alt-fill" style="font-size:40px;"></i>
                                        <div style="margin-left: 10px;">
                                            <h6 style="margin: 0; padding: 0;">Lokasi</h6>
                                            <p style="margin: 0;">
                                                <?php echo $rowKomunitas['lokasi']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article><!-- End blog post -->
                    </div>

                    <div class="col-lg-4">

                        <div class="sidebar">

                            <!-- Kegiatan Terkait Komunitas -->
                            <div class="sidebar-item recent-posts">
                                <h3 class="sidebar-title">Kegiatan</h3>
                                <hr>
                                <?php
                                // Ambil data kegiatan terkait komunitas dari database (gantilah dengan logika pengambilan data yang sesuai)
                                $sqlKegiatan = "SELECT * FROM kegiatan WHERE id_komunitas = $idKomunitas ORDER BY tanggalMulai DESC LIMIT 5";
                                $resultKegiatan = mysqli_query($koneksi, $sqlKegiatan);
                                if ($resultKegiatan && mysqli_num_rows($resultKegiatan) > 0) {
                                    while ($rowKegiatan = mysqli_fetch_assoc($resultKegiatan)) {
                                        ?>
                                        <article class="my-2">
                                            <a href="profil_kegiatan.php?id=<?php echo $rowKegiatan['id_kegiatan']; ?>">
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="./files_kegiatan/<?php echo $rowKegiatan['fotoKegiatan']; ?>"
                                                            alt="Foto Kegiatan" class="post-author-img flex-shrink-0"
                                                            style="border-radius: 50%; width: 65px;">
                                                    </div>
                                                    <div style="color: #000000; font-size: 14px;">
                                                        <p>
                                                            <?php echo $rowKegiatan['namaKegiatan']; ?>
                                                            <p style="color: #6f6f6f ;">
                                                                <?php echo $rowKegiatan['jenisKegiatan']; ?>
                                                            </p>
                                                        </p>
                                                        
                                                    </div>
                                                </div>
                                                <div style="margin-top: 10px; font-size: 12px;">
                                                    <p style="color: red;">Batas Registrasi : 
                                                        <?php echo isset($rowKegiatan['batasRegistrasi']) ? $rowKegiatan['batasRegistrasi'] : "Belum Ditetapkan"; ?>
                                                    </p>
                                                    <p style="color: #000000;">Lokasi : 
                                                        <?php echo isset($rowKegiatan['lokasi']) ? $rowKegiatan['lokasi'] : "Belum Ditetapkan"; ?>                                                    </p>
                                                        </div>
                                                    </a>
                                                </article>
                                        <?php
                                    }
                                } else {
                                    echo '<p>Tidak ada kegiatan terkait.</p>';
                                }
                                ?>
                            </div><!-- End sidebar recent posts-->
                        </div><!-- End Blog Sidebar -->

                    </div>

                </div>

            </div>
        </section><!-- End Blog Details Section -->

    </main><!-- End #main -->

    <?php include('form/footer.php'); ?>
</body>

</html>