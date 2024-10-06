<?php // Data retrieval script
include '../src/config.php';
session_start();

if (!isset($_SESSION['id'])) {  // check student is logged in
    header('location: studentlogin.php');
    exit();

}

$id = $_GET['id'];
$name = '';
$phone = '';
$email = '';

// Retrieve current user data for the given ID
if(isset($id)){
    $sql = "SELECT studentname,phone,email FROM users WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,"s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $name = $row['studentname'];
        $phone = $row['phone'];
        $email = $row['email'];
    }
}


?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
    <h1 class="text-center">Update User Data</h1>
    <form action="update.php?id=<?php echo urlencode($id); ?>" method="POST">
        <!-- <div class="form-group">
            <label for="id">StudentId</label>
            <input type="id" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>" required>
        </div> -->
        <div class="form-group">
            <label for="studentname">Student Name</label>
            <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <?php if(!empty($error_message)): ?>
            <div style="color: red;" class="text-center mt-3"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-center">
            <button type="submit" name="update" class="btn btn-success">Update</button>
        </div>
        
    </form>
    </div>
    
</body>
</html>

<?php
$error_message = '';

if(isset($_POST['update'])){
    $id = $_GET['id'];
    $name = $_POST['studentname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET studentname=?, phone=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,"ssss", $name, $phone, $email, $id);
    
    if(mysqli_stmt_execute($stmt)){
        
        header("Location: studenthome.php");
        exit();
    }else{
        $error_message = "Not update user data";
    }
}
$con->close();
?>