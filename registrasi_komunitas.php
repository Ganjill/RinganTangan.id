<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Registrasi</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/css/registrasi.css" rel="stylesheet">
    <?php include("form/head.php"); ?>
</head>

<body>
    <?php include('form/navbar_dashboard.php'); ?>
    <div class="form">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="form-container">
                        <h3 class="title">Registrasi Akun Komunitas</h3>
                        <?php
                        if (isset($_POST['submit'])) {
                            $nama_komunitas = htmlspecialchars($_POST["nama_komunitas"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $password = $_POST["password"];
                            $confirmpassword = $_POST["confirmpassword"];
                            $ketua = htmlspecialchars($_POST["ketua"]);
                            $lokasi = htmlspecialchars($_POST["lokasi"]);
                            $tgl_berdiri = $_POST["tgl_berdiri"];
                            $deskripsi = htmlspecialchars($_POST["deskripsi"]);
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $errors = array();

                            if (empty($nama_komunitas) or empty($email) or empty($password) or empty($confirmpassword) or empty($ketua) or empty($lokasi) or empty($tgl_berdiri) or empty($deskripsi)) {
                                array_push($errors, "Semua Data Wajib Diisi");
                            }
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors, "Email Tidak Valid");
                            }

                            if (strlen($password) < 8) {
                                array_push($errors, "Password harus berisi 8 karakter");
                            }
                            if ($password !== $confirmpassword) {
                                array_push($errors, "Password tidak cocok");
                            }
                            require_once "koneksi.php";
                            $sql_check_nama = "SELECT * FROM komunitas WHERE nama_komunitas = ?";
                            $stmt_check_nama = mysqli_prepare($koneksi, $sql_check_nama);
                            mysqli_stmt_bind_param($stmt_check_nama, "s", $nama_komunitas);
                            mysqli_stmt_execute($stmt_check_nama);
                            $result_check_nama = mysqli_stmt_get_result($stmt_check_nama);
                            $rowCount_check_nama = mysqli_num_rows($result_check_nama);
                            if ($rowCount_check_nama) {
                                array_push($errors, "Nama Komunitas Sudah Ada");
                            }

                            if (count($errors) > 0) {
                                foreach ($errors as $error) {
                                    echo "<div class='alert alert-danger'>$error</div>";
                                }
                            } else {
                                $folder_gambar = "./files_komunitas/";
                                $foto = $_FILES['foto']['name'];
                                $path_gambar_lengkap = $folder_gambar . $foto;
                                move_uploaded_file($_FILES['foto']['tmp_name'], $path_gambar_lengkap);
                                $_SESSION['user_type'] = 'komunitas';
                                $_SESSION['email'] = $email;
                                $_SESSION['profile_image'] = $path_gambar_lengkap;
                                $sql_insert = "INSERT INTO `komunitas`(`nama_komunitas`, `email`, `password`, `ketua`, `lokasi`, `tgl_berdiri`, `deskripsi`, `foto`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt_insert = mysqli_stmt_init($koneksi);
                                mysqli_stmt_prepare($stmt_insert, $sql_insert);
                                mysqli_stmt_bind_param($stmt_insert, "ssssssss", $nama_komunitas, $email, $hashed_password, $ketua, $lokasi, $tgl_berdiri, $deskripsi, $foto);
                                mysqli_stmt_execute($stmt_insert);
                                echo "<div class='alert alert-success'><strong>Kamu Berhasil Registrasi</strong></div>";

                                header("refresh:1;url=login.php");
                                mysqli_stmt_close($stmt_insert);
                            }
                            mysqli_stmt_close($stmt_check_nama);
                            mysqli_close($koneksi);
                        }
                        ?>


                        <form class="form-horizontal" action="registrasi_komunitas.php" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Komunitas</label>
                                <input type="text" name="nama_komunitas" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control"
                                    autocomplete="new-password" placeholder="">
                            </div>
                            <h4 class="sub-title">Personal Information</h4>
                            <div class="form-group">
                                <label>Nama Ketua </label>
                                <input type="text" name="ketua" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Berdiri Organisasi</label>
                                <input type="date" name="tgl_berdiri" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Foto komunitas</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <div class="form-group" style="width: 100%;">
                                <label>Deskripsi Organisasi</label>
                                <textarea class="form-control" placeholder="Deskripsi Organisasi" name="deskripsi"
                                    style="height: 100px"></textarea>
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