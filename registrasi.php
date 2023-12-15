    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Registrasi</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <?php include('form/head.php'); ?>
        <link href="assets/css/registrasi.css" rel="stylesheet">
    </head>

    <body>
            <?php include('form/navbar_dashboard.php'); ?>
        <div class="form">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="form-container">
                            <h3 class="title">Registrasi Akun Relawan</h3>
                            <?php
                            if (isset($_POST['submit'])) {
                                $nama = $_POST["nama"];
                                $email = $_POST["email"];
                                $password = $_POST["password"];
                                $confirmpassword = $_POST["confirmpassword"];
                                $tanggal_lahir = $_POST["tanggal_lahir"];
                                $alamat = $_POST["alamat"];
                                $jenis_kelamin = $_POST["jenis_kelamin"];
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                $errors = array();

                                if (empty($nama) or empty($email) or empty($password) or empty($confirmpassword) or empty($tanggal_lahir) or empty($alamat) or empty($jenis_kelamin)) {
                                    array_push($errors, "Semua Data Wajib Diisi");
                                }
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    array_push($errors, "Email tidak valid");
                                }

                                if (strlen($password) < 8) {
                                    array_push($errors, "Password harus berisi 8 karakter");
                                }
                                if ($password !== $confirmpassword) {
                                    array_push($errors, "Password tidak cocok");
                                }

                                require_once "koneksi.php";
                                $sql = "SELECT * FROM relawan where email = '$email'";
                                $result = mysqli_query($koneksi, $sql);
                                $rowCount = mysqli_num_rows($result);
                                if ($rowCount) {
                                    array_push($errors, "Email Sudah Ada");
                                }

                                if (count($errors) > 0) {
                                    echo "<div class='alert alert-danger'><strong>Error:</strong><br>";
                                    foreach ($errors as $error) {
                                        echo "- $error<br>";
                                    }
                                    echo "</div>";
                                } else {
                                    require_once "koneksi.php";
                                    $sql = "INSERT INTO `relawan`(`nama`, `email`, `password`, `tanggal_lahir`, `alamat`, `jenis_kelamin`) VALUES (?, ?, ?, ?, ?, ?)";
                                    $stmt = mysqli_stmt_init($koneksi);
                                    $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                                    if ($preparestmt) {
                                        mysqli_stmt_bind_param($stmt, "ssssss", $nama, $email, $hashed_password, $tanggal_lahir, $alamat, $jenis_kelamin);
                                        mysqli_stmt_execute($stmt);
                                        echo "<div class='alert alert-success'><strong>Kamu Berhasil Registrasi</strong></div>";
                                        // Redirect to login.php after 3 seconds
                                        header("refresh:1;url=login.php");
                                    }
                                }
                            }
                            ?>
                            
                            <form class="form-horizontal" action="registrasi.php" method="post">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirmpassword" class="form-control" placeholder="">
                                </div>
                                <h4 class="sub-title">Personal Information</h4>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <span class="signin-link">Sudah punya akun? Tekan <a href="login.php">Login</a></span>
                                <button class="btn signup" type="submit" name="submit">Daftar</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php include('form/footer.php'); ?>
    </body>

    </html>