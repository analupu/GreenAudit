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
        <link href="/admin/assets/css/cards.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
        <main class="d-flex my-5">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h2>Rezumat</h2>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <section class="card card-featured-user card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-user">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Utilizatori</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($utlizatori); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                    <a class="text-muted" href="/admin/utilizatori">(vizualizeaza)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-simulari card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-simulari">
                                                    <i class="fas fa-chart-simple"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Simulari</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($istoric); ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-categorii-articole card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-categorii-articole">
                                                    <i class="fas fa-list"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Categorii articole</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($categorii_articole); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                    <a class="text-muted" href="/admin/categorii_articole">(vizualizeaza)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-articole card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-articole">
                                                    <i class="fas fa-newspaper"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Articole</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($articole); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                    <a class="text-muted" href="/admin/articole">(vizualizeaza)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-comentarii card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-comentarii">
                                                    <i class="fas fa-comments"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Comentarii</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($comentarii); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                    <a class="text-muted" href="/admin/comentarii">(vizualizeaza)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-recenzii card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-recenzii">
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Recenzii</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_fetch_assoc($recenzii)['total_ratings_count']; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-3">
                                <section class="card card-featured-imagini card-featured-primary mb-3">
                                    <div class="card-body">
                                        <div class="widget-summary">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-primary bg-primary-imagini">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Imagini</h4>
                                                    <div class="info">
                                                        <strong class="amount"><?php echo mysqli_num_rows($imagini); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                    <a class="text-muted" href="/admin/imagini">(vizualizeaza)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div id="chart_house_type" style="height: 350px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div id="chart_categorii_articole" style="height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div id="chart_simulari" style="height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
        <script src="/admin/assets/js/index.js"></script>
    </body>
</html>

