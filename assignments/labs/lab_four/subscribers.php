<?php
require "includes/connect.php";

// #region Retrieve Form Data 
// ---------------------------------------------------------------------- //
//  1. Write a SELECT query to get all subscribers && 2. Add ORDER BY subscribed_at DESC
$sql = "SELECT id, first_name, last_name, email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC";

//  3. Prepare the statement
$stmt = $pdo->prepare($sql);

//  4. Execute the statement
$stmt->execute();

//  5. Fetch all results into $subscribers
$subscribers = []; // placeholder
$subscribers = $stmt->fetchAll();
// ---------------------------------------------------------------------- //
// #endregion Retrieve Form Data
?>

<main class="container mt-4">
  <h1>Subscribers</h1>

  <?php if (count($subscribers) === 0): ?>
    <p>No subscribers yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th> <!-- Added id to select query-->
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Subscribed</th> <!-- Added subscribed_at to select query-->
        </tr>
      </thead>
      <tbody>
        <!-- Loop through $subscribers and output each row -->
        <?php foreach ($subscribers as $subscriber): ?>
        <tr>
            <td><?php echo htmlspecialchars($subscriber["id"]); ?></td>
            <td><?php echo htmlspecialchars($subscriber["first_name"]); ?></td>
            <td><?php echo htmlspecialchars($subscriber["last_name"]); ?></td>
            <td><?php echo htmlspecialchars($subscriber["email"]); ?></td>
            <td><?php echo htmlspecialchars($subscriber["subscribed_at"]); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Subscribe Form</a>
  </p>
</main>