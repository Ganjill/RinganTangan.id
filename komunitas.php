<?php
include 'koneksi.php';
session_start();

// Tentukan jumlah item per halaman
$itemsPerPage = 6;

// Ambil parameter halaman dari URL, atau set default ke halaman 1
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Hitung offset untuk query database
$offset = ($currentPage - 1) * $itemsPerPage;

// Ambil data komunitas dari database (gantilah dengan logika pengambilan data yang sesuai)
$sqlKomunitas = "SELECT * FROM komunitas ORDER BY nama_komunitas DESC LIMIT $offset, $itemsPerPage"; // Mengambil data komunitas sesuai halaman
$resultKomunitas = mysqli_query($koneksi, $sqlKomunitas);

if ($resultKomunitas && mysqli_num_rows($resultKomunitas) > 0) {
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
                    <h2>Cari Komunitas</h2>
                    <form class="d-flex" role="search" style="margin-right: auto;">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="row gy-4" id="komunitasList">
                    <?php
                    // Loop untuk menampilkan setiap komunitas
                    while ($rowKomunitas = mysqli_fetch_assoc($resultKomunitas)) {
                        $fotoKomunitas = $rowKomunitas['foto'];
                        $namaKomunitas = $rowKomunitas['nama_komunitas'];
                        $lokasiKomunitas = $rowKomunitas['lokasi'];
                        ?>
                        <div class="col-xl-4 col-md-6 komunitas-item" data-nama="<?php echo strtolower($namaKomunitas); ?>">
                            <article>
                                <a href="profil_komunitas.php?id=<?php echo $rowKomunitas['id_komunitas']; ?>">
                                    <div class="d-flex">
                                        <div>
                                            <img src="./files_komunitas/<?php echo $fotoKomunitas; ?>" alt="Foto Komunitas"
                                                class="post-author-img flex-shrink-0" style="border-radius: 50%;">
                                        </div>
                                        <div class="post-meta">
                                            <p class="post-author">
                                                <?php echo $namaKomunitas; ?>
                                            </p>
                                            <p class="post-date">
                                                <time datetime="">
                                                    <?php echo $lokasiKomunitas; ?>
                                                </time>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        </div><!-- End post list item -->
                    <?php } // Tutup loop ?>
                </div><!-- End recent posts list -->

                <?php
                // Hitung jumlah total halaman
                $totalPages = ceil(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM komunitas")) / $itemsPerPage);
                ?>

                <div class="blog">
                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
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
            </div>
        </section><!-- End Recent Blog Posts Section -->

        <script>
            $(document).ready(function () {
                $("#searchInput").on("input", function () {
                    var searchValue = $(this).val().toLowerCase();

                    $("#komunitasList .komunitas-item").filter(function () {
                        var namaKomunitas = $(this).data("nama").toLowerCase();
                        $(this).toggle(namaKomunitas.indexOf(searchValue) > -1);
                    });
                });
            });
        </script>

        <?php include('form/footer.php'); ?>
    </body>

    </html>
    <?php
} else {
    // Handle jika data komunitas tidak ditemukan
    echo "Tidak ada komunitas yang ditemukan.";
}
?>