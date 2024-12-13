<?php
header("Content-Type: application/json");

require_once("config.php");

// CAPTURE THE REQUEST METHOD
$method = $_SERVER['REQUEST_METHOD'];

// PARSE INCOMING JSON DATA
$input = json_decode(file_get_contents('php://input'), true);

// FUNCTION TO HANDLE GET REQUEST
function handleGet($db_Connection){
    $query = ('SELECT * FROM users');
    $stmt = $db_Connection->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($result)){
        echo json_encode(['message'=>'No users found']);
    }else{
        echo json_encode($result);
    }
}

// FUNCTION TO HANDLE POST REQUEST
function handlePost($db_Connection, $input){
    try{
        // VALIDATE USER INPUTS
        $name = fiLter_var($input['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

        if(empty($name) || empty($email)){
            http_response_code(400);
            echo json_encode(['message'=> 'Name or email is required']);
            return;
        }
        $query = ('INSERT INTO users (name, email) VALUES(?, ?)');
        $stmt = $db_Connection->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);

        // EXECUTE QUERY
        $stmt->execute();
    } catch(PDOException $e){
        echo json_encode(['Error'=>$e->getMessage()]);
    }
    
} 

// FUNCTION TO HANDLE UPDATE/PUT REQUEST
function handlePut($db_Connection, $input){
    try{
        // SANITIZE/VALIDATE USER INPUTS
        $name = filter_var($input['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);
        $id = filter_var((int)$input['id'], FILTER_VALIDATE_INT);
        if(empty($name) || empty($email) || empty($id)){
            http_response_code(400);
            echo json_encode(['message'=> 'Name, email and id are required!']);
            return;
        }
        $query = ('UPDATE users SET name=?, email=? WHERE id=?');
        $stmt= $db_Connection->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);

        // EXECUTE STATEMENT
        $stmt->execute();
    } catch(PDOException $e){
        echo json_encode(['message'=> $e->getMessage()]);
    }
}

// FUNCTION TO HANDLE DELETE REQUEST
    function handleDelete($db_Connection, $input){
        try{
            // VALIDATE USER INPUT
            $id = filter_var((int)$input['id'], FILTER_VALIDATE_INT);
            if(empty($id)){
                http_response_code(400);
                echo json_encode(['message'=> 'id is required!']);
                return;
            }
            $query = ('DELETE FROM users WHERE id=?');
            $stmt = $db_Connection->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);

            // EXECUTE THE STATEMENT
            $stmt->execute();
        } catch(PDOException $e){
            echo json_encode(['message'=>$e->getMessage()]);
        }
    }

    switch($method){
        case 'GET':
            handleGet($db_Connection);
            break;
        case 'POST':
            handlePost($db_Connection, $input);
            break;
        case 'PUT':
            handlePut($db_Connection, $input);
            break;
        case 'DELETE':
            handleDelete($db_Connection, $input);
            break;
        default:
        http_response_code(404);
        echo json_encode(['message'=> 'Method not allowed']);
    }