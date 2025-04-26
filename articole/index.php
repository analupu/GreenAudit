<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    <link href="/assets/css/articole.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<main class="d-flex">
    <div class="container">
        <div class="position-relative overflow-hidden m-md-3 text-center bg-body-tertiary" style="background-image: url('/images/background_page_ed.jpg')";>
            <nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom" data-bs-theme="dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasLabel">Aperture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav flex-grow-1 justify-content-between articles-categories-buttons">
                                <li class="nav-item bigger-text"><a class="nav-link active" href="#" data-filter="*">Toate</a></li>
                                <?php
                                    $categories = mysqli_query($con, "SELECT * FROM `articles_categories`");

                                    while($category = mysqli_fetch_assoc($categories)) {
                                        echo '<li class="nav-item bigger-text"><a class="nav-link" href="#" data-filter=".' . strtolower(str_replace(' ', '_', $category['name'])) . '">' . $category['name'] . '</a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h1 class="display-3 fw-bold">Articole</h1>
                <h3 class="fw-normal text-muted mb-3">Subtitlu</h3>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
        <div class="row justify-content-center articles">
            <?php
                $articles = mysqli_query($con, "SELECT * FROM `articles` ORDER BY `created_at` DESC");

                while($article = mysqli_fetch_assoc($articles)) {
                    $article_categories = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `articles_categories` WHERE `id` = '" . $article['category_id'] . "'"));

                    echo '<div class="card m-3 article ' . strtolower(str_replace(' ', '_', $article_categories['name'])) . '" style="width:25.4rem;">';
                    echo ' <img src="/uploads/' . $article['image'] . '" class="card-img-top" alt="...">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $article['title'] . '</h5>';
                    echo '<p class="card-text">' . substr_replace($article['content'], "...", 200) . '</p>';
                    echo '<a href="/articole/articol.php?id=' . $article['id'] . '" class="btn btn-primary stretched-link">Citeste</a>';
                    echo '</div>';
                    echo '<p class="float-end">Numar de vizualizari: ' . $article['views'] . '</p>';
                    if ($article['ratings_count'] > 0) {
                        echo '<p class="float-end">Nota: ' . $article['ratings_total'] / $article['ratings_count'] . '</p>';
                    } else {
                        echo '<p class="float-end">Nu exista recenzii.</p>';
                    }

                    echo '</div>';
                }

            ?>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
<script src="/assets/js/isotope.min.js"></script>
<script src="/assets/js/equal_height_fit-rows.min.js"></script>
<script src="/assets/js/articole.js"></script>
</body>
</html>

