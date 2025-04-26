<?php
    session_name('audit_admin');
    session_start();

    if (!isset($_SESSION['audit_admin_logged_in'])) {
        header('Location: /admin/login.php');
        die;
    } else {
        $is_logged = true;
    }
?>