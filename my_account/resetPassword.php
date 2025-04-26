<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['hash']) && isset($_POST['submit'])) {
        $userHash = mysqli_query($con, 'SELECT email, password_reset_hash FROM users WHERE password_reset_hash = "' . $_GET['hash'] . '"');
        $invalidLink = false;
        $error_password = false;
        $succes = false;
        if (mysqli_num_rows($userHash)) {
            $parolaNoua = $_POST['parola'];
            $parolaNoua1 = $_POST['repetaParola'];

            if ($parolaNoua != $parolaNoua1) {
                $error_password = true;
            }

            if (!$error_password) {
                mysqli_query($con, "UPDATE `users` SET password = '" . $parolaNoua . "' WHERE `password_reset_hash` = '" . $_GET['hash'] . "'");
                mysqli_query($con, "UPDATE `users` SET password_reset_hash = '' WHERE `password_reset_hash` = '" . $_GET['hash'] . "'");
                $succes = true;
            }
        } else {
            $invalidLink = true;
        }
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    <link href="/assets/css/sign-in.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
<main class="form-signin w-100 m-auto">
    <form action="" method="post">
        <h1 class="h3 mb-3 fw-normal">Resetare parola</h1>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="Parola" name="parola"/>
            <label for="floatingInput">Parola</label>
        </div> <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="Repeta parola" name="repetaParola"/>
            <label for="floatingInput">Repeta parola</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="submit" id="btnTrimitereEmail">Confirma parola</button>
        <?php
            if (isset($_POST['submit'])) {
                if ($error_password && !$invalidLink) {
                    echo '<div class="alert alert-danger my-4" role="alert">
                            Parolele nu coincid!</div>';
                }
                if ($succes && !$invalidLink) {
                    echo '<div class="alert alert-success my-4" role="alert">Parolele au fost schimbate cu succes!</div>';
                }
                if ($invalidLink) {
                    echo '<div class="alert alert-danger my-4" role="alert">Linkul nu mai este valid!</div>';
                }
            }
        ?>

    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
</body>
</html>
