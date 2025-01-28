<?php
if(!isset($_SESSION['user'])){
    header('location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="col text-end">
    <a href="sales.php"> POS</a> | <a href="Transaction.php">Transactions</a> | <a href="user.php">Users</a> | <a href="logout.php">Logout</a>
</div>
<style>
    a{
        text-decoration:none;
        color:light;
    }
</style>
</body>
</html>
