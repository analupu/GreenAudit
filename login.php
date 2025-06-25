<?php
    session_name('audit_user');
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    if (isset($_POST['submit'])) {
        $form_email = $_POST['email'];
        $form_password = $_POST['password'];

        $users_query = mysqli_query($con, "SELECT `id`, `email`, `password`, `is_blocked` FROM `users` WHERE `email` = '" . $form_email . "' AND `password` = '" . $form_password . "'");

        $error = false;
        $errorBlocked = false;

        if (mysqli_num_rows($users_query)) {
            $user = mysqli_fetch_assoc($users_query);

            if ($user['is_blocked'] == '0') {
                $_SESSION['audit_logged_in'] = true;
                $_SESSION['audit_logged_in_user_id'] = $user['id'];

                header('Location: /');
                die;
            } else {
                $errorBlocked = true;
            }

        } else {
            $error = true;
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
                <h1 class="h3 mb-3 fw-normal">Please log in</h1>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required />
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control m-0" id="floatingPassword" placeholder="Password" name="password" required />
                    <label for="floatingPassword">Password</label>
                </div>
                <a href="/my_account/forgottenPassword.php">Resetare parola</a>
                <button class="btn btn-primary w-100 py-2 my-3" type="submit" name="submit"><i class="fa-solid fa-right-from-bracket"></i> Conectare</button>
                <?php
                    if (isset($_POST['submit'])) {
                        if ($error) {
                            echo '<div class="alert alert-danger my-4" role="alert">
                            Datele introduse sunt gresite!</div>';
                        }
                        if ($errorBlocked) {
                            echo '<div class="alert alert-warning my-4" role="alert">
                            Acest cont este blocat!</div>';
                        }
                    }
                ?>
            </form>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
    </body>
</html>