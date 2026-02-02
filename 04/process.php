<!-- Meta Data -->
<?php require "includes/meta.php" ?>

<!-- Visible Content -->
<body>
    <!-- Header -->
    <?php require "includes/header.php" ?>

    <!-- Order Confirmation -->
    <main>
        <!-- STEP1: Accessing Form Data -->
        <?php
        #region Order Variables
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $comments = $_POST['comments'];
        $items = $_POST['items'];
        #endregion
        ?>
        
        <!-- STEP2: Sending Confirmation Via Email -->


        <!-- STEP3: Echo Confirmation Message -->
        <h1>Thanks For Your Order!</h1>
        <h2><center> Order Details: </center></h2> <br>
        <h3><center><?php echo $firstName ?></center></h3>

    </main>

    <!-- Footer -->
    <?php require "includes/footer.php" ?>
</body>

</html>