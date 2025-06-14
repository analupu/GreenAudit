<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_POST['id'], $_POST['action'])) {
    $id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'like') {
        mysqli_query($con, "UPDATE image_gallery SET likes = likes + 1 WHERE id = $id");
    } elseif ($action === 'dislike') {
        mysqli_query($con, "UPDATE image_gallery SET dislikes = dislikes + 1 WHERE id = $id");
    }

    // trimitem datele inapoi
    $result = mysqli_query($con, "SELECT likes, dislikes FROM image_gallery WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
}
?>
