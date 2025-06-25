<?php
    require_once $_SERVER['DOCUMENT_ROOT'] .'/inc/config.php';

    if (isset($_POST['submit'])) {
        $form_email = $_POST['email'];
        $users_query = mysqli_query($con, "SELECT `id`, `email` FROM `users` WHERE `email` = '" . $form_email . "'");
        if (mysqli_num_rows($users_query)) {
            $hash = md5(uniqid(rand(), true));
            mysqli_query($con, "UPDATE `users` SET password_reset_hash = '" . $hash . "' WHERE `email` = '" . $form_email . "'");
            $link = "http://localhost/my_account/resetPassword.php?hash=" . $hash;
            $subject = 'Resetare Parola Audit Energetic';
            $mesaj = 'Link resetare parola: <a href="' . $link . '" target="_blank">' . $link . '</a>';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            mail($form_email, $subject, $mesaj, $headers);
        }
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    <link href="../assets/css/sign-in.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<main class="form-signin w-100 m-auto mt-5">
    <form action="" method="post">
        <h1 class="h3 mb-3 fw-normal">Parolă uitată</h1>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"/>
            <label for="floatingInput">Adresa de E-Mail</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="submit" id="btnTrimitereEmail">Trimite email</button>
        <?php
        if (isset($_POST['submit'])) {

            echo '<div class="alert alert-success my-4" role="alert">
                        Daca adresa de email corespunde unui cont, a fost trimis un email cu instructiuni pentru resetarea parolei!</div>';
        }
        ?>

    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
</body>
</html>