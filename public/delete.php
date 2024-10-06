<?php
include '../src/config.php';
session_start();

if (!isset($_SESSION['admin'])){  // check admin is logged in
 header('Location: adminlogin.php');
 exit();
}
$id = trim($_GET['id']); // save id from url
// echo htmlspecialchars($id);
$sql = "DELETE FROM users WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt,"s", $id);


if(mysqli_stmt_execute($stmt)){
    header("Location: adminhome.php");
    exit();
}else{
    die("Execution failed:". mysqli_error($con));
}

$con->close();
?>