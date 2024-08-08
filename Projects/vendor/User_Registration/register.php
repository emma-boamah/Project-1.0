<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* body{
    
} */

form{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

h1 {
    text-align: center;
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
            <p>&copy</p>
        </footer>
    </div>
</body>
</html>

<?php
function clean_data($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and set to empty values
$fname = $mname = $surname = $country = $PhoneNumber = $email = $password = $confirm_password = '';
$fnameErr = $mnameErr = $surnameErr = $countryErr = $PhoneNumberErr = $emailErr = $passwordErr = $confirm_passwordErr = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['fname'])){
        $fnameErr = "Please enter your first name.";
    } else{
        $fname = clean_data($_POST['fname']);
        if(strlen($fname) < 2 || strlen($fname) > 50){
            echo "First name must be between 2 and 50 characters";
        } elseif(!preg_match("/^[a-zA-Z]+$/", $fname)){
            echo "Invalid first name.";
        }
    }
    if(empty($_POST['mname'])){
        $Err = '';
    } else{
        $mname = clean_data($_POST['mname']);
        // Check for maximum and minimum name length
        if(strlen($mname) < 2 || strlen($mname) > 50){
            echo "Name must be between 2 and 50 words!";
        } else{
            // Check if name contains only letters
            if(!preg_match("/^[a-zA-Z]+$/", $mname)){
                echo "Invalid name!";
            }
        }
    }
    if(empty($_POST['surname'])){
        $Err = 'Surname is required!';
    } else{
        $surname = clean_data($_POST['surname']);
        // Check for maximum and minimum name length
        if(strlen($surname) < 2 || strlen($surname) > 50){
            echo "Name must be between 2 and 50 words!";
        } elseif{
            // Check if name contains only letters
            if(!preg_match("/^[a-zA-Z]+$/", $surname)){
                echo "Invalid name!";
            }
        }
    }
    if(empty($_POST['country'])){
        $Err = 'Country name is required!';
    } else{
        $country = clean_data($_POST['country']);
    }
    if(empty($_POST['tel'])){
        $Err = 'Phone number is required!';
    } else{
        
    }
    $tel = clean_data($_POST['tel']);
    $email = clean_data($_POST['email']);
    $email = 
    $password = clean_data($_POST['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $confirm_password = clean_data($_POST['confirm-password']);
    $confirm_password_hash = password_hash($confirm_password, PASSWORD_DEFAULT);

    
}

?>