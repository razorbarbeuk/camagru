<?php
    class Database{

        private $connect;

        public function __construct($database_name, $login, $password, $host = '127.0.0.1'){
            $this->connect = new PDO("mysql:host=$host;dbname=$database_name", $login, $password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }        

        public function query($query, $params = false){
            if ($params) {
                $req = $this->connect->prepare($query);
                $req->execute($params);
            } else {
                $req = $this->connect->query($query);
            }
            return $req;
        }

        public function lastInsertId(){
            return $this->connect->lastInsertId();
        }

    }