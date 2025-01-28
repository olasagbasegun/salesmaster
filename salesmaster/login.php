<?php
session_start();
include('constant.php');



if(array_key_exists('loginuser', $_POST)){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = $db->query("SELECT * FROM user WHERE email = '$email' AND password = '$password' ");
    $number = mysqli_num_rows($sql);
    if($number == 1){
        $row = mysqli_fetch_assoc($sql);
        $_SESSION['user'] = $row['sn'];
        header('location: sales.php');
    }
    else{
        echo 'invalid login datails';
    }
}
// echo $number;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col"><h3 class="text-center py-4 px-5 text-info">sales master software</h3>
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-info">Login</h5>
                    </div>
                    <form method="POST">
                    <div class="card-body">
                        <label for="" class="text-info">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter Email">
                        <label for="" class="text-info">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="loginuser" class="btn btn-info ">Login</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col"></div>


        </div>






    </div>









    <script src="bootstrap.bundle.min.js"></script>
</body>

</html>