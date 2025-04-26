<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['editId'])) {
    $categorie_articol = mysqli_query($con, "SELECT * FROM `articles_categories` WHERE `id` = '" . $_GET['editId'] . "'");
    $categorie_articol = mysqli_fetch_assoc($categorie_articol);
}

if (isset($_POST['submit'])) {
    $nume = $_POST['name'];

    if (!isset($_GET['editId'])) {
        mysqli_query($con, "INSERT INTO `articles_categories` (`name`) VALUES ('" . $nume . "')");
        header('Location: /admin/categorii_articole');
        die;
    } else {
        mysqli_query($con, "UPDATE `articles_categories` SET `name` = '" . $nume . "' WHERE `id` = '" . $categorie_articol['id'] . "'");
        header('Location: /admin/categorii_articole');
        die;
    }
}
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
    <link href="/assets/css/sign-in.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
<main class="d-flex">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4">
                <form action="" method="post">
                    <?php if (empty($categorie_articol)) { echo ' <h1>Adauga categorie articol</h1>'; }
                    else { echo '<h1>Editeaza categorie articol</h1>'; }?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="Nume" name="name"
                               required value="<?php if (!empty($categorie_articol)) { echo $categorie_articol['name']; } ?>" />
                        <label for="floatingName">Nume categorie</label>
                    </div>
                    <button class="btn btn-primary w-100 py-2" type="submit" name="submit">
                        <?php if (empty($categorie_articol)) { echo '<i
                            class="fa-solid fa-add"></i> Adauga'; }
                        else { echo '<i
                            class="fa-solid fa-pen"></i> Editeaza'; }?></button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>

