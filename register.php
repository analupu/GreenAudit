<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    if (isset($_POST['submit'])) {
        $form_email = $_POST['email'];
        $form_password = $_POST['password'];
        $form_firstName = $_POST['firstName'];
        $form_lastName = $_POST['lastName'];
        $form_password1 = $_POST['password1'];

        $venitLunar = $_POST['venitLunar'];
        $numarulMembrilor = $_POST['numarulMembrilor'];
        $tipLocuinta = $_POST['tipLocuinta'];
        $settings = json_encode([
            'venitLunar' => $venitLunar,
            'numarulMembrilor' => $numarulMembrilor,
            'tipLocuinta' => $tipLocuinta,
            'updatedAt' => date('Y-m-d H:i:s')
        ]);;

        $error_password = false;
        $error_email = false;

        if ($form_password != $form_password1) {
            $error_password = true;
        }

        $users_query_email = mysqli_query($con, "SELECT `email` FROM `users` WHERE `email` = '" . $form_email . "'");
        if (mysqli_num_rows($users_query_email)) {
            $error_email = true;
        }

        if (!$error_password && !$error_email) {
            mysqli_query($con, "INSERT INTO `users` (`email`, `password`, `firstName`, `lastName`, `settings`) VALUES ('" . $form_email . "', '" . $form_password . "', '" . $form_firstName . "', '" . $form_lastName . "', '" . $settings . "')");
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
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
        <main class="form-signin w-100 m-auto mt-5">
            <form action="" method="post">
                <h1 class="h3 mb-3 fw-normal">Inregistrare</h1>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFirstName" placeholder="Prenume" name="firstName"
                           required/>
                    <label for="floatingFirstName">Prenume</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingLastName" placeholder="Nume" name="lastName"
                           required/>
                    <label for="floatingLastName">Nume</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                           required/>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Parola" name="password"
                           required/>
                    <label for="floatingPassword">Parola</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword1" placeholder="Repeta parola"
                           name="password1" required/>
                    <label for="floatingPassword">Repeta parola</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="venitLunar" name="venitLunar" placeholder="Venit lunar" required />
                    <label for="venitLunar">Venit lunar</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="numarulMembrilor" name="numarulMembrilor" placeholder="Numarul membrilor din gospodarie" required />
                    <label for="numarulMembrilor">Numarul membrilor din gospodarie</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="tipLocuinta" name="tipLocuinta" placeholder="Tipul locuintei" />
                    <label for="tipLocuinta">Tip locuinta</label>
                </div>
                <button class="btn btn-success w-100 py-2" type="submit" name="submit"><i class="fa-solid fa-user-plus"></i> Inregistrare</button>
                <?php
                    if (isset($_POST['submit'])) {
                        if ($error_email) {
                            echo '<div class="alert alert-danger my-4" role="alert">
                            Adresa de email exista deja!</div>';
                        }

                        if ($error_password) {
                            echo '<div class="alert alert-danger my-4" role="alert">
                            Parolele nu coincid!</div>';
                        }

                        if (!$error_password && !$error_email) {
                            echo '<div class="alert alert-success my-4" role="alert">
                            Cont creat cu succes!</div>';
                        }
                    }
                ?>
            </form>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
    </body>
</html>
