<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!--img src="assets/img/logo.jpg" alt="">-->
            <h1>RinganTangan<span>.</span>id</h1>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="kegiatan.php">Cari Kegiatan</a></li>
                <li><a href="komunitas.php">Cari Komunitas</a></li>

                <?php
                if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
                    // Check tipe pengguna (komunitas, relawan, admin)
                    if ($_SESSION['user_type'] == 'komunitas') {
                        echo '<li><a href="dashboard_komunitas.php">Dashboard</a></li>';
                    } elseif ($_SESSION['user_type'] == 'relawan') {
                        echo '<li><a href="dashboard_relawan.php">Dashboard</a></li>';
                    } elseif ($_SESSION['user_type'] == 'admin') {
                        echo '<li><a href="dashboard_admin.php">Dashboard</a></li>';
                    }
                    echo '<li><a href="logout.php">Keluar</a></li>';
                } else {
                    // Jika pengguna belum login
                    echo '<li class="dropdown"><a href="login.php"><span>Login/Registrasi</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>';
                    echo '<ul>';
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li class="dropdown"><a href="registrasi.php"><span>Registrasi</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>';
                    echo '<ul>';
                    echo '<li><a href="registrasi.php">Relawan</a></li>';
                    echo '<li><a href="registrasi_komunitas.php">Komunitas</a></li>';
                    echo '</ul>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
            </ul>
        </nav><!-- .navbar -->
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
</header><!-- End Header -->