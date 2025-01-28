<?php
session_start();
include('constant.php');


$userid = $_SESSION['user'];
$username = User($userid);
$bid = User($userid,'bid');
$useremail = User($userid,'email');


if(!isset($_SESSION['salesid'])){
  $_SESSION['salesid'] = rand();
}

if(isset($_GET['editsales'])){
  $salesid = $_GET['editsales'];
  $_SESSION['salesid'] = $salesid;
  $sql = $db->query("SELECT * FROM sales WHERE salesid='$salesid' ");
  $row = mysqli_fetch_assoc($sql);
  $name = $row['customer'];
  $phone = $row['phone'];
  }

$salesid = $_SESSION['salesid'];

if (isset($_POST['submit'])){
    $item = $_POST['item'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $amount = $price * $qty; // $_POST['amount'];
    $db->query("INSERT INTO item (item,price,qty,amount,salesid,bid,user)  VALUES ('$item', '$price','$qty',
     '$amount','$salesid','$bid','$userid')"); 
}

if(isset($_GET['deleteitem'])){
  $sn = $_GET['deleteitem'];
 $sql = $db->query("DELETE FROM item WHERE sn='$sn' ");
 if($sql){
  echo 'Operation successful';
 }
  
}

if(isset($_POST['checkout'])){
  if(isset($_GET['editsales'])){
    $db->query("DELETE FROM sales WHERE salesid='$salesid' ");
  }
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $total = $_POST['total'];
  $mode = $_POST['mode'];

  $sql = $db->query("INSERT INTO sales (customer, total, phone, mode, salesid, bid, user) VALUES ('$name','$total','$phone','$mode','$salesid','$bid','$userid') ");
  if($sql){
    echo 'Checkout operation succcessful';
    unset($_SESSION['salesid']);
    $salesid = '';
  }
  if(isset($_GET['editsales'])){
  header('location: sales.php');
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <?php include('nav.php')?>
    <h3>Point of sales</h3>
    <div class="row">
      <div class="col">
        <form method="POST">
        <div class="card">
          <div class="card-header">
            <h5>Add items to cart</h5>
          </div>
          <div class="card-body">
            <label for="">Item</label>
            <input type="text" name="item" id="item" class="form-control" placeholder="Item name" onkeyup="getAmount()">
            <label for="">Price</label>  
            <input type="price" name="price" class="form-control" placeholder="Enter Price" id="price" onkeyup="getAmount()">
            <label for="">Quality</label>
            <input type="" name="qty" class="form-control" placeholder="Enter quality" id="qty" onkeyup="getAmount()">
            <label for="">Amount</label>
            <input type="amount" name="amount" onkeyup="getAmount2(this.value)" class="form-control" placeholder="Enter amount" id="amount">
          </div>
          <div class="card-footer">
            <button type="submit" name="submit" style="float: right;" class="btn btn-success">Add item to cart</button>
          </div>
        </div>
        </form>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h5 style="float:left">cart</h5> <b style="float:right">Salesid: <?= $salesid ?></b>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <th>QTY</th>
                <th>item</th>
                <th>price</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
              <?php 
              $total = 0;
                        $sql = $db->query("SELECT * FROM item WHERE salesid = '$salesid' ");
                        while($row = mysqli_fetch_assoc($sql)){

                        $QTY = $row['qty'];
                        $item = $row['item'];
                        $price = $row['price'];
                        $amount = $row['amount'];
                        $total += $amount;
                    
                    ?>

                    <tr>

                        <td><?php echo $QTY ?></td>
                        <td><?php echo $item ?></td>
                        <td><?php echo $price ?></td>
                        <td><?php echo $amount ?></td>
                        <td><a href="?deleteitem=<?=$row['sn']?>">Remove</a></td>
                    </tr>
                     <?php } ?>
                     <tr>
                      <th>Total</th>
                      <th></th>
                      <th></th>
                      <th><?php echo $total ?></th>
                      <th></th>
                     </tr>
            </table>


<form action="" method="post">
  <input type="hidden" value="<?=$total?>" name="total">
            mode of payment
            <select name="mode" id="" class="form-select form-select-lg" required>
              <option value="">select text....</option>
              <option>pos</option>
              <option>cash</option>
              <option>transfer</option>
            </select>

            <label for="">customer name</label>
            <input type="text" class="form-control" name="name" value="<?=$name??''?>">
            <label for="">customer phone number</label>
            <input type="text" class="form-control" name="phone" value="<?=$phone??''?>">
          </div>
          <div class="card-footer">
            <button type="submit" style="float: right;" class="btn btn-success" name="checkout">complete checkout</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col py-4">
      <div class="card">
        <div class="card-header">
          <h5>recent transaction</h5>
        </div>
        <div class="card-body">
          <table class="table">
            
            <tr>
              <th>SN</th>
              <th>customer</th>
              <th>customer phone</th>
              <th>total amount</th>
              <th>payment mode</th>
              <th>date</th>
              <th>Action</th>
            </tr>
            <?php
            $i = 1;
            $sql = $db->query("SELECT * FROM sales ORDER BY sn DESC");
            while($row = mysqli_fetch_assoc($sql)){ $e=$i++;

            ?>
          <tr>
          <td><?=$e?></td>
          <td><?=$row['customer']?></td>
          <td><?=$row['phone']?></td>
          <td><?=$row['total']?></td>
          <td><?=$row['mode']?></td>
          <td><?=$row['created']?></td>
          <td>
          <a class="btn btn-primary" href="?editsales=<?= $row['salesid'] ?>">Edit</a>
            <a class="btn btn-success" href="receipt.php?salesid=<?php echo $row['salesid'] ?>">Receipt</a></td>

          </tr>
          <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>


  </div>






  </div>



  <script src="bootstrap.bundle.min.js"></script>
<script>
  function getAmount(){
    var item = document.getElementById('item').value;
    var qty = document.getElementById('qty').value;
    var price = document.getElementById('price').value;
    var amount = price * qty;
    if(item == ''){return ;}
    //alert(item);
    document.getElementById('amount').value = amount;
  }

  function getAmount2(amount){

var price = document.getElementById('price').value;
var qty = amount/price;
//alert(qty);
document.getElementById('qty').value = Number(qty);
  }
</script>

</body>

</html>