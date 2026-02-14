<?php
require "includes/connect.php";

// #region Process Form Data 
// ---------------------------------------------------------------------- //
// Grab form data (no validation or sanitization for this lab)
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];

//  1. Write an INSERT statement with named placeholders
$sql = "INSERT INTO subscribers (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";

//  2. Prepare the statement
$stmt = $pdo->prepare($sql);

//  3. Execute the statement with an array of values (binds values as well)
$stmt->execute(["first_name"=>$firstName, "last_name"=>$lastName, "email"=>$email]);
// ---------------------------------------------------------------------- //
#endregion Process Form Data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- Display confirmation message -->
        <p>Thanks, <?php echo htmlspecialchars($firstName)?>! You have been added to our mailing list.</p>

        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>

</html>