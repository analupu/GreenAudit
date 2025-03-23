<?php
    session_start();

    if (isset($_SESSION['audit_logged_in'])) {
        $is_logged = true;
    }
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once 'inc/head.php'; ?>
        <link href="assets/css/page_ed.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once 'inc/theme_switcher.php'; ?>
        <?php require_once 'inc/nav.php'; ?>
        <main class="d-flex">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Continut educativ</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#file-earmark-text"></use>
                            </svg>
                            Articole
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#bar-chart"></use>
                            </svg>
                            Grafice
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#image"></use>
                            </svg>
                            Imagini
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>User</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Simulare noua</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>

            <div class="content">
                <div id="welcome-message">
                    <h1 class="text-white">Bine ai venit pe Pagina Educativă!</h1>
                    <p>Scrolleaza pentru a vedea mai mult continut ...</p>
                </div>

                <div id="educational-content">
                    <div style="height: 1500px; background: linear-gradient(to bottom, #ff9a9e, #fad0c4);">
                        <h2 style="padding: 50px;">Mai mult continut educativ</h2>
                    </div>
                </div>

        </main>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const welcomeMessage = document.getElementById("welcome-message");
                const educationalContent = document.getElementById("educational-content");

                window.addEventListener("scroll", function () {
                    if (window.scrollY > 100) {
                        welcomeMessage.style.opacity = "0";
                        welcomeMessage.style.height = "0px";
                        setTimeout(() => {
                            welcomeMessage.style.display = "none";
                            educationalContent.style.display = "block";
                            setTimeout(() => {
                                educationalContent.style.opacity = "1";
                            }, 50);
                        }, 500);
                    }
                });
            });
        </script>
        <?php require_once 'inc/javascript.php'; ?>
    </body>
</html>