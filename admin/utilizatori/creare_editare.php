<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['editId'])) {
    $utilizator = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '" . $_GET['editId'] . "'");
    $utilizator = mysqli_fetch_assoc($utilizator);
}

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

    if (!isset($_GET['editId']) || (isset($_GET['editId']) && !empty($form_password) && !empty($form_password1))) {
        if ($form_password != $form_password1) {
            $error_password = true;
        }
    }

    $users_query_email = mysqli_query($con, "SELECT `email` FROM `users` WHERE `email` = '" . $form_email . "'");
    if (mysqli_num_rows($users_query_email) && $form_email !== $utilizator['email']) {
        $error_email = true;
    }

    if (!isset($_GET['editId'])) {
        if (!$error_password && !$error_email) {
            mysqli_query($con, "INSERT INTO `users` (`email`, `password`, `firstName`, `lastName`, `settings`) VALUES ('" . $form_email . "', '" . $form_password . "', '" . $form_firstName . "', '" . $form_lastName . "', '" . $settings . "')");
            header('Location: /admin/utilizatori');
            die;
        }
    } else {
        if (!empty($form_password) && !empty($form_password1) && !$error_password && !$error_email) {
            mysqli_query($con, "UPDATE `users` SET `firstName` = '" . $form_firstName . "', `lastName` = '" . $form_lastName . "', `email` = '" . $form_email . "', `password` = '" . $form_password . "', `settings` = '" . $settings . "' WHERE `id` = '" . $utilizator['id'] . "'");
            header('Location: /admin/utilizatori');
            die;
        }
        if (empty($form_password) && empty($form_password1) && !$error_email) {
            mysqli_query($con, "UPDATE `users` SET `firstName` = '" . $form_firstName . "', `lastName` = '" . $form_lastName . "', `email` = '" . $form_email . "', `settings` = '" . $settings . "' WHERE `id` = '" . $utilizator['id'] . "'");
            header('Location: /admin/utilizatori');
            die;
        }

        mysqli_query($con, "INSERT INTO `settings_history` (`user_id`, `settings`) VALUES ('" . $utilizator['id'] . "', '" . $utilizator['settings'] . "')");
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
<main class="d-flex">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4">
                <form action="" method="post">
                    <?php if (empty($utilizator)) { echo ' <h1>Adauga utilizator</h1>'; }
                    else { echo '<h1>Editeaza utilizator</h1>'; }?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingFirstName" placeholder="Prenume" name="firstName"
                               required value="<?php if (!empty($utilizator)) { echo $utilizator['firstName']; } ?>" />
                        <label for="floatingFirstName">Prenume</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastName" placeholder="Nume" name="lastName"
                               required value="<?php if (!empty($utilizator)) { echo $utilizator['lastName']; } ?>" />
                        <label for="floatingLastName">Nume</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                               required value="<?php if (!empty($utilizator)) { echo $utilizator['email']; } ?>" />
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Parola" name="password"
                               <?php if (empty($utilizator)) { echo 'required'; } ?> />
                        <label for="floatingPassword">Parola</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword1" placeholder="Repeta parola"
                               name="password1" <?php if (empty($utilizator)) { echo 'required'; } ?> />
                        <label for="floatingPassword">Repeta parola</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="number" id="venitLunar" name="venitLunar" value="<?php if (!empty($utilizator)) { echo json_decode($utilizator['settings'])->venitLunar; } ?>" placeholder="Venit lunar" required />
                        <label for="venitLunar">Venit lunar</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="number" id="numarulMembrilor" name="numarulMembrilor" value="<?php if (!empty($utilizator)) { echo json_decode($utilizator['settings'])->numarulMembrilor; } ?>" placeholder="Numarul membrilor din gospodarie" required />
                        <label for="numarulMembrilor">Numarul membrilor din gospodarie</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="tipLocuinta" name="tipLocuinta" value="<?php if (!empty($utilizator)) { echo json_decode($utilizator['settings'])->tipLocuinta; } ?>" placeholder="Tipul locuintei" />
                        <label for="tipLocuinta">Tip locuinta</label>
                    </div>
                    <button class="btn btn-primary w-100 py-2" type="submit" name="submit">
                        <?php if (empty($utilizator)) { echo '<i
                            class="fa-solid fa-add"></i> Adauga'; }
                            else { echo '<i
                            class="fa-solid fa-pen"></i> Editeaza'; }?></button>
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
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>

