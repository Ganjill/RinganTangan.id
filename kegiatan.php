<?php
include 'koneksi.php';
session_start();

// Tentukan jumlah item per halaman
$itemsPerPage = 6;

// Ambil parameter halaman dari URL, atau set default ke halaman 1
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Hitung offset untuk query database
$offset = ($currentPage - 1) * $itemsPerPage;

// Ambil data kegiatan dari database (gantilah dengan logika pengambilan data yang sesuai)
$sqlKegiatan = "SELECT * FROM kegiatan ORDER BY tanggalMulai DESC LIMIT $offset, $itemsPerPage"; // Mengambil data kegiatan sesuai halaman
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <?php include('form/navbar_dashboard.php'); ?>

    <!-- ======= Aktivitas======= -->
    <section id="recent-posts" class="recent-posts sections-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Cari Kegiatan</h2>
                <p>Pilih kegiatan kerelawanan sesuai minat, lokasi, dan isu yang kamu sukai </p>
                <form class="d-flex" role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>

            <?php
            if ($resultKegiatan && mysqli_num_rows($resultKegiatan) > 0) {
            ?>
                <div class="row gy-4" id="kegiatanList">
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
                        <div class="col-xl-4 col-md-6 kegiatan-item" data-nama="<?php echo strtolower($namaKegiatan); ?>">
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
                    <?php } // Tutup loop 
                    ?>
                </div><!-- End recent posts list -->

                <?php
                // Hitung jumlah total halaman
                $totalPages = ceil(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kegiatan")) / $itemsPerPage);
                ?>

                <div class="blog">
                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li <?php if ($i == $currentPage)
                                        echo 'class="active"'; ?>>
                                    <a href="?page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div><!-- End blog pagination -->
                </div>
            <?php
            } else {
                // Jika tidak ada kegiatan
                echo '<div class="text-center"><p>Tidak ada kegiatan yang ditemukan.</p></div>';
            }
            ?>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#searchInput").on("input", function() {
                var searchValue = $(this).val().toLowerCase();

                $("#kegiatanList .kegiatan-item").filter(function() {
                    var namaKegiatan = $(this).data("nama").toLowerCase();
                    $(this).toggle(namaKegiatan.indexOf(searchValue) > -1);
                });
            });
        });
    </script>

    <?php include('form/footer.php'); ?>
</body>

</html>