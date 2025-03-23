<?php
    require_once '../inc/check_login.php';
    require_once('../inc/config.php');

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
        header('location: settings.php');
        die;
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once '../inc/head.php'; ?>
</head>
<body>
<?php require_once '../inc/theme_switcher.php'; ?>
<?php require_once '../inc/nav.php'; ?>
<main class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Contul meu</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link text-white" aria-current="page"><i class="fa-solid fa-user"></i>
                    Rezumat
                </a>
            </li>
            <li>
                <a href="history.php" class="nav-link text-white"><i class="fa-solid fa-clock-rotate-left"></i>
                    Istoric
                </a>
            </li><li>
                <a href="settings.php" class="nav-link text-white active"><i class="fa-solid fa-gear"></i>
                    Setari
                </a>
            </li>
        </ul>
    </div>
    <div class="container">
        <form action="" method="post">
            <div class="col-6 offset-3">
                <h1 class="h3 mb-3 fw-normal text-center">Introduceti informatii despre consumul locuintei</h1>
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="number" id="venitLunar" name="venitLunar" placeholder="Venit lunar" value="<?php if ($currentSettings) { echo $currentSettings['venitLunar']; } ?>">
                            <label for="venitLunar">Venit lunar</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="number" id="numarulMembrilor" name="numarulMembrilor" placeholder="Numarul membrilor din gospodarie" value="<?php if ($currentSettings) { echo $currentSettings['numarulMembrilor']; } ?>">
                            <label for="numarulMembrilor">Numarul membrilor din gospodarie</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="tipLocuinta" name="tipLocuinta" placeholder="Tipul locuintei" value="<?php if ($currentSettings) { echo $currentSettings['tipLocuinta']; } ?>">
                            <label for="tipLocuinta">Tip locuinta</label>
                        </div>
                        <button class="btn btn-primary w-100 py-2" type="submit" name="btnSalveaza">Salveaza</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<?php require_once '../inc/javascript.php'; ?>
</body>
</html>
