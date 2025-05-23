<?php
$page_title = 'Admin Dashboard';
require_once '../includes/header.php';

// Check if user is admin
if($_SESSION['user_role'] != 'admin') {
    redirect('index.php');
}

// Initialize classes
require_once 'classes/Patient.php';
require_once 'classes/Staff.php';

$patient = new Patient();
$staff = new Staff();

// Get counts
$patientCount = count($patient->getPatients());
$staffCount = count($staff->getStaff());
?>

<div class="dashboard">
    <h2>Admin Dashboard</h2>
    <div class="stats">
        <div class="stat-card">
            <h3>Patients</h3>
            <p><?php echo $patientCount; ?></p>
        </div>
        <div class="stat-card">
            <h3>Staff</h3>
            <p><?php echo $staffCount; ?></p>
        </div>
    </div>
    
    <div class="recent-activity">
        <h3>Recent Activity</h3>
        <p>System updates and notifications will appear here.</p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>