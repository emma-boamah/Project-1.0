<?php
try{
    $host = "localhost";
    $user = "root";
    $pass = "@123ASDubuntu";
    $db_Name = "api_test";

    $db_Connection = new PDO("mysql:host=$host; dbname=$db_Name", $user, $pass);
    $db_Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_Connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // CLOSE DATABASE CONNECTION
    $db_Connection = null;
} catch(PDOException $e){
    echo $e->getMessage();
}
