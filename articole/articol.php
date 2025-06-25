<?php
    session_name('audit_user');
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    if (isset($_GET['id'])) {
        $article = mysqli_query($con, "SELECT * FROM `articles` WHERE `id` = '" . $_GET['id'] . "'");
        $article = mysqli_fetch_assoc($article);

        if (isset($_POST['adaugaComentariu'])) {
            $comment = $_POST['comment'];
            mysqli_query($con, "INSERT INTO `articles_comments` ( `user_id`, `article_id`, `content`) VALUES ('" . $_SESSION['audit_logged_in_user_id'] . "', '" . $_GET['id'] . "', '" . $comment . "')");
            header('Location: /articole/articol.php?id=' . $_GET['id']);
            die;
        }

        if (isset($_POST['adaugaRecenzie'])) {
            $rating = $_POST['rating'];
            mysqli_query($con, "UPDATE `articles` SET `ratings_count` = '" . $article['ratings_count'] + 1 . "', `ratings_total` = '" . $article['ratings_total'] + $rating . "' WHERE `id` = '" . $article['id'] . "'");
            header('Location: /articole/articol.php?id=' . $_GET['id']);
            die;
        }

        mysqli_query($con, "UPDATE `articles` SET `views` = '" . $article['views'] + 1 . "' WHERE `id` = '" . $article['id'] . "'");
    } else {
        header('Location /articole');
        die;
    }
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
    <div class="container">
        <div class="position-relative mt-5 mb-3 rounded-3 overflow-hidden text-center bg-body-tertiary align-content-center article-image" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/uploads/<?php echo $article['image'] ?>');">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h1 class="display-3 fw-bold text-white"><?php echo $article['title'] ?></h1>
                <h3 class="fw-normal mb-3 text-white"><?php echo $article['subtitle'] ?></h3>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?php
                            $postedBy = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '" . $article['user_id'] . "'");
                            $postedBy = mysqli_fetch_assoc($postedBy);
                            echo '<span>Postat de ' . $postedBy['firstName'] . ' ' . $postedBy['lastName'] . '</span> ';
                            if ($postedBy['is_admin'] == 1) {
                                echo '<span class="badge bg-danger">Admin</span> la ' . $article['created_at'];
                            }
                            echo '<span class="float-end"><i class="fa-solid fa-eye"></i> ' . $article['views'] . '</span> ';
                        ?>
                    </div>
                    <div class="card-body">
                        <?php echo $article['content'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Recenzii
                    </div>
                    <div class="card-body">
                            <?php
                                if ($article['ratings_count'] > 0) {
                                    echo '<h3>Recenzii curente: ' . $article['ratings_total'] / $article['ratings_count'] . ' / 5 ' . '(' . $article['ratings_count'] . ' recenzii)</h3>';
                                } else {
                                    echo '<h5>Nu exista recenzii.</h5>';
                                }
                            ?>
                        <form method="post" action="/articole/articol.php?id=<?php echo $article['id'] ?>">
                            <select class="form-select w-25" name="rating" id="rating" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <button class="btn btn-primary mt-3" type="submit" name="adaugaRecenzie">Adauga recenzie</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                       Comentarii
                    </div>
                    <div class="card-body">
                        <?php
                            $comentarii = mysqli_query($con, "SELECT * FROM `articles_comments` WHERE `article_id` = '" . $article['id'] . "' ORDER BY `created_at` DESC");
                            if (mysqli_num_rows($comentarii) > 0) {
                                while ($comentariu = mysqli_fetch_assoc($comentarii)) {
                                    $utilizator = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '" . $comentariu['user_id'] . "'"));
                                    echo '
                                        <div class="row justify-content-center mb-4">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                       Adaugat de <span class="badge bg-primary">' . $utilizator['firstName'] . ' ' . $utilizator['lastName'] . '</span> la ' . $comentariu['created_at'] . '
                                                    </div>
                                                    <div class="card-body">
                                                        ' . $comentariu['content'] . '
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                            } else {
                                echo '<p>Nu sunt comentarii pentru acest articol.</p>';
                            }
                        ?>
                        <h3 class="mt-3">Adauga comentariu </h3>
                        <?php
                            if (isset($_SESSION['audit_logged_in'])) {?>
                            <form method="post" action="/articole/articol.php?id=<?php echo $article['id'] ?>">
                                <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
                                <button class="btn btn-primary mt-3 float-end" type="submit" name="adaugaComentariu"><i class="fa-solid fa-comment"></i> Comenteaza</button>
                            </form>
                        <?php } else {?>
                            <p class="mt-3">Pentru a adauga un comentariu trebuie sa te loghezi sau sa te inregistrezi.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
</body>
</html>

