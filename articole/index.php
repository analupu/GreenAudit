<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    <link href="/assets/css/articole.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<main class="d-flex">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="position-relative overflow-hidden text-center bg-body-tertiary rounded-3" style="background-image: url('/images/nature_backgound.jpg')";>
                    <div class="col-md-12 d-flex align-items-center justify-content-center" style="height: 400px;">
                        <h1 class="display-3 fw-bold text-white">Articole</h1>
                    </div>
                    <div class="product-device shadow-sm d-none d-md-block"></div>
                    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
                </div>
                <nav class="navbar navbar-expand-md bg-light w-100 border-bottom rounded-3 mt-3 border border-3" data-bs-theme="light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                            <div class="offcanvas-body">
                                <ul class="navbar-nav flex-grow-1 justify-content-between articles-categories-buttons">
                                    <li class="nav-item bigger-text"><a class="btn btn-outline-secondary me-2 active" href="#" data-filter="*">Toate</a></li>
                                    <?php
                                    $categories = mysqli_query($con, "SELECT * FROM `articles_categories`");

                                    while($category = mysqli_fetch_assoc($categories)) {
                                        echo '<li class="nav-item bigger-text"><a class="btn btn-outline-secondary me-2" href="#" data-filter=".' . strtolower(str_replace(' ', '_', $category['name'])) . '">' . $category['name'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="row justify-content-center articles">
                    <?php
                    $articles = mysqli_query($con, "SELECT * FROM `articles` ORDER BY `created_at` DESC");

                    while($article = mysqli_fetch_assoc($articles)) {
                        $article_categories = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `articles_categories` WHERE `id` = '" . $article['category_id'] . "'"));

                        echo '<div class="col-4 mt-3 article ' . strtolower(str_replace(' ', '_', $article_categories['name'])) . '"><div class="card h-100">';
                        echo ' <img src="/uploads/' . $article['image'] . '" class="card-img-top" alt="...">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $article['title'] . '</h5>';
                        echo '<p class="card-text">' . substr_replace($article['content'], "...", 200) . '</p>';
                        echo '</div><div class="card-footer">';
                        echo '<div class="d-flex justify-content-between align-items-center"><p class="m-0"><i class="fa-solid fa-eye"></i> ' . $article['views'] . '</p><a href="/articole/articol.php?id=' . $article['id'] . '" class="btn btn-primary stretched-link">Citeste</a>';
                        if ($article['ratings_count'] > 0) {
                            echo '<p class="m-0">Nota: ' . $article['ratings_total'] / $article['ratings_count'] . '</p>';
                        } else {
                            echo '<p class="m-0">Nu exista recenzii.</p>';
                        }
                        echo '</div></div>';

                        echo '</div></div>';
                    }

                    ?>
                </div>
            </div>
        </div>

    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
<script src="/assets/js/isotope.min.js"></script>
<script src="/assets/js/equal_height_fit-rows.min.js"></script>
<script src="/assets/js/articole.js"></script>
</body>
</html>

