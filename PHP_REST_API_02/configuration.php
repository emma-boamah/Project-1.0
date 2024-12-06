<?php
try{
    $db_Host = "localhost";
    $db_User = "user";
    $db_Password = "";
    $db_Name = "projects";

    $db_Conn = new PDO("mysql:host=$db_Host;dbname=$db_Name", $db_User, $db_Password);
    $db_Conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();

    // CLOSE DATABASE CONNECTION
    if($db_Conn !== null){
        $db_Conn = null;
    }
}