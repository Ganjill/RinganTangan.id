<?php
require_once "koneksi.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
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
                <div class="col-md-6 col-lg-5">
                    <div class="form-container">
                        <h3 class="title">Login</h3>
                        <?php

                        if (isset($_POST['login'])) {
                            $email = trim($_POST["email"]);
                            $password = $_POST["password"];
                            
                            // Fungsi untuk membersihkan input dan mencegah SQL injection
                            function cleanInput($data)
                            {
                                global $koneksi;
                                return mysqli_real_escape_string($koneksi, htmlspecialchars(strip_tags($data)));
                            }
                            $email = cleanInput($email);
                            // Query untuk mencari di tabel 'relawan'
                            $sql_relawan = "SELECT * FROM relawan WHERE email = ?";
                            // Query untuk mencari di tabel 'komunitas'
                            $sql_komunitas = "SELECT * FROM komunitas WHERE email = ?";
                            // Query untuk mencari di tabel 'admin'
                            $sql_admin = "SELECT * FROM admin WHERE email = ?";

                            $stmt_relawan = mysqli_prepare($koneksi, $sql_relawan);
                            $stmt_komunitas = mysqli_prepare($koneksi, $sql_komunitas);
                            $stmt_admin = mysqli_prepare($koneksi, $sql_admin);

                            if ($stmt_relawan && $stmt_komunitas && $stmt_admin) {
                                mysqli_stmt_bind_param($stmt_relawan, "s", $email);
                                mysqli_stmt_execute($stmt_relawan);

                                $result_relawan = mysqli_stmt_get_result($stmt_relawan);
                                $user_relawan = mysqli_fetch_assoc($result_relawan);

                                mysqli_stmt_bind_param($stmt_komunitas, "s", $email);
                                mysqli_stmt_execute($stmt_komunitas);

                                $result_komunitas = mysqli_stmt_get_result($stmt_komunitas);
                                $user_komunitas = mysqli_fetch_assoc($result_komunitas);

                                mysqli_stmt_bind_param($stmt_admin, "s", $email);
                                mysqli_stmt_execute($stmt_admin);

                                $result_admin = mysqli_stmt_get_result($stmt_admin);
                                $user_admin = mysqli_fetch_assoc($result_admin);

                                if($user_relawan || $user_komunitas || $user_admin) {
                                    if($user_relawan && password_verify($password, $user_relawan["password"])) {
                                        $_SESSION['user_logged_in'] = true;
                                        $_SESSION['user_type'] = 'relawan'; // Add this line to store the role
                                        $_SESSION['nama'] = $user_relawan['nama'];
                                        $_SESSION['id_relawan'] = $user_relawan['id_relawan'];
                                        $_SESSION['email'] = $user_relawan['email'];
                                        header("Location: dashboard_relawan.php");
                                        exit();
                                    } elseif ($user_komunitas && password_verify($password, $user_komunitas["password"])) {
                                        $_SESSION['user_logged_in'] = true;
                                        $_SESSION['user_type'] = 'komunitas';
                                        $_SESSION['nama_komunitas'] = $user_komunitas['nama_komunitas'];
                                        $_SESSION['email'] = $user_komunitas['email'];
                                        $_SESSION['id_komunitas'] = $user_komunitas['id_komunitas']; // Menggunakan langsung dari $user_komunitas
                                        header("Location: dashboard_komunitas.php");
                                        exit();
                                    } elseif($user_admin && password_verify($password, $user_admin["password"])) {
                                        $_SESSION['user_logged_in'] = true;
                                        $_SESSION['user_type'] = 'admin'; // Add this line to store the role
                                        $_SESSION['nama_admin'] = $user_admin['nama_admin'];
                                        $_SESSION['id_admin'] = $user_admin['id_admin'];
                                        $_SESSION['email'] = $user_admin['email'];
                                        header("Location: dashboard_admin.php");
                                        exit();
                                    } else {
                                        echo "<div class='alert alert-danger'>Email atau Password Tidak Cocok</div>";
                                    } 
                                }

                                mysqli_stmt_close($stmt_relawan);
                                mysqli_stmt_close($stmt_komunitas);
                                mysqli_stmt_close($stmt_admin);
                            } else {
                                echo "Ada yang salah dengan prepared statement";
                            }

                            mysqli_close($koneksi);
                        }
                        ?>

                        <form class="form-horizontal" action="login.php" method="post">
                            <div class="form-group" style="width: 100%;">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group" style="width: 100%;">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <span class="signin-link">Belum punya akun? Ayo <a href="registrasi.php">Daftar</a></span>
                            <span class="signin-link"><a href="lupa_pass.php">Lupa
                                    Password?</a></span>
                            <button type="submit" class="btn signup" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('form/footer.php'); ?>
</body>

</html>