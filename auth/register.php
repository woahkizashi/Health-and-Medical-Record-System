<?php
$page_title = 'Register';
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
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'role' => 'patient', // Default role
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
    ];
    
    // Validate name
    if(empty($data['name'])) {
        $data['name_err'] = 'Please enter name';
    }
    
    // Validate email
    if(empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
    } else {
        if($auth->findUserByEmail($data['email'])) {
            $data['email_err'] = 'Email is already taken';
        }
    }
    
    // Validate password
    if(empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
    } elseif(strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
    }
    
    // Validate confirm password
    if(empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm password';
    } else {
        if($data['password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Passwords do not match';
        }
    }
    
    // Check for errors
    if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Register user
        if($auth->register($data)) {
            flash('register_success', 'You are registered and can log in');
            redirect('auth/login.php');
        } else {
            die('Something went wrong');
        }
    }
}
?>

<div class="register-form">
    <h2>Register</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name'] ?? ''; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err'] ?? ''; ?></span>
        </div>
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
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" value="Register" class="btn btn-primary">
        </div>
        <p>Already have an account? <a href="<?php echo BASE_URL; ?>/auth/login.php">Login here</a></p>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>