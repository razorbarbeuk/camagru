<?php
class Str{

    public function random($length){
        $str = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        return substr(str_shuffle(str_repeat($str, $length)), 0, $length);
    }

}