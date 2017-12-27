<?php
    session_start();
    setcookie('remember', NULL, -1);
    unset($_SESSION['auth']);
    $_SESSION['flash']['success'] = "Vous etes maintenant deconnecté";
    header('Location: login.php');