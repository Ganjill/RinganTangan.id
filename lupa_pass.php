<?php
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
                        <h3 class="title">Lupa Password</h3>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group" style="width: 100%;">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group" style="width: 100%;">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control"
                                    autocomplete="new-password" placeholder="">
                            </div>
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