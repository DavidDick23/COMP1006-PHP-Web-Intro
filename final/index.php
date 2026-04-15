<?php
//=========================================================================
// #region Auth Guard
//-------------------------------------------------------------------------
//protect this page, only logged in users may view it.
require_once "./includes/auth.php"; 
// redirects to login.php if not logged in
requireLogin();  
//-------------------------------------------------------------------------
// #endregion Auth Guard
//=========================================================================
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Meta Data, Tab Title, CSS Links -->
    <?php require "./includes/head.php" ?>

    <!-- Visible Content -->
    <body>
        <!-- Container Class For CSS Styling -->
        <div class="container">
            <!-- Section: Header -->
            <?php include "./includes/header.php" ?>
            
            <!-- Display Gallery (only files are displayed, ran out of time due to debuggin) -->
            <?php include "./read.php" ?>

            <!-- Section: Footer -->
            <?php include "./includes/footer.php" ?>
        </div>
        
    </body>
</html>