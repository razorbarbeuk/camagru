<?php
class App{

    static $db = NULL;

    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('Camagru_bdd', 'root', '');
        }
        return self::$db;
    }

    static function getAuth(){
        return new Auth(Session::getInstance(), ['restriction_msg' => 'lol tu es bloqué']);
    }

    static function redirect($page){
        header("Location: $page");
        exit();
    }


}