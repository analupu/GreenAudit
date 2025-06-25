<?php
    session_name('audit_user');
    session_start();

    $is_logged = false;
    if (isset($_SESSION['audit_logged_in'])) {
        $is_logged = true;
    }
?>