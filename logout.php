<?php
    require_once "./public/bootstrap.php";
    App::getAuth()->logout();
    Session::getInstance()->setFlash('success', "Vous etes maintenant deconnecté");
    App::resdirect('login.php');