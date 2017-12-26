<?php 
    session_start(); 
    require "./public/function.php";
?>

<?php require "./public/header.php" ?>

<h1>Votre compte</h1>
<?php debug($_SESSION); ?>

<?php require "./public/footer.php" ?>