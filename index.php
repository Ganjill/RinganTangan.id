<?php
include 'koneksi.php';
session_start();

// Ambil data kegiatan dari database (gantilah dengan logika pengambilan data yang sesuai)
$sqlKegiatan = "SELECT * FROM kegiatan ORDER BY tanggalMulai DESC LIMIT 3"; // Mengambil kegiatan terbaru
$resultKegiatan = mysqli_query($koneksi, $sqlKegiatan);
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

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero">
        <div class="container position-relative">
            <div class="row gy-5" data-aos="fade-in">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                    <h2><span>Keindahan Terletak Dalam Kelembutan Tangan Yang Ringan</span></h2>
                    <p>Mari berbuat kebaikan hari ini.</p>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="kegiatan.php" class="btn-get-started">Cari Kegiatan</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <img src="assets/img/vl3.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
                </div>
            </div>
        </div>

        </div>
    </section>
    <!-- End Hero Section -->
    <!-- ======= About Us Section ======= -->


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

// Query untuk mendapatkan jumlah kegiatan
$sql_jumlah_kegiatan = "SELECT COUNT(*) as total_kegiatan FROM kegiatan";
$result_jumlah_kegiatan = mysqli_query($koneksi, $sql_jumlah_kegiatan);
$row_jumlah_kegiatan = mysqli_fetch_assoc($result_jumlah_kegiatan);
$total_kegiatan = isset($row_jumlah_kegiatan['total_kegiatan']) ? $row_jumlah_kegiatan['total_kegiatan'] : 0;
?>

                           
<!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4 align-items-center">

                                       <div class="col-lg-6">
                <img src="assets/img/stats-img.jpg" alt="" class="img-fluid">
                </div>
            <div class="col-lg-6">
                    <div class="stats-item d-flex align-items-center">
                    <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_relawan; ?>" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Relawan</strong> yang telah berpartisipasi di ringantangan.id</p>
                </div><!-- End Stats Item -->
                <div class="stats-item d-flex align-items-center">
                        <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_komunitas; ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Komunitas</strong> yang telah dibentuk</p>
                </div><!-- End Stats Item -->
                <div class="stats-item d-flex align-items-center">
                        <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_kegiatan; ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p><strong>Kegiatan</strong> yang telah dibuat</p>
                </div><!-- End Stats Item -->
            </div>
        </div>
        </div>
</section><!-- End Stats Counter Section -->


    <!-- ======= Aktivitas======= -->
    <section id="recent-posts" class="recent-posts sections-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Cari Kegiatan</h2>
                <p>Pilih kegiatan kerelawanan sesuai minat, lokasi, dan isu yang kamu sukai </p>
            </div>

            <?php
            if ($resultKegiatan && mysqli_num_rows($resultKegiatan) > 0) {
            ?>
                <div class="row gy-4">
                    <?php
                    // Loop untuk menampilkan setiap kegiatan
                    while ($rowKegiatan = mysqli_fetch_assoc($resultKegiatan)) {
                        $fotoKegiatan = $rowKegiatan['fotoKegiatan'];
                        $jenisKegiatan = $rowKegiatan['jenisKegiatan'];
                        $namaKegiatan = $rowKegiatan['namaKegiatan'];
                        $namaKomunitas = $rowKegiatan['nama_komunitas'];
                        $tanggalMulai = $rowKegiatan['tanggalMulai'];
                        $formattedTanggalMulai = date("d M Y", strtotime($tanggalMulai));
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <article>
                                <div class="post-img">
                                    <img src="./files_kegiatan/<?php echo $fotoKegiatan; ?>" alt="Foto Kegiatan" class="img-fluid">
                                </div>
                                <p class="post-category">
                                    <?php echo $jenisKegiatan; ?>
                                </p>
                                <h2 class="title">
                                    <a href="profil_kegiatan.php?id=<?php echo $rowKegiatan['id_kegiatan']; ?>">
                                        <?php echo $namaKegiatan; ?>
                                    </a>
                                </h2>
                                <p class="post-author">
                                    <?php echo $namaKomunitas; ?>
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="post-meta">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <p class="post-date">
                                            <time datetime="<?php echo $tanggalMulai; ?>">
                                                <?php echo $formattedTanggalMulai; ?>
                                            </time>
                                        </p>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End post list item -->
                    <?php } // Tutup loop ?>
                </div><!-- End recent posts list -->
            <?php
            } else {
                // Jika tidak ada kegiatan
                echo '<div class="text-center"><p>Tidak ada kegiatan yang ditemukan.</p></div>';
            }
            ?>
        </div>
    </section><!-- End Recent Blog Posts Section -->


    <main id="main">

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq">
            <div class="container" data-aos="fade-up">

                <div class="row gy-4">

                    <div class="col-lg-4">
                        <div class="content px-xl-5">
                            <h3>Frequently Asked <strong>Questions</strong></h3>
                            <p>
                                
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                                        <span class="num">1.</span>
                                        Apa itu RinganTangan.id?
                                    </button>
                                </h3>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                    RinganTangan adalah lembaga nonprofit yang memiliki misi untuk menjadikan kerelawanan sebagai gaya hidup anak muda 
                                    di Batam. Kami menghubungkan organisasi sosial yang membutuhkan relawan dan siapapun yang ingin menjadi 
                                    relawan melalui platform RinganTangan.id
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                        <span class="num">2.</span>
                                        Bagaimana cara membuat akun relawan?
                                    </button>
                                </h3>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        Pengguna dapat membuat akun dengan cara registrasi akun relawan yang ada pada halaman homee,dan mengisi form tersebut.
                                    </div>
                                </div>
                            </div><!-- # Faq item--> 

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-5">
                                        <span class="num">3.</span>
                                        Bagaimana cara membuat akun komunitas?
                                    </button>
                                </h3>
                                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        Pengguna dapat mendaftar sebagai komunitas dalam halaman registrasi komunitas pada halaman home dan mengisi form yang tertera
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                                        <span class="num">4.</span>
                                        Bagaimana cara menggunakan website RinganTangan?
                                    </button>
                                </h3>
                                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                    Silahkan akses panduan relawan untuk mempelajari website RinganTangan.id di halaman ini
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-4">
                                        <span class="num">5.</span>
                                        Bagaimana cara daftar Kegiatan di RinganTangan?
                                    </button>
                                </h3>
                                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        Pengguna dapat mendaftar kegiatan, dengan membuka halaman kegiatan yang sesuai minat dan menekan tombol daftar kegiatan, lalu mengisi form yang tertera.
                                    </div>
                                </div>
                            </div><!-- # Faq item-->

                            

                        </div>

                    </div>
                </div>

            </div>
        </section><!-- End Frequently Asked Questions Section -->


    </main><!-- End #main -->

    <?php include('form/footer.php'); ?>
</body>

</html>