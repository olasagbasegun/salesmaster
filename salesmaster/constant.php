<?php 
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","salesmaster");

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_GET['logout'])){
    session_destroy();
    header('location: login.php'); exit; 
}

$user = $_SESSION['user']??'';

if($user){
    $sql = $db->query("SELECT * FROM user WHERE sn = '$user' ");
    $row = mysqli_fetch_assoc($sql);
    $name = $row['name'];
    $status = $row['status'];
    $bid = $row['bid'];
    $admin = $row['admin'];
}

if(!isset($_COOKIE['biztitle'])){
    $sql = $db->query("SELECT * FROM business WHERE sn = '$bid' ");
    $row = mysqli_fetch_assoc($sql);
    $biztitle = $row['name'];

    setcookie('biztitle', $biztitle, time() + (86400 * 730), "/");
}


function User($user,$opt='name'){
    global $db;
    $sql = $db->query("SELECT * FROM user WHERE sn = '$user' ");
    $row = mysqli_fetch_assoc($sql);
    return mysqli_num_rows($sql)==1 ? $row[$opt] : '';
}


function Alert($note,$x=1){
    echo $x==1 ? '<div class="alert alert-success" role="alert">
  '.$note.'!
</div>' : '<div class="alert alert-danger" role="alert">
  '.$note.'!
</div>';
return;
}
