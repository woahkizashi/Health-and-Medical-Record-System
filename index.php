<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if (isLoggedIn()) {
    if ($_SESSION['user_role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } elseif ($_SESSION['user_role'] == 'staff') {
        header("Location: staff/dashboard.php");
    } else {
        header("Location: patient/dashboard.php");
    }
} else {
    header("Location: auth/login.php");
}

require_once 'includes/footer.php';
?>