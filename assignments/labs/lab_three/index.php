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
            <!-- Order Form -->
            <form action="confirmation.php" method="post">
                <!-- Customer Information -->
                <fieldset>
                    <!-- Title -->
                    <legend>Customer Information</legend>

                    <!-- Fields -->
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" required>
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" required>
                    <label for="phone">Phone number</label>
                    <input type="text" id="phone" name="phone" placeholder="555-555-5555" required>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </fieldset>

                <!-- Order Details -->
                <fieldset>
                    <!-- Title -->
                    <legend>Order Details</legend>

                    <!-- Helper Text -->
                    <p>Enter a quantity for each item.</p>

                    <!-- Table -->
                    <table border="1" cellpadding="8" cellspacing="0">
                        <!-- Table Head -->
                        <thead>
                            <tr>
                                <th scope="col">Baked Treat</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        
                        <!-- Table Body -->
                        <tbody>
                            <!-- Item 1 -->
                            <tr>
                                <th scope="row">Generic One</th>
                                <td>
                                    <label for="generic_one" class="visually-hidden">Generic One quantity</label>
                                    <input type="number" id="generic_one" name="items[generic_one]" min="0" max="20" value="0">
                                </td>
                            </tr>

                            <!-- Item 2 -->
                            <tr>
                                <th scope="row">Generic Two</th>
                                <td>
                                    <label for="generic_two" class="visually-hidden">Generic Two quantity</label>
                                    <input type="number" id="generic_two" name="items[generic_two]" min="0" max="20" value="0">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </fieldset>

                <!-- Submit Button -->
                <p><button type="submit">Place Order</button></p>
            </form>
        </main>

        <!-- Footer -->
        <?php require "includes/footer.php" ?>
    </body>
</html>