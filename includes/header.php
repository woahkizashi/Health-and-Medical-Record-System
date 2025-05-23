<?php
session_start();
require_once 'config.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo $page_title ?? 'Welcome'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="<?php echo BASE_URL; ?>/assets/images/plus-big.png" alt="Logo">
                <h1><?php echo SITE_NAME; ?></h1>
            </div>
            <nav>
                <ul>
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <li><a href="<?php echo BASE_URL; ?>/admin/dashboard.php">Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/admin/patients.php">Patients</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/admin/staff.php">Staff</a></li>
                        <?php elseif($_SESSION['user_role'] == 'staff'): ?>
                            <li><a href="<?php echo BASE_URL; ?>/staff/dashboard.php">Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/staff/patients.php">Patients</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/patient/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo BASE_URL; ?>/auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>/auth/login.php">Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/auth/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container"></main>