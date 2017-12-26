<?php
    require_once "./config/connect_db.php";
    $user_id = $_GET['id'];
    $token = $_GET['token'];
    $req = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $req->execute([$user_id]);
    $user = $req->fetch();
    session_start();

    if ($user && $user->confirmed_token == $token) {
        $_SESSION['auth'] = $user;
        $req = $connect->prepare("UPDATE users SET confirmed_token = NULL, confirmed_at = NOW() WHERE id = ?");
        $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
        $req->execute([$user_id]);
        header('Location: account.php');
    } else {
        $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
        header('Location: login.php');
    }

?>