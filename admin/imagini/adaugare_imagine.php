<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['editId'])) {
    $imagine = mysqli_query($con, "SELECT * FROM `image_gallery` WHERE `id` = '" . $_GET['editId'] . "'");
    $imagine = mysqli_fetch_assoc($imagine);
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    if ($_FILES['image']['size'] > 0) {
        $target_dir =  $_SERVER['DOCUMENT_ROOT'] . "/uploads_gallery/";
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $upload_errors = '';
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            $upload_errors .= "Fișierul nu este o imagine validă.<br />";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 5000000) {
            $upload_errors .= "Imaginea este prea mare (maxim 5MB).<br />";
            $uploadOk = 0;
        }

        if(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $upload_errors .= "Format invalid. Sunt acceptate doar jpg, jpeg, png, gif.<br />";
            $uploadOk = 0;
        }

        if ($uploadOk && !move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $upload_errors .= "A apărut o eroare la upload.<br />";
            $uploadOk = 0;
        }
    }

    if (!isset($_GET['editId'])) {
        if ($uploadOk) {
            mysqli_query($con, "INSERT INTO `image_gallery` (`title`, `description`, `category`, `image_url`) VALUES ('$title', '$description', '$category', '$file_name')");
            header('Location: /admin/imagini');
            die;
        }
    } else {
        if ($_FILES['image']['size'] > 0 && $uploadOk) {
            mysqli_query($con, "UPDATE `image_gallery` SET `title` = '$title', `description` = '$description', `category` = '$category', `image_url` = '$file_name' WHERE `id` = '" . $imagine['id'] . "'");
            header('Location: /admin/imagini');
            die;
        } else {
            mysqli_query($con, "UPDATE `image_gallery` SET `title` = '$title', `description` = '$description', `category` = '$category' WHERE `id` = '" . $imagine['id'] . "'");
            header('Location: /admin/imagini');
            die;
        }
    }
}
?>

<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
<main class="d-flex my-5">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <h1><?php echo empty($imagine) ? 'Adaugă imagine' : 'Editează imagine'; ?></h1>
                            <hr />
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingTitle" placeholder="Titlu" name="title" required value="<?php echo $imagine['title'] ?? ''; ?>" />
                                <label for="floatingTitle">Titlu</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingDesc" placeholder="Descriere" name="description" required value="<?php echo $imagine['description'] ?? ''; ?>" />
                                <label for="floatingDesc">Descriere</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingCategory" placeholder="Categorie" name="category" required value="<?php echo $imagine['category'] ?? ''; ?>" />
                                <label for="floatingCategory">Categorie</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="image" placeholder="Imagine" name="image" <?php if (empty($imagine)) echo 'required'; ?> />
                                <label for="image">Imagine</label>
                            </div>

                            <?php
                            if (isset($_POST['submit']) && !empty($upload_errors)) {
                                echo '<div class="alert alert-danger my-4">' . $upload_errors . '</div>';
                            }

                            if (!empty($imagine) && isset($imagine['image_url'])) {
                                echo '<p>Imagine curentă:</p>';
                                echo '<img src="/uploads_gallery/' . $imagine['image_url'] . '" class="img-fluid mb-3" />';
                            }
                            ?>

                            <button class="btn btn-primary w-100 py-2" type="submit" name="submit">
                                <?php echo empty($imagine) ? '<i class="fa-solid fa-add"></i> Adaugă' : '<i class="fa-solid fa-pen"></i> Editează'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>
