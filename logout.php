<?php
    session_start();
    unset($_SESSION['auth']);
    $_SESSION['flash']['success'] = "Vous etes maintenant deconnecté";
    header('Location: login.php');