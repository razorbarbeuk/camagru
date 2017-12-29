<?php
class App{

    static $db = NULL;

    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('Camagru_bdd', 'root', '');
        }
        return self::$db;
    }

    static function redirect($page){
        header("Location: $page");
        exit();
    }


}