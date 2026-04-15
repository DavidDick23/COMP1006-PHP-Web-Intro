<?php
//=========================================================================
// #region Auth Guard and Connection
//-------------------------------------------------------------------------
require "./includes/auth.php";    // session & auth helpers
requireLogin();                   // redirect to login.php if not logged in
require "./includes/connect.php"; // $pdo

$user    = getCurrentUser();
$errors  = [];
$success = "";
//-------------------------------------------------------------------------
// #endregion Auth Guard and Connection
//=========================================================================

//=========================================================================
// #region Handle POST
//-------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $action = $_POST['action'] ?? '';

    //=========================================================================
    // #region Update Profile
    //-------------------------------------------------------------------------
    if ($action === 'update')
    {
        //Sanitize Input
        $newUsername = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $newEmail    = trim(filter_input(INPUT_POST, 'email',    FILTER_SANITIZE_EMAIL));
        $newPassword = $_POST['new_password']         ?? '';
        $confirmPass = $_POST['new_password_confirm'] ?? '';
        $currentPass = $_POST['current_password']     ?? '';

        //Validate Username
        if (empty($newUsername))
            $errors[] = "Username is required.";
        elseif (strlen($newUsername) < 3 || strlen($newUsername) > 50)
            $errors[] = "Username must be between 3 and 50 characters.";

        //Validate Email
        if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL))
            $errors[] = "A valid email address is required.";

        //Verify Current Password
        $sql  = "SELECT password FROM users WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $user['id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || !password_verify($currentPass, $row['password']))
            $errors[] = "Current password is incorrect.";

        //Optional: New Password
        $newPasswordHash = $row['password'] ?? null; // keep existing if not changing
        if (!empty($newPassword))
        {
            if (strlen($newPassword) < 8)
                $errors[] = "New password must be at least 8 characters.";
            elseif ($newPassword !== $confirmPass)
                $errors[] = "New passwords do not match.";
            else
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        //Perform Update
        if (empty($errors))
        {
            $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':email',    $newEmail);
            $stmt->bindParam(':password', $newPasswordHash);
            $stmt->bindParam(':id',       $user['id']);
            $stmt->execute();

            // Update session to reflect new info
            $_SESSION['username'] = $newUsername;
            $_SESSION['email']    = $newEmail;
            $user = getCurrentUser();

            $success = "Profile updated successfully.";
        }
    }
    //-------------------------------------------------------------------------
    // #endregion Update Profile
    //=========================================================================

    //=========================================================================
    // #region Delete Account
    //-------------------------------------------------------------------------
    elseif ($action === 'delete')
    {
        $confirmPass = $_POST['delete_password'] ?? '';

        //Verify Password Before Deleting
        $sql  = "SELECT password FROM users WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $user['id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || !password_verify($confirmPass, $row['password']))
        {
            $errors[] = "Password is incorrect. Account not deleted.";
        }
        else
        {
            // Delete user — CASCADE will also remove their file_uploads rows
            $sql  = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();
            $pdo = null;

            // Destroy session and redirect
            session_destroy();
            header("Location: register.php");
            exit;
        }
    }
    //-------------------------------------------------------------------------
    // #endregion Delete Account
    //=========================================================================

    $pdo = null;
}
//-------------------------------------------------------------------------
// #endregion Handle POST
//=========================================================================
?>
<!DOCTYPE html>
<html lang="en">
<?php require "./includes/head.php"; ?>
<body>
<div class="container">
    <?php include "./includes/header.php"; ?>

    <main class="mt-4" style="max-width:600px;">
        <h2>My Profile</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- ================================================================ -->
        <!-- Update Profile Form -->
        <!-- ================================================================ -->
        <h4 class="mt-4">Update Information</h4>
        <form action="profile.php" method="post">
            <input type="hidden" name="action" value="update">

            <!-- Username -->
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <!-- New Password (optional) -->
            <div class="form-group mb-3">
                <label for="new_password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>

            <!-- Confirm New Password -->
            <div class="form-group mb-3">
                <label for="new_password_confirm" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm">
            </div>

            <!-- Current Password Required to Save -->
            <div class="form-group mb-3">
                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <hr class="my-4">

        <!-- ================================================================ -->
        <!-- Delete Account Form -->
        <!-- ================================================================ -->
        <h4 class="text-danger">Delete Account</h4>
        <p class="text-muted">This will permanently delete your account and all associated data.</p>

        <form action="profile.php" method="post" onsubmit="return confirm('Are you sure? This cannot be undone.');">
            <input type="hidden" name="action" value="delete">

            <div class="form-group mb-3">
                <label for="delete_password" class="form-label">Confirm Your Password</label>
                <input type="password" class="form-control" id="delete_password" name="delete_password" required>
            </div>

            <button type="submit" class="btn btn-danger">Delete My Account</button>
        </form>
    </main>

    <?php include "./includes/footer.php"; ?>
</div>
</body>
</html>
