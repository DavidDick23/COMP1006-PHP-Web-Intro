
<?php $items = ["Home", "About", "Contact"]; ?>

<?php 
// Most likely a way to turn this into a proper function to be called in "index.php"
foreach ($items as $item): ?>
    <!-- I would like to decouple the HTML in this in future -->
    <li><?= $item ?></li> 
<?php endforeach; ?>