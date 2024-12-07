<?php 
header("Content-Type: application/json");
require_once("configuration.php");

// CAPTURE THE REQUEST METHOD
$method = $_SERVER["REQUEST_METHOD"];

// PARSE INCOMING JSON DATA
$input = json_decode(file_get_contents('php://input'), true);

// FUNCTION TO HANDLE GET REQUEST
function handleGet($db_Conn){
    $query = "SELECT * FROM users";
    $stmt = $db_Conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

// FUNCTION TO HANDLE POST REQUEST
function handlePost($db_Conn, $input){
    $query = "INSERT INTO users (name, email) VALUES(?, ?)";
    $stmt = $db_Conn->prepare($query);
    $stmt->bindParam(1, $input['name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $input['email'], PDO::PARAM_STR);
    $stmt->execute();

    // 
    echo json_encode(['message' => 'User created successfully']);
}

// FUNCTION TO HANDLE PUT REQUEST
function handlePut( $db_Conn, $input ){
    $query = 'UPDATE users SET name=?, email=? WHERE id=?';
    $stmt = $db_Conn->prepare($query);
    $stmt->bindParam(1, $input['name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $input['email'], PDO::PARAM_STR);
    $stmt->bindParam(3, (int)$input['id'], PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['message'=> 'User updated successfully']);
}

// FUNCTION TO HANDLE DELETE REQUEST
function handleDelete($db_Conn, $input){
    $query = "DELETE * FROM users WHERE id=?";
    $stmt = $db_Conn->prepare($query);
    $stmt->bindParam(1, (int)$input["id"], PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["message" => 'User deleted successfully']);
}