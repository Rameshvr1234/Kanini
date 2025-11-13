<?php
require_once 'config.php';
requireLogin();

$page_title = 'Profile';
$success = '';
$error = '';

$user_id = $_SESSION['admin_id'];

// Get user details
$user_query = "SELECT * FROM admin_users WHERE id=$user_id";
$user = $conn->query($user_query)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Update basic info
    $update = "UPDATE admin_users SET full_name='$full_name', email='$email' WHERE id=$user_id";

    // Change password if provided
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $error = 'Please enter current password';
        } elseif (!password_verify($current_password, $user['password'])) {
            $error = 'Current password is incorrect';
        } elseif ($new_password !== $confirm_password) {
            $error = 'New passwords do not match';
        } elseif (strlen($new_password) < 6) {
            $error = 'Password must be at least 6 characters';
        } else {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update = "UPDATE admin_users SET full_name='$full_name', email='$email', password='$hashed' WHERE id=$user_id";
        }
    }

    if (empty($error)) {
        if ($conn->query($update)) {
            $success = 'Profile updated successfully!';
            $user = $conn->query($user_query)->fetch_assoc();
            $_SESSION['admin_name'] = $full_name;
        } else {
            $error = 'Error updating profile';
        }
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Profile Settings</h1>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                                    <small class="text-muted">Username cannot be changed</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <hr>
                                <h6 class="mb-3">Change Password</h6>
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" placeholder="Leave blank to keep current password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="Minimum 6 characters">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Account Info</div>
                        <div class="card-body">
                            <p><strong>Member Since:</strong><br><?php echo date('d M, Y', strtotime($user['created_at'])); ?></p>
                            <p><strong>Last Login:</strong><br><?php echo $user['last_login'] ? date('d M, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
