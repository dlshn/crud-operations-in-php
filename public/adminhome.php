<?php  // check user is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: adminlogin.php');
    exit();
      
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <style>
        .container{
            /* display: inline-block; */
            min-width: 500px; /* Minimum width */
            max-width: 800px; /* Maximum width */
            width: auto; /* Let width auto-adjust within limits */
            margin: 50px auto;
            padding: 20px;
        }
        .btn-danger{
            width: 80%;
        }

    </style>
</head>
<body>
    <div class="container" style="">
        <h1 class="text-center">Student Data</h1>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">StuId</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">email</th>
                    <th scope="col">operation</th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                include '../src/config.php';

                $sql = "SELECT id,studentname,phone,email FROM users";
                
                $result = $con->query($sql);  // stored all rows from users table
                
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){ //"fetch_assoc" fetches one row of the query result
                        echo"<tr>
                        <td>". htmlspecialchars($row['id']) ."</td>
                        <td>". htmlspecialchars($row['studentname']) ."</td>
                        <td>". htmlspecialchars($row['phone']) ."</td>
                        <td>". htmlspecialchars($row['email']) ."</td>
                        <td>";
                        if(isset($_SESSION['admin'])){
                            $id= $row['id'];
                            $encoded_id = urlencode($id);
                            echo "<a href='delete.php?id=$encoded_id' class='btn btn-danger'>Delete</a>";
                        }
                        echo"</td> </tr>";

                    }
                }else{
                    echo "<tr><td colspan='4' class='text-center'>No Data Available</td></tr>";
                }

                $con->close();

                ?>

                
   
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <!-- <a href="register.php" class="btn btn-primary mr-5">Register</a> -->
            <a href="logoutadmin.php" style="width:30%" class="btn btn-danger">Logout</a>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7W3mgPxhU9K/ScQsAP7W3mgPxhU9K/ScQsAP7W3mgPxhU9K/ScQsAP7W3mgPxhU9K/ScQsAP7W3mgPxhU9K" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
