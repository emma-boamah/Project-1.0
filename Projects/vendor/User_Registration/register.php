<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

/* Header Styles */

header {
    background-color: #87CEEB; /* Sky Blue */
    color: #fff;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header h1 {
    font-size: 24px;
    margin-bottom: 10px;
    font-weight: bold;
}

/* Hero Section */

.hero {
    background-color: #ADD8E6; /* Light Sky Blue */
    color: #fff;
    padding: 50px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.hero h2 {
    font-size: 36px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Form Styles */

form {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

form label {
    display: block;
    margin-bottom: 10px;
}

form input[type="text"],
form input[type="email"],
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
    .container {
        padding: 10px;
    }

    form {
        padding: 10px;
    }
}

@media (max-width: 480px) {
    form input[type="text"],
    form input[type="email"],
    form input[type="password"] {
        padding: 5px;
    }

    form input[type="submit"] {
        padding: 5px 10px;
    }
}


    </style>
    <title>Sign Up</title>
</head>
<body>
    <div class="form_container">
        <h1>Sign up</h1>
        <form action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]))?>" method="POST">
           <label for="fname">Enter your first name</label>
           <input type="text" name="fname" id="fname" required aria-required="true">
           <label for="mname">Enter your middle name <i>Optional</i></label>
           <input type="text" name="mname" id="mname" placeholder="Optional">
           <label for="surname">Enter your surname</label>
           <input type="text" name="surname" id="surname" required aria-required="true">
           <label for="country">Enter your country</label>
           <input type="text" name="country" id="country" required aria-required="true">
           <label for="tel">Phone Number</label>
           <input type="tel" name="tel" id="tel" required aria-required="true">
           <label for="email">Enter your email address</label>
           <input type="email" id="email" name="email" required aria-required="true">
           <label for="password">Enter a password</label>
           <input type="password" id="password" name="password" required aria-required="true">
           <label for="confirm-password">Confirm your password</label>
           <input type="password" id="confirm-password" name="confirm-password">
           <input type="submit" value="sign up">
        </form>
    </div>
    <div class="footer">
        <footer>
            <p>&COPY;;</p>
        </footer>
    </div>
</body>
</html>

<?php
// Configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'test';

// Connect to database
try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to clean and validate input data
function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate password
function validatePassword($password, $confirmPassword) {
    $errors = array();
    if (empty($password) || empty($confirmPassword)) {
        $errors[] = new Exception("Passwords are required!");
    } else {
        // Sanitize passwords
        $password = cleanData($password);
        $confirmPassword = cleanData($confirmPassword);

        // Check password length
        if (strlen($password) < 8) {
            $errors[] = new Exception("Password must be at least 8 characters long!");
        }

        // Check password strength
        if (!preg_match("/[A-Z]/", $password)) {
            $errors[] = new Exception("Password must contain at least one uppercase letter!");
        }
        if (!preg_match("/[a-z]/", $password)) {
            $errors[] = new Exception("Password must contain at least one lowercase letter!");
        }
        if (!preg_match("/[0-9]/", $password)) {
            $errors[] = new Exception("Password must contain at least one digit!");
        }
        $Special_Char_Pattern = "/[!@#$%^&*()_-{}:;',.?]/";
        if (!preg_match($Special_Char_Pattern, $password)) {
            $errors[] = new Exception("Password must contain at least one special character!");
        }

        // Check if confirmed password matches password
        if ($password != $confirmPassword) {
            $errors[] = new Exception("Passwords do not match!");
        }
    }
    return $errors;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Clean and validate input data
    $fname = cleanData($_POST['fname']);
    $mname = cleanData($_POST['mname']);
    $surname = cleanData($_POST['surname']);
    $country = cleanData($_POST['country']);
    $tel = cleanData($_POST['tel']);
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);
    $confirmPassword = cleanData($_POST['confirm-password']);

    // Validate input data
    $errors = array();
    if (empty($fname)) {
        $errors[] = new Exception("First name is required!");
    }
    if (!preg_match("/^[a-zA-Z]+$/", $fname)) {
        $errors[] = new Exception("Invalid first name!");
    }
    if (empty($surname)) {
        $errors[] = new Exception("Surname is required!");
    }
    if (!preg_match("/^[a-zA-Z]+$/", $surname)) {
        $errors[] = new Exception("Invalid surname!");
    }
    if (empty($country)) {
        $errors[] = new Exception("Country is required!");
    }
    if (!preg_match("/^[a-zA-Z]+$/", $country)) {
        $errors[] = new Exception("Invalid country!");
    }
    if (empty($tel)) {
        $errors[] = new Exception("Phone number is required!");
    }
    if (!preg_match("/^[0-9]+$/", $tel) || strlen($tel) != 10) {
        $errors[] = new Exception("Invalid phone number!");
    }
    if (empty($email)) {
        $errors[] = new Exception("Email is required!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = new Exception("Invalid email format!");
    }

    

    // Validate password
    $passwordErrors = validatePassword($password, $confirmPassword);
    if (!empty($passwordErrors)) {
        $errors = array_merge($errors, $passwordErrors);
    }

    // Check if there are any errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error->getMessage() . "<br>";
        }
    } else {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Check if first name already exists
        $stmt = $conn->prepare("SELECT * FROM subscribers WHERE FirstName = :firstname");
        $stmt->bindParam(':firstname', $fname);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo "Error: First name already exists!";
            exit();
        } else{
            // check if email already exists
            $stmt = $conn->prepare("SELECT * FROM subscribers WHERE Email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                echo "Error: Email already exists!";
                exit();
            }
        }

        // Prepare and bind SQL statement
        $query = "INSERT INTO subscribers(FirstName, MiddleName, Surname, Country, PhoneNumber, Email, Password) VALUES(:firstname, :middlename, :surname, :country, :phoneNumber, :email, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':firstname', $fname);
        $stmt->bindParam(':middlename', $mname);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':phoneNumber', $tel);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);





        // Insert data into database
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }
}

// Close database connection
$conn = null;
?>

