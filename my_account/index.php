<?php
    require_once '../inc/check_login.php';

    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
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
                        <a href="index.php" class="nav-link active" aria-current="page"><i class="fa-solid fa-user"></i>
                            Contul meu
                        </a>
                    </li>
                    <li>
                        <a href="history.php" class="nav-link text-white"><i class="fa-solid fa-clock-rotate-left"></i>
                            Istoric
                        </a>
                    </li><li>
                        <a href="settings.php" class="nav-link text-white"><i class="fa-solid fa-gear"></i>
                            Setari
                        </a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div id="chart_history">
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="chart_settings_history">
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once '../inc/javascript.php'; ?>
        <script src="../assets/js/overview.js"></script>
    </body>
</html>
