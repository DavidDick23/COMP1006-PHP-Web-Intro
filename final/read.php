<?php
require "./includes/connect.php";

//=========================================================================
// #region Fetch User's Uploads
//-------------------------------------------------------------------------
$sql  = "SELECT * FROM file_uploads WHERE user_id = :user_id ORDER BY uploaded_at DESC";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':user_id', $user['user_id']);
$stmt->execute();
$uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pdo = null;
//-------------------------------------------------------------------------
// #endregion Fetch User's Uploads
//=========================================================================
?>
<div class="container">

    <main class="mt-4">
        <!-- Uploads Table -->
        <h4>Your Uploads</h4>
        <?php if (count($uploads) === 0): ?>
            <div class="alert alert-info">You have not uploaded any files yet.</div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Uploaded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($uploads as $upload): ?>
                        <tr>
                            <td><?= htmlspecialchars($upload['original_name']) ?></td>
                            <td><?= htmlspecialchars($upload['file_type']) ?></td>
                            <td><?= round($upload['file_size'] / 1024, 1) ?> KB</td>
                            <td><?= htmlspecialchars($upload['uploaded_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>