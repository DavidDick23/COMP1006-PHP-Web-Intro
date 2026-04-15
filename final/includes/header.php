<?php
//=========================================================================
// #region Header
//-------------------------------------------------------------------------
//Auth helper is already included by pages that use this header
//We just read session state here to build the nav
$currentUser = getCurrentUser(); // returns null if not logged in
?>
<header class="d-flex justify-content-between align-items-center py-3 border-bottom mb-3">
    <h1 class="site-title h4 mb-0"><a href="index.php" class="text-decoration-none">Task Time Tracker</a></h1>
    <nav>
        <?php if ($currentUser): ?>
            <!-- Hello Message -->
            <span class="me-3 text-muted">Hello, <?= htmlspecialchars($currentUser['username']) ?></span>

            <!-- User Action Buttons -->
            <a href="upload.php"  class="btn btn-sm btn-outline-secondary me-2">Uploads</a>
            <a href="profile.php" class="btn btn-sm btn-outline-secondary me-2">Profile</a>
            <a href="logout.php"  class="btn btn-sm btn-outline-danger">Log Out</a>
            <?php else: ?>

        <?php endif; ?>
    </nav>
</header>
<?php
//-------------------------------------------------------------------------
// #endregion Header
//=========================================================================