<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    <link href="/assets/css/galerie.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<main class="container mt-5">
    <div class="card">
        <div class="card-body">
    <div class="position-relative overflow-hidden text-center bg-body-tertiary rounded-3" style="background-image: url('/images/nature_backgound.jpg')">
        <div class="col-md-12 d-flex align-items-center justify-content-center" style="height: 400px;">
            <h1 class="display-3 fw-bold text-white">Imagini</h1>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
    <nav class="navbar navbar-expand-md bg-light w-100 border border-3 rounded-3 my-3" data-bs-theme="light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                <div class="offcanvas-body text-center">
                    <ul class="navbar-nav galerie-categories-buttons mx-auto flex-wrap flex-row justify-content-center">
                        <li class="nav-item bigger-text"><a class="btn btn-outline-secondary active" href="#" data-filter="*">Toate</a></li>
                        <?php
                        $categoryQuery = mysqli_query($con, "SELECT DISTINCT category FROM image_gallery");
                        $categories = [];
                        while ($row = mysqli_fetch_assoc($categoryQuery)) {
                            $key = $row['category'];
                            $label = ucfirst($key);
                            $categories[$key] = $label;
                            $className = '.' . strtolower(str_replace(' ', '_', $key));
                            echo '<li class="nav-item bigger-text"><a class="btn btn-outline-secondary" href="#" data-filter="' . $className . '">' . $label . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="row galerie">
        <?php
        $query = mysqli_query($con, "SELECT * FROM image_gallery ORDER BY created_at DESC");
        while ($img = mysqli_fetch_assoc($query)) {
            $categoryClass = strtolower(str_replace(' ', '_', trim($img['category'])));

            echo '<div class="col-12 col-sm-6 col-md-4 mb-4 grid-item ' . $categoryClass . '">';
            echo '  <div class="card h-100 border border-light-subtle shadow-lg overflow-hidden">';

            echo '    <div class="position-relative img-container h-100">';
            echo '      <div class="zoom-wrapper">';
            echo '        <img src="/uploads_gallery/' . htmlspecialchars($img['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($img['title']) . '">';
            echo '      </div>';
            echo '      <div class="image-overlay">';
            echo '        <div class="p-3">';
            echo '          <h5 class="card-title text-white fs-5">' . htmlspecialchars($img['title']) . '</h5>';
            echo '          <p class="card-text text-white mb-0">' . htmlspecialchars($img['description']) . '</p>';
            echo '        </div>';
            echo '      </div>';
            echo '    </div>';

            echo '<div class="card-footer bg-dark text-center">';
            echo '  <button class="btn btn-outline-success me-2 btn-like" data-id="' . $img['id'] . '">👍 Like <span class="like-count">' . $img['likes'] . '</span></button>';
            echo '  <button class="btn btn-outline-danger btn-dislike" data-id="' . $img['id'] . '">👎 Dislike <span class="dislike-count">' . $img['dislikes'] . '</span></button>';
            echo '</div>';


            echo '  </div>';
            echo '</div>';
        }
        ?>
    </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
<script src="/assets/js/galerie.js"></script>
<script src="/assets/js/isotope.min.js"></script>
<script src="/assets/js/equal_height_fit-rows.min.js"></script>
</body>
</html>