<?php
// patient/dashboard.php

// 1) Load config (defines BASE_URL, opens $conn, starts session)
require_once __DIR__ . '/../includes/config.php';
// 2) Load authentication helpers (defines isLoggedIn())
require_once __DIR__ . '/../includes/auth.php';
// 3) Load your header (HTML <head>, nav, etc.)
require_once __DIR__ . '/../includes/header.php';

// Only allow logged-in patients
if (!isLoggedIn() || $_SESSION['user_role'] !== 'patient') {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Patient Dashboard</h1>
        <!-- Logout button -->
        <a href="<?php echo BASE_URL; ?>/auth/logout.php" class="btn btn-sm btn-danger">
            Logout
        </a>

    </div>

    <!-- Patient dashboard content -->
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="<?php echo BASE_URL; ?>/appointments/create.php">Set Appointment</a>
        </li>
        <li class="list-group-item">
            <a href="<?php echo BASE_URL; ?>/patient/view_profile.php">
                View Personal Info &amp; Medical History
            </a>
        </li>
    </ul>
</div>

<?php
// 4) Load your footer (closing </body>, etc.)
require_once __DIR__ . '/../includes/footer.php';
