<?php
try{
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "projects";

    $db_Connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $db_Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo "".$e->getMessage();
}
