<!-- Question:
    What's the Problem? 
    - PHP logic + HTML in one file
    - Works, but not scalable
    - Repetition will become a problem

    How can we refactor this code so it’s easier to maintain?
-->
<!-- Answer:
    The solution is in decoupling the HTML from the PHP and making the code modular.I believe there is a much more elegant solution than what I have provided, however, I wasn't sure on the correct approach without looking online for a solution. There is most likely a way to create a function in my "items.php" to completely eleminate the HTML that resides there and then it could be called in "index.php" as needed.

    Something I wish to implement in the first project is creating modular PHP functions that will be reusable. This will help to create a modular system that can be utilized in an HTML framework and eliminate redundancies. 
    
    Another thing to implement is the creation of HTML wrapped in PHP to create a 'node' like system. For example, I have multiple pages on a wesite. Each page has a footer with a lot of links and information. By using include or require I can avoid creating the footer over and over for each page. 
-->

<!DOCTYPE html>
<html>   
    <!-- Visible Content -->
    <body>
        <!-- Header -->
        <head>
            <title>My PHP Page</title>
        </head>
        <!-- Main Content -->
        <main>
            <h1>Welcome</h1>
            <ul>
                <?php include "items.php"; ?>
            </ul>
        </main>
        <!-- Footer -->
        <footer>
            <p>&copy; 2026</p>
        </footer>
    </body>
</html>