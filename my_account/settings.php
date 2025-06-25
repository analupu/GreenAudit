<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    $currentSettings = false;
    $currentSettingsQuery = mysqli_query($con, "SELECT `settings` FROM `users` WHERE `id`= '" . $_SESSION['audit_logged_in_user_id'] . "'");
    if (mysqli_num_rows($currentSettingsQuery)) {
        $currentSettings = json_decode(mysqli_fetch_assoc($currentSettingsQuery)['settings'], true);
    }

    if (isset($_POST['btnSalveaza'])) {
        $venitLunar = $_POST['venitLunar'];
        $numarulMembrilor = $_POST['numarulMembrilor'];
        $tipLocuinta = $_POST['tipLocuinta'];

        $values = json_encode([
            'venitLunar' => $venitLunar,
            'numarulMembrilor' => $numarulMembrilor,
            'tipLocuinta' => $tipLocuinta,
            'updatedAt' => date('Y-m-d H:i:s')
        ]);;

        mysqli_query($con, "INSERT INTO `settings_history` (`user_id`, `settings`) VALUES ('" . $_SESSION['audit_logged_in_user_id'] . "', '" . json_encode($currentSettings) . "')");

        mysqli_query($con, "UPDATE `users` SET `settings` = '" . $values . "' WHERE `id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");
        header('location: /my_account/settings.php');
        die;
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<main class="d-flex my-5">
    <div class="card" style="width: 280px; height: 90vh; margin-left: 0.75rem;">
        <div class="card-body">
            <div style="width: 100%;">
                <h2 class="fs-4">Contul meu</h2>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/my_account/index.php" class="nav-link text-dark" aria-current="page"><i class="fa-solid fa-list"></i>
                            Rezumat
                        </a>
                    </li>
                    <li>
                        <a href="/my_account/history.php" class="nav-link text-dark"><i class="fa-solid fa-clock-rotate-left"></i>
                            Istoric
                        </a>
                    </li><li>
                        <a href="/my_account/settings.php" class="nav-link active"><i class="fa-solid fa-gear"></i>
                            Setari
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <form action="" method="post">
            <div class="col-4 offset-4">
                <h1 class="h3 mb-3 fw-normal text-center">Introduceți informații despre consumul locuinței</h1>
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="number" id="venitLunar" name="venitLunar" placeholder="Venit lunar" required value="<?php if ($currentSettings) { echo $currentSettings['venitLunar']; } ?>">
                            <label for="venitLunar">Venit lunar</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="number" id="numarulMembrilor" name="numarulMembrilor" placeholder="Numarul membrilor din gospodarie" required value="<?php if ($currentSettings) { echo $currentSettings['numarulMembrilor']; } ?>">
                            <label for="numarulMembrilor">Numărul membrilor din gospodărie</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="tipLocuinta" name="tipLocuinta" placeholder="Tipul locuintei" value="<?php if ($currentSettings) { echo $currentSettings['tipLocuinta']; } ?>">
                            <label for="tipLocuinta">Tip locuință</label>
                        </div>
                        <button class="btn btn-primary w-100 py-2" type="submit" name="btnSalveaza"><i class="fa-solid fa-save"></i> Salvează</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
</body>
</html>
