<?php
require_once '../src/config.php';
session_start();
$error_message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT name,password FROM admin WHERE name=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,"s", $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // store the row if have
    if($row = mysqli_fetch_assoc($result)) {
        if($password==$row['password']) {
            $_SESSION['admin'] = $row['name']; // store username in session 
            header("Location: adminhome.php");

        }else{
            $error_message = "Incorrect password";
        }


    }else{
        $error_message = "Admin not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h1 class="text-center">Admin Login</h1>
        <form action="adminlogin.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <?php if (!empty($error_message)): ?>
                        <div style="color: red;" class="text-center mt-3"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="text-center mt-3">Login for student <a href="studentlogin.php">Click here</a></p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
