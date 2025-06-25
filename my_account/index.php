<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';

    if (isset($_GET['logout'])) {
        session_name('audit_user');
        session_destroy();
        header('Location: /');
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
                                <a href="/my_account/index.php" class="nav-link active" aria-current="page"><i class="fa-solid fa-list"></i>
                                    Rezumat
                                </a>
                            </li>
                            <li>
                                <a href="/my_account/history.php" class="nav-link text-dark"><i class="fa-solid fa-clock-rotate-left"></i>
                                    Istoric
                                </a>
                            </li><li>
                                <a href="/my_account/settings.php" class="nav-link text-dark"><i class="fa-solid fa-gear"></i>
                                    Setari
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart_history">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart_settings_history">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
        <script src="/assets/js/overview.js"></script>
    </body>
</html>
