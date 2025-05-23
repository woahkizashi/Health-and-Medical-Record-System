<?php
$page_title = 'Login';
require_once '../includes/header.php';

// Initialize Auth class
require_once '../includes/auth.php';
$auth = new Auth();

// Check if logged in
if(isLoggedIn()) {
    redirect('index.php');
}

// Process form
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize POST data
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
    $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => ''
    ];
    
    // Validate email
    if(empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
    }
    
    // Validate password
    if(empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
    }
    
    // Check for errors
    if(empty($data['email_err']) && empty($data['password_err'])) {
        // Attempt login
        $loggedInUser = $auth->login($data['email'], $data['password']);
        
        if($loggedInUser) {
            // Create session
            $_SESSION['user_id'] = $loggedInUser->id;
            $_SESSION['user_email'] = $loggedInUser->email;
            $_SESSION['user_name'] = $loggedInUser->name;
            $_SESSION['user_role'] = $loggedInUser->role;
            
            // Redirect to dashboard
            if($loggedInUser->role == 'admin') {
                redirect('admin/dashboard.php');
            } elseif($loggedInUser->role == 'staff') {
                redirect('staff/dashboard.php');
            } else {
                redirect('patient/dashboard.php');
            }
        } else {
            flash('login_error', 'Invalid email or password', 'alert alert-danger');
        }
    }
}
?>

<div class="login-form">
    <h2>Login</h2>
    <?php flash('login_error'); ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?? ''; ?>">
            <span class="invalid-feedback"><?php echo $data['email_err'] ?? ''; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err'] ?? ''; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-primary">
        </div>
        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/auth/register.php">Register here</a></p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>