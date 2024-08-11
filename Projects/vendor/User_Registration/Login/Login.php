<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Global Styles */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f4f4f4;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Form Container Styles */

.form-container {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 50%;
    margin: 40px auto;
}

/* Form Styles */

form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-bottom: 10px;
}

form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

form input[type="submit"] {
    background-color: #87CEEB; /* Sky Blue */
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

form input[type="submit"]:hover {
    background-color: #66CCCC; /* Darker Sky Blue */
}

/* Responsive Design */

@media (max-width: 768px) {
    .form-container {
        width: 80%;
    }
}

@media (max-width: 480px) {
    .form-container {
        width: 100%;
    }
}

    </style>
</head>
<body>
<div class="form-container">
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <label for="firstName">Email or Firstname</label>
        <input type="text" id="firstName" name="firstName" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="login">
    </form>
</div>
</body>
</html>

<?php
// Configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'test';

// Connect to database using PDO with error handling
try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $firstName = trim(filter_var($_POST['firstName'], FILTER_UNSAFE_RAW));
    $password = trim(filter_var($_POST['password'], FILTER_UNSAFE_RAW));

    // Check if user exists using prepared statement
    $stmt = $conn->prepare("SELECT * FROM subscribers WHERE Email = :email OR FirstName = :firstName");
    $stmt->bindParam(":email", $firstName, PDO::PARAM_STR);
    $stmt->bindParam(":firstName", $firstName, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Check password using password_verify
        if (password_verify($password, $user['Password'])) {
            // Login successful
            session_start();
            session_regenerate_id();
            $_SESSION['user_id'] = $user['ID'];
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Invalid password!";
            exit();
        }
    } else {
        echo "User not found!";
        exit();
    }
}

// Close database connection
$conn = null;
?>


