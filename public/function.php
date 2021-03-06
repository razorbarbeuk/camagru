<?php

    function debug($variable){
        echo '<pre>' . print_r($variable, true) . '</pre>';
    }

    function logged()
    {
        
    }

    function reconnect_from_cookie()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
        if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
            require_once "./config/connect_db.php";
            if (!isset($connect)) {
                global $connect;
            }
            $remember_token = $_COOKIE['remember'];
            $parts = explode("==", $remember_token);
            $user_id = $parts[0];
            $req = $connect->prepare("SELECT * FROM users WHERE id = ?");
            $req->execute([$user_id]);
            $user = $req->fetch();
            if ($user) {
                $expected = $user_id . "==" . $user->remember_token . sha1($user_id . 'tutu');
                if ($expected == $remember_token) {
                    session_start();
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                } else {
                    setcookie('remember', NULL, -1);    
                }
            } else {
                setcookie('remember', NULL, -1);
            }
        }
    }