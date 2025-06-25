<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['deleteId'])) {
    $delete_id = $_GET['deleteId'];

    mysqli_query($con, "DELETE FROM `articles` WHERE id=$delete_id");
    header('location: /admin/articole');
    die;
}

$articole = mysqli_query($con, "SELECT * FROM `articles` ORDER BY `created_at` DESC");

?>

<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
    <link href="/admin/assets/css/cards.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
<main class="d-flex mt-5">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h2>Articole</h2>
                <hr />
                <div class="row">
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
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <a class="btn btn-primary mb-3" href="/admin/articole/creare_editare.php"><i
                        class="fa-solid fa-add"></i> Adauga</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nume</th>
                        <th>Categorie</th>
                        <th>Data</th>
                        <th>Vizualizari</th>
                        <th style="width: 7%;">Actiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($articol = mysqli_fetch_assoc($articole)) {
                        echo '<tr class="align-middle">';
                        echo '<td>' . $articol['id'] . '</td>';
                        echo '<td>' . $articol['title'] . '</td>';

                        $categorie_articol = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `articles_categories` WHERE `id` = '" . $articol['category_id'] . "'"));
                        echo '<td>' . $categorie_articol['name'] . '</td>';
                        echo '<td>' . $articol['created_at'] . '</td>';
                        echo '<td>' . $articol['views'] . '</td>';
                        echo '<td style="width: 225px;">
                                <a class="btn btn-primary me-3" href="/admin/articole/creare_editare.php?editId=' . $articol['id'] . '"><i
                        class="fa-solid fa-pen"></i></a>
                                <a class="btn btn-danger py-2 deleteUser" href="/admin/articole/index.php?deleteId=' . $articol['id'] . '"><i
                        class="fa-solid fa-trash"></i></a>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>


