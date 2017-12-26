<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <link rel="stylesheet" href="../styles/skeleton.css">
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <nav class="nav-bar">
        <h2>Camagru</h2>
        <ul>
            <?php if(isset($_SESSION['auth'])): ?>
                <li><a href="logout.php">Se deconnecter</a></li>
            <?php else: ?>
                <li><a href="register.php">S'inscrire</a></li>
                <li><a href="login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="container row">
        <?php if(isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>    
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>