<?php
require_once '../src/config.php'; // include "../src/config.php";
$error_message = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){ // any form submission using the POST method
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    

    if(!empty($id) && !empty($name) && !empty($email) && !empty($password)){

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(id,studentname,phone,email,password)
        VALUES (?,?,?,?,?)";

        $stmt=mysqli_prepare($con,$sql); // prepare the statement

        if($stmt){
            // bind actual values to the placeholders (?)
            // that may be use another methods like "$stmt->bind_param()"
            mysqli_stmt_bind_param($stmt,"sssss", $id, $name, $phone, $email, $hashed_password); 
            
            if(mysqli_stmt_execute($stmt)){ // Execute the statement
                header("Location: login.php");
            }else{
                if ($stmt->errno == 1062){
                    $error_message = "Your email address or StudentId already use.!";
                }
            }
        }
        else{
            die(mysqli_error($con)); // If the query fails, stop the script and show the error
        }
    }else{
        $error_message = "Please fill out all fields.";
    }
    $con->close();
        
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h1 class="text-center">Student Registration</h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="id">StudentId</label>
                <input type="id" class="form-control" id="id" name="id" placeholder="id" required>
            </div>
            <div class="form-group">
                <label for="name">StudentName</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="phone">PhoneNumber</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="phonenumber">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="check" required>
                <label class="form-check-label" for="check">Check me out</label>
            </div>

            <?php if (!empty($error_message)): ?>
                        <div style="color: red;" class="text-center mt-3"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <p class="text-center mt-2">Already have an account? <a href="login.php">Log in here</a></p>
            
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
