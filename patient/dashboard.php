<?php
// patient/dashboard.php

require_once '../includes/config.php';
require_once '../includes/header.php';

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
        <a href="<?php echo BASE_URL; ?>/includes/logout.php" class="btn btn-sm btn-danger">
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
            <a href="<?php echo BASE_URL; ?>/patient/view_profile.php">View Personal Info & Medical History</a>
        </li>
    </ul>
</div>

<?php
require_once '../includes/footer.php';
