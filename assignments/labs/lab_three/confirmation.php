<!DOCTYPE html>
<html lang="en">
    <!-- Head -->
    <?php require "includes/head.php" ?>

    <!-- Visible Content -->
    <body>
        <!-- Header -->
         <?php require "includes/header.php" ?>
        
        <!-- Main Content -->
        <main>
            <!-- Validate Form Data -->
            
            <?php
            //Form Vairables & Sanitization
            $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS); 
            $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS); 
            $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $items = $_POST['items'] ?? []; 
            $errors = []; 
            
            //Validate Customer Info
            if(empty($firstName)) { $errors[] = "First Name Is Required";}
            if(empty($lastName)) { $errors[] = "Last Name Is Required";}
            if(empty($address)) { $errors[] = "First Name Is Required";}
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
            { 
                $errors[] = "A Valid Address Is Required";
            }

            //Validate Items
            $itemsOrdered = []; //variable array for items

            //loop through all items
            foreach($items as $item => $quantity) 
            {
                if(filter_var($quantity, FILTER_VALIDATE_INT) !== false && $quantity > 0 ) 
                {
                    $itemsOrdered[$item] = $quantity; 
                }
            }   
            if(count($itemsOrdered) === 0) //if there aren't any items set error message
            {
                $errors[] = "Please order at least one item"; 
            }

            //display errors and exit loop
            if(!empty($errors)) 
            {
                foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?> </li>
            <?php 
                endforeach; 
                exit; 
            }
            ?>

            <!-- Confirmaion Message -->
            <?php echo "<h2> Thank you for order " . $firstName . "</h2>"; ?>

            <h3> Items Ordered </h3>
            <ul>
            <!-- loop through items and display quantities -->
            <?php foreach($items as $item => $quantity): ?>
                <li>
                    <?php echo $item ?> : <?php echo $quantity ?> 
                </li>
            <?php endforeach; ?>
            </ul>

            <!-- Cannot Email Customer At The Moment (Copied From Week 4 Excercise) -->
            <?php //mail($to, $subject, $message); ?> 
        </main>

        <!-- Footer -->
        <?php require "includes/footer.php" ?>
    </body>
</html>