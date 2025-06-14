<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';

    if (isset($_GET['logout'])) {
        session_name('audit_admin');
        session_destroy();
        header('Location: /admin');
        die;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    $utlizatori = mysqli_query($con, "SELECT * FROM `users` WHERE `is_admin` = 0");

    $istoric = mysqli_query($con, "SELECT * FROM `results_history`");

    $categorii_articole = mysqli_query($con, "SELECT * FROM `articles_categories`");

    $articole = mysqli_query($con, "SELECT * FROM `articles`");

    $comentarii = mysqli_query($con, "SELECT * FROM `articles_comments`");

    $recenzii = mysqli_query($con, "SELECT SUM(`ratings_count`) as 'total_ratings_count' FROM `articles`");

    $imagini = mysqli_query($con, "SELECT * FROM `image_gallery`");

?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
        <main class="d-flex">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h2>Rezumat</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="card text-bg-primary mx-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Utilizatori</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($utlizatori); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Simulari</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($istoric); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Categorii articole</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($categorii_articole); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Articole</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($articole); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Comentarii</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($comentarii); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary mx-3 mt-3 me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Recenzii</h5>
                            <p class="card-text"><?php echo mysqli_fetch_assoc($recenzii)['total_ratings_count']; ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-primary mt-3 me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Imagini</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($imagini); ?></p>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row mt-3">
                    <div class="col-4">
                        <div id="chart_house_type" style="height: 350px;">
                        </div>
                    </div>
                    <div class="col-4">
                        <div id="chart_categorii_articole"style="height: 350px;"></div>
                    </div>
                    <div class="col-4">
                        <div id="chart_simulari" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
        <script src="/admin/assets/js/index.js"></script>
    </body>
</html>

