<?php
//=========================================================================
// #region Auth Guard and Connection
//-------------------------------------------------------------------------
require "./includes/auth.php";  
require "./includes/connect.php"; 

$errors = [];

//redirect already logged in users away from this page
if (isLoggedIn())
{
    header("Location: index.php");
    exit;
}
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
    $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'] ?? '';
    //-------------------------------------------------------------------------
    // #endregion Sanitize Input
    //=========================================================================

    //=========================================================================
    // #region Validate & Authenticate
    //-------------------------------------------------------------------------
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "A valid email address is required.";

    if (empty($password))
        $errors[] = "Password is required.";

    if (empty($errors))
    {
        //look up the user by email
        $sql  = "SELECT id, username, email, password FROM users WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo  = null;

        //verify password against stored hash
        if ($user && password_verify($password, $user['password']))
        {
            //regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            //store user info in session
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email']    = $user['email'];

            header("Location: index.php");
            exit;
        }
        else
        {
            //generic message, do not reveal which field was wrong
            $errors[] = "Invalid email or password.";
        }
    }
    //-------------------------------------------------------------------------
    // #endregion Validate & Authenticate
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
        <h2>Log In</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Submit/Register Buttons -->
            <button type="submit" class="btn btn-primary">Log In</button>
            <a href="register.php" class="btn btn-link">Create An Account</a>
        </form>
    </main>

    <?php include "./includes/footer.php"; ?>
</div>
</body>
</html>
