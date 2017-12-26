<?php 
    require "./config/database.php";

    try{
        $connect = new PDO("mysql:host=$host", $user, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = file_get_contents("./config/init.sql");
        $connect->exec($sql);

        echo "Database and table users created successfully.";
    }
    catch(PDOExeption $error){
        echo $sql . "<br>" . $error->getMessage();
    }

?>