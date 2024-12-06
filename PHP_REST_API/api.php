<?php
require_once("config.php");

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch( $method ) {
    case 'GET':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $query = ('SELECT * FROM profiles WHERE ID=?');
            $stmt = $db_Connection->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo json_encode($result);
        } else{
            $query = ('SELECT * FROM profiles');
            $stmt = $db_Connection->prepare($query);
            $stmt->execute();
            
            $users = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $users[] = $row;
            }
            echo json_encode($users);
        }
        break;
    case 'POST':
        $name = $input['name'];
        $email = $input['email'];
        $age = $input['age'];

        // INSERT DATA INTO THE DATABASE
        $query = ('INSERT INTO people (Name, E_mail, Age) VALUES(?, ?, ?)');
        $stmt = $db_Connection->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(1, $age, PDO::PARAM_INT);

}   