<?php
    session_start();

    if (!isset($_SESSION['audit_logged_in'])) {
        header('Location: ../login.php');
        die;
    } else {
        $is_logged = true;
    }
?>