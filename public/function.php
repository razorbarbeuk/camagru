<?php

    function debug($variable){
        echo '<pre>' . print_r($variable, true) . '</pre>';
    }

    function str_random($length)
    {
        $str = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        return substr(str_shuffle(str_repeat($str, $length)), 0, $length);
    }