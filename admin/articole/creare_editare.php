<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['editId'])) {
    $articol = mysqli_query($con, "SELECT * FROM `articles` WHERE `id` = '" . $_GET['editId'] . "'");
    $articol = mysqli_fetch_assoc($articol);
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $category = $_POST['category'];


    if ($_FILES['image']['size'] > 0) {
        $target_dir =  $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
        $file_name = basename($_FILES["image"]["name"]) . time();
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION));

        $upload_errors = '';
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $upload_errors .= "Tipul fisierului incorect.<br />";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 5000000) {
            $upload_errors .= "Dimensiune prea mare (max 5MB).<br />";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $upload_errors .= "Extensia fisierului incorecta (fisiere acceptate: jpg, png, jpeg).<br />";
            $uploadOk = 0;
        }

        if ($uploadOk) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $uploadOk = 0;
            }
        }
    }


    if (!isset($_GET['editId'])) {
        mysqli_query($con, "INSERT INTO `articles` (`category_id`, `user_id`, `title`, `subtitle`, `content`, `image`) VALUES ('" . $category . "', '" . $_SESSION['audit_admin_logged_in_user_id'] . "', '" . $title . "', '" . $subtitle . "', '" . $content . "', '" .  $file_name . "')");
        header('Location: /admin/articole');
        die;
    } else {
        if ($_FILES["image"]['size'] > 0 && $uploadOk)  {
            mysqli_query($con, "UPDATE `articles` SET `category_id` = '" . $category . "', `title` = '" . $title . "', `subtitle` = '" . $subtitle . "', `content` = '" . $content . "', `image` = '" . $file_name . "' WHERE `id` = '" . $articol['id'] . "'");
            header('Location: /admin/articole');;
            die;
        }

        if ($_FILES["image"]['size'] == 0) {
            mysqli_query($con, "UPDATE `articles` SET `category_id` = '" . $category . "', `title` = '" . $title . "', `subtitle` = '" . $subtitle . "', `content` = '" . $content . "' WHERE `id` = '" . $articol['id'] . "'");
            header('Location: /admin/articole');;
            die;
        }
    }
}
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
    <link href="/assets/css/sign-in.css" rel="stylesheet">
    <link href="/admin/assets/css/summernote-bs5.min.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
<main class="d-flex">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php if (empty($articol)) { echo ' <h1>Adauga articol</h1>'; }
                    else { echo '<h1>Editeaza articol</h1>'; }?>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="categorie" name="category" required>
                            <?php
                                $categorii = mysqli_query($con, "SELECT * FROM `articles_categories`");

                                while ($categorie = mysqli_fetch_assoc($categorii)) {
                                    echo '<option value="' . $categorie['id'] . '"';
                                    if (!empty($articol) && $articol['category_id'] == $categorie['id']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $categorie['name'] . '</option>';
                                }
                            ?>
                        </select>
                        <label for="categorie">Categorie</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingTitle" placeholder="Titlu" name="title"
                               required value="<?php if (!empty($articol)) { echo $articol['title']; } ?>" />
                        <label for="floatingTitle">Titlu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingSubtitle" placeholder="Subtitlu" name="subtitle"
                               required value="<?php if (!empty($articol)) { echo $articol['subtitle']; } ?>" />
                        <label for="floatingSubtitle">Subtitlu</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea id="content-articol" class="form-control" name="content" required><?php if (!empty($articol)) { echo $articol['content']; } ?></textarea>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="image" placeholder="Image" name="image"
                               <?php if (empty($articol)) { echo 'required'; }  ?> />
                        <label for="image">Imagine</label>
                    </div>
                    <?php
                        if (isset($_POST['submit']) && !empty($upload_errors)) {
                            echo '<div class="alert alert-danger my-4" role="alert">
                                ' . $upload_errors . '</div>';
                        }

                        if (!empty($articol) && isset($articol['image'])) {
                            echo 'Current image: <br />';
                            echo '<img src="/uploads/' . $articol['image'] . '" class="img-fluid mb-3" />';
                        }
                    ?>
                    <button class="btn btn-primary w-100 py-2" type="submit" name="submit">
                        <?php if (empty($articol)) { echo '<i
                            class="fa-solid fa-add"></i> Adauga'; }
                        else { echo '<i
                            class="fa-solid fa-pen"></i> Editeaza'; }?></button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
<script src="/admin/assets/js/summernote-bs5.min.js"></script>
<script src="/admin/assets/js/articole.js"></script>
</body>
</html>

