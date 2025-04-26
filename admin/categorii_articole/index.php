<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['deleteId'])) {
    $delete_id = $_GET['deleteId'];

    mysqli_query($con, "DELETE FROM articles_categories WHERE id=$delete_id");
    header('location: /admin/categorii_articole');
    die;
}

$categorii_articole = mysqli_query($con, "SELECT * FROM `articles_categories` ORDER BY `created_at` DESC");

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
            <div class="col-md-12">
                <h2>Categorii articole</h2>
                <div class="card text-bg-primary mt-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Categorii articole</h5>
                        <p class="card-text"><?php echo mysqli_num_rows($categorii_articole); ?></p>
                    </div>
                </div>
                <a class="btn btn-primary float-end" href="/admin/categorii_articole/creare_editare.php"><i
                        class="fa-solid fa-add"></i> Adauga</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nume</th>
                        <th>Actiune</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($categorie_articol = mysqli_fetch_assoc($categorii_articole)) {
                        echo '<tr class="align-middle">';
                        echo '<td>' . $categorie_articol['id'] . '</td>';
                        echo '<td>' . $categorie_articol['name'] . '</td>';
                        echo '<td style="width: 225px;">
                                <a class="btn btn-primary me-3" href="/admin/categorii_articole/creare_editare.php?editId=' . $categorie_articol['id'] . '"><i
                        class="fa-solid fa-pen"></i> Editare</a>
                                <a class="btn btn-danger py-2 deleteUser" href="/admin/categorii_articole/index.php?deleteId=' . $categorie_articol['id'] . '"><i
                        class="fa-solid fa-trash"></i> Sterge</a>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>


