<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['deleteId'])) {
    $delete_id = $_GET['deleteId'];

    mysqli_query($con, "DELETE FROM `image_gallery` WHERE id=$delete_id");
    header('location: /admin/imagini');
    die;
}

$imagini = mysqli_query($con, "SELECT * FROM `image_gallery` ORDER BY `created_at` DESC");
?>

<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
    <link href="/assets/css/galerie.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
<main class="d-flex">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <h2>Imagini</h2>
        <div class="card text-bg-primary mb-3 mt-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Imagini</h5>
                <p class="card-text"><?php echo mysqli_num_rows($imagini); ?></p>
            </div>
        </div>

        <form method="get" action="/admin/imagini/index.php">
            <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <label for="category_filter" class="form-label">Categorie</label>
                </div>
                <div class="col-auto">
                    <select id="category_filter" class="form-select" name="category_filter">
                        <option value="">-- Toate --</option>
                        <?php
                        $categories = mysqli_query($con, "SELECT DISTINCT `category` FROM `image_gallery` ORDER BY `category` ASC");

                        while ($cat = mysqli_fetch_assoc($categories)) {
                            $selected = (isset($_GET['category_filter']) && $_GET['category_filter'] === $cat['category']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($cat['category']) . '" ' . $selected . '>' . htmlspecialchars(ucfirst($cat['category'])) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrează</button>
                </div>
                <?php if (isset($_GET['category_filter']) && !empty($_GET['category_filter'])) { ?>
                    <div class="col-auto">
                        <a href="/admin/imagini/index.php" class="btn btn-danger">Resetează</a>
                    </div>
                <?php } ?>
            </div>
        </form>

        <div class="d-flex justify-content-end my-3">
            <a class="btn btn-primary" href="/admin/imagini/adaugare_imagine.php"><i class="fa-solid fa-add"></i> Adauga</a>
        </div>

        <div class="row galerie">
            <?php
            if (isset($_GET['category_filter']) && !empty($_GET['category_filter'])) {
                $category = mysqli_real_escape_string($con, $_GET['category_filter']);
                $query = mysqli_query($con, "SELECT * FROM image_gallery WHERE category = '$category' ORDER BY created_at DESC");
            } else {
                $query = mysqli_query($con, "SELECT * FROM image_gallery ORDER BY created_at DESC");
            }

            while ($img = mysqli_fetch_assoc($query)) {
                $categoryClass = strtolower(str_replace(' ', '_', $img['category']));

                echo '<div class="col-12 col-sm-6 col-md-3 mb-4 grid-item ' . $categoryClass . 'h-100">';
                echo '  <div class="card h-100 border border-light-subtle shadow-lg overflow-hidden">';

                echo '    <div class="position-relative img-container">';
                echo '      <img src="/uploads_gallery/' . htmlspecialchars($img['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($img['title']) . '">';
                echo '      <div class="image-overlay">';
                echo '        <div class="p-3">';
                echo '          <h5 class="card-title text-white fs-5">' . htmlspecialchars($img['title']) . '</h5>';
                echo '          <p class="card-text text-white mb-0">' . htmlspecialchars($img['description']) . '</p>';
                echo '        </div>';
                echo '      </div>';
                echo '    </div>';

                echo '    <div class="card-footer bg-dark d-flex justify-content-between align-items-center">';
                echo '      <div class="d-flex gap-2">';
                echo '        <span class="badge bg-success px-3 py-2 d-flex align-items-center"><i class="fa-solid fa-thumbs-up me-1"></i> ' . $img['likes'] . '</span>';
                echo '        <span class="badge bg-danger px-3 py-2 d-flex align-items-center"><i class="fa-solid fa-thumbs-down me-1"></i> ' . $img['dislikes'] . '</span>';
                echo '      </div>';
                echo '      <a href="?deleteId=' . $img['id'] . '" class="btn btn-outline-light btn-sm d-flex align-items-center deleteImage">';
                echo '        <i class="fa-solid fa-trash me-1"></i> Șterge';
                echo '      </a>';
                echo '    </div>';


                echo '  </div>';
                echo '</div>';
            }
            ?>
            <div class="container mt-4">
                <div id="chart_imagini" style="height: 400px;"></div>
            </div>
        </div>
    </div>

</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
<script src="/admin/assets/js/imagini.js"></script>
<script src="/assets/js/isotope.min.js"></script>
<script src="/assets/js/equal_height_fit-rows.min.js"></script>
</body>
</html>