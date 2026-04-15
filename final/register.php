<?php
//=========================================================================
// #region Auth Guard and Connection
//-------------------------------------------------------------------------
require "./includes/auth.php";    // session & auth helpers
require "./includes/connect.php"; // $pdo

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
    //=========================================================================
    // #region Sanitize Input
    //-------------------------------------------------------------------------
    $username  = trim(filter_input(INPUT_POST, 'username',  FILTER_SANITIZE_SPECIAL_CHARS));
    $email     = trim(filter_input(INPUT_POST, 'email',     FILTER_SANITIZE_EMAIL));
    $password  = $_POST['password']         ?? '';
    $password2 = $_POST['password_confirm'] ?? '';
    //-------------------------------------------------------------------------
    // #endregion Sanitize Input
    //=========================================================================

    //=========================================================================
    // #region Validate Input
    //-------------------------------------------------------------------------
    if (empty($username))
        $errors[] = "Username is required.";
    elseif (strlen($username) < 3 || strlen($username) > 50)
        $errors[] = "Username must be between 3 and 50 characters.";

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "A valid email address is required.";

    if (empty($password))
        $errors[] = "Password is required.";
    elseif (strlen($password) < 8)
        $errors[] = "Password must be at least 8 characters.";

    if ($password !== $password2)
        $errors[] = "Passwords do not match.";
    //-------------------------------------------------------------------------
    // #endregion Validate Input
    //=========================================================================

    //=========================================================================
    // #region Insert User
    //-------------------------------------------------------------------------
    if (empty($errors))
    {
        //check if username or email already exists
        $checkSql  = "SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email',    $email);
        $checkStmt->execute();

        if ($checkStmt->fetch())
        {
            $errors[] = "That username or email is already registered.";
        }
        else
        {
            //hash the password using bcrypt
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql  = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email',    $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->execute();

            $success = "Account created! <a href='login.php'>Log in now</a>.";
        }
    }

    $pdo = null;
    //-------------------------------------------------------------------------
    // #endregion Insert User
    //=========================================================================
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

    <main class="mt-4" style="max-width:500px;">
        <h2>Register</h2>

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
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="register.php" method="post">

            <!-- Username -->
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="form-group mb-3">
                <label for="password_confirm" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
            <a href="login.php" class="btn btn-link">Already have an account?</a>
        </form>
    </main>

    <?php include "./includes/footer.php"; ?>
</div>
</body>
</html>
