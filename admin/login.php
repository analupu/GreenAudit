<?php
    session_name('audit_admin');
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    if (isset($_POST['submit'])) {
        $form_email = $_POST['email'];
        $form_password = $_POST['password'];

        $users_query = mysqli_query($con, "SELECT `id`, `email`, `password` FROM `users` WHERE `email` = '" . $form_email . "' AND `password` = '" . $form_password . "' AND `is_admin` = 1");

        $error = false;
        if (mysqli_num_rows($users_query)) {
            $_SESSION['audit_admin_logged_in'] = true;
            $_SESSION['audit_admin_logged_in_user_id'] = mysqli_fetch_assoc($users_query)['id'];

            header('Location: /admin');
            die;
        } else {
            $error = true;
        }
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
        <link href="/assets/css/sign-in.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
        <main class="form-signin w-100 m-auto">
            <form action="" method="post">
                <h1 class="h3 mb-3 fw-normal">Please log in</h1>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"/>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password"/>
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Login</button>
                <?php
                    if (isset($_POST['submit'])) {
                        if ($error) {
                            echo '<div class="alert alert-danger my-4" role="alert">
                            Datele introduse sunt gresite!</div>';
                        }
                    }
                ?>
            </form>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
    </body>
</html>