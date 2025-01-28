<?php
session_start();
include('constant.php');


if(isset($_GET['sn'])){
    $sn = $_GET['sn'];
    $status = $_GET['status'];
    if(User($sn,'admin')==1){$status=1; }
    $sql = $db->query("UPDATE user SET status='$status' WHERE sn='$sn' ");
    header('location: ?');
}

$bid=1;
if(array_key_exists("RegisterUser", $_POST)){
    extract($_POST);

 $password = md5($password);
  $sql =  $db->query("INSERT INTO user (name,phone,email,password,bid) VALUES ('$name','$phone','$email','$password','$bid') ");
   if($sql){Alert('Successfully Registered');
  }else{Alert('Error Submitting data',0); }

}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>



<body>

    <div class="container">
        <div class="row px-3">
            <div class="col-md-8">
                <h2 class="px-3 ">Manage Sales Agents</h2>
            </div>
            <?php include('nav.php')?>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card mx-3 ">
                    <div class="card-header">
                        <h6>Register New Agent</h6>
                    </div>
                    <form method="POST">
                        <div class="card-body">

                            <label for="">Name:</label>
                            <input type="text" name="name" id="" class="form-control" placeholder="Enter Name">
                            <label for="">Phone:</label>
                            <input type="text" name="phone" id="" class="form-control" placeholder="Enter Phone">
                            <label for="">Email:</label>
                            <input type="text" name="email" id="" class="form-control" placeholder="Enter email">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="" class="form-control"
                                placeholder="Enter Password">
                        </div>
                        <div class="card-footer bg-light  py-1">
                            <button type="RegisterUser" class="btn btn-primary " style="float: right; "
                                name="RegisterUser">
                                Register user
                            </button>
                        </div>
                </div>
            </div>
            </form>




            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h6>Users</h6>
                    </div>



                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                            <?php $i=1;
             $sql = $db->query("SELECT * FROM user WHERE bid='$bid' ORDER BY sn DESC LIMIT 20");
while($row = mysqli_fetch_assoc($sql)){ 
        $e = $i++ ;
     //$action = '<a href="transactions.php?agent='.$row['sn'].'" class="btn btn-sm btn-secondary" style="margin-right:10px">Sales</a>';
 if($row['status']==1){
          $action = '<a href="?sn='.$row['sn'].'&status=0" class="btn btn-sm btn-danger">Deactivate</a>';    
    } else{$action = '<a href="?sn='.$row['sn'].'&status=1" class="btn btn-sm btn-success">Activate</a>'; }
?>
                            <tr>
                                <td>
                                    <?= $e ?>
                                </td>
                                <td>
                                    <?= $row['name'] ?>
                                </td>
                                <td>
                                    <?= $row['phone'] ?>
                                </td>
                                <td>
                                    <?= $row['email'] ?>
                                </td>
                                <td>
                                    <?= substr($row['created'],0,10) ?>
                                </td>
                                <td>
                                    <?= $action ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>