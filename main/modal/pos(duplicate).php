<?php 
include_once('../connect.php');

$time = time();
$time = date("Y-m-d H:i:s",$time);

if ($_GET['do'] == 'rowCount') { //displays the items in the cart
  $result = $db->prepare("SELECT COUNT(*) AS count FROM tbl_cart");
  $result->execute();
  $row=$result->fetch();
  echo($row['count']);
}

if ($_GET['do'] == 'categoryCount') { //displays the items in the cart
  $result = $db->prepare("SELECT COUNT(*) AS count FROM tbl_category");
  $result->execute();
  $row=$result->fetch();
  echo($row['count']);
}

if ($_GET['do'] == 'getCartItemsId') { //displays the items in the cart
  $result_menu = $db->prepare("SELECT * FROM tbl_cart");
  $result_menu->execute();
  $data = array();
  for ($i = 0; $row = $result_menu->fetch(); $i++) {
    array_push($data,$row[2]."/");
  }
  echo implode($data);
}

if($_GET['do'] == 'image'){
  $id = $_POST['id'];

  $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id=".$id."");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    echo $row['imgUrl'];
  }
}

if($_GET['do'] == 'name'){
  $id = $_POST['id'];
  $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id=".$id."");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    echo $row['name'];
  }
}

if($_GET['do'] == 'price'){
  $id = $_POST['id'];
  $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id=".$id."");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    echo $row['price'];
  }
}


if ($_GET['do'] == 'quantity') { //displays quantity of menu
  $menuId = $_POST['id'];
  $result_menu = $db->prepare("SELECT * FROM tbl_cart WHERE menuId = ".$menuId."");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    echo $row['menuQty'];
  }
}

if ($_GET['do'] == 'totalCartItemsAmount') { //displays quantity of menu
  $amount = 0;
  $result_menu = $db->prepare("SELECT tbl_menu.price, tbl_cart.menuQty FROM tbl_menu INNER JOIN  tbl_cart ON tbl_menu.id = tbl_cart.menuId");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    $amount =  $amount + ($row['price'] * $row['menuQty']);
  }
  echo number_format((float)$amount, 2, '.', '');
}

if($_GET['do'] == 'delete'){

  $sql = "DELETE FROM  tbl_cart";
  $q = $db->prepare($sql);
  $q->execute(array());
  header("location: ../pos.php");
}

if ($_GET['do'] == 'addToCart') { //displays quantity of menu
  $id = false;
  $menuId = $_POST['menuId'];
  $menuQty = $_POST['menuQty'];
  $discount = 0;
  $employeeId = $_SESSION['userNo'];
  $invoiceNo = $_SESSION['invoiceNo'];

  $result = $db->prepare("SELECT * FROM tbl_cart WHERE menuId =".$menuId."");
  $result->execute();
  for($i = 1; $row=$result->fetch(); $i++){
    if($menuId == $row['menuId']){
      $id = true;
    }
  }

  if($id == false){
    $sql = "INSERT INTO tbl_cart(menuId, menuQty,discount, employeeId,invoiceNo) VALUES (?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($menuId, $menuQty, $discount, $employeeId, $invoiceNo));
  }else{

    $sql = "UPDATE  tbl_cart  SET menuQty='$menuQty' WHERE menuId='$menuId'";
    $q = $db->prepare($sql);
    $q->execute(array());
  }
}

if($_GET['do'] == 'deleteItem'){
  $menuId = $_POST['menuId'];
  $sql = "DELETE FROM  tbl_cart WHERE menuId =".$menuId."";
  $q = $db->prepare($sql);
  $q->execute(array());
  header("location: ../pos.php");
}

if ($_GET['do']=='purchases') { //Cashier Remove
    $invoiceNo=$_SESSION['invoiceNo'];
    $menuId = $_POST['menuId'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $price = $_POST['price'];

    $sql = "INSERT INTO tbl_purchases(dateTime, invoiceNo,menuID,xprice,xqty,xtotal) VALUES (?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($time, $invoiceNo, $menuId, $price, $quantity, $total));


    // header("location: ../pos.php");
}


if($_GET['do'] == 'process'){

  $invoice = $_SESSION['invoiceNo'];
  $user = $_SESSION['userID'];

  $rowCount = $_POST['rows'];
  $nonVatSale = $_POST['nonVatSale'];
  $VAT = $_POST['VAT'];
  $salesWithVat = $_POST['salesWithVat'];
  $discount = $_POST['discount'];
  $total = $_POST['total'];
  $cash = $_POST['cash'];
  // $change = $_POST['change']; //unused
  $discountName = "senior/pwd";

  if($discount == 0){
    $discountName = 'none';
  }



  // shift table
  $time = time();
  $time = date("Y-m-d H:i:s",$time);
  $rows;
  $shiftTotal;
  $shiftTrans;
    //check if there is a shift that is not logged out before inserting
  $result_category = $db->prepare("SELECT COUNT(1) FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
  $result_category->execute();
  for ($i = 1; $row = $result_category->fetch(); $i++) {
    $rows = $row[0];
  }
  if($rows == 0 && $_SESSION['role'] != "admin"){
      echo 'please time in first before placing the order';
  }

  if($rows != 0 || $_SESSION['role'] == "admin"){
    $result_category = $db->prepare("SELECT * FROM tbl_shift WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL ORDER BY ID DESC LIMIT 1");
    $result_category->execute();
    for ($i = 1; $row = $result_category->fetch(); $i++) {
      $shiftTotal = $row[6];
      $shiftTrans = $row[7];
    }

    if($_SESSION['role'] != "admin"){
      $shiftTotal = $shiftTotal + $salesWithVat;
      $shiftTrans = $shiftTrans + 1;
      if($shiftTotal >= 8800){
        $result_category = $db->prepare("UPDATE tbl_shift SET totalSales='".$shiftTotal."' , totalTransactions='".$shiftTrans."', commission='0.10' WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL");
      }else{
        $result_category = $db->prepare("UPDATE tbl_shift SET totalSales='".$shiftTotal."' , totalTransactions='".$shiftTrans."' WHERE employeeId=".$_SESSION['userID']." AND endShift IS NULL");
      }
      $result_category->execute();
    }

    

    $sql = "INSERT INTO tbl_payment (dateTime,invoiceNo,sumQTY, xtotal,cash,subtotal,disNo,disName,salestax,staffid) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $query = $db->prepare($sql);
    $query->execute(array($time, $invoice,$rowCount, $nonVatSale,$cash,$salesWithVat,$discount,$discountName,$VAT, $user));
  
    $sql = "DELETE FROM tbl_cart";
    $q = $db->prepare($sql);
    $q->execute(array());
    echo "true";
  } 

  // header("location: ../pos.php");
}

if($_GET['do'] == 'newInvoice'){

  $result_category = $db->prepare("SELECT * FROM tbl_payment ORDER BY ID DESC LIMIT 1");
  $result_category->execute();
  for ($i = 1; $row = $result_category->fetch(); $i++) {
    $_SESSION['invoiceNo'] = "";
    $_SESSION['invoiceNo'] = date('Ymd').$_SESSION['userID'].number_format($row[0]+1);
  }
}
// create something that will inser and update the cart

// shows the category and menu
if($_GET['do'] == 'category'){
  $result_category = $db->prepare("SELECT * FROM tbl_category");
  $result_category->execute();
  for ($i = 1; $row = $result_category->fetch(); $i++) {
    $category = $row['category'];
    $id = $row['id'];
    echo "<li><a id=".$row['id']." data-toggle='tab'>".$row['category']."</a></li>";
  }
}

if($_GET['do'] == 'menu'){
  $id = $_POST['id'];
  $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE code=".$id."");
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    echo "
    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-2' >
      <a  data-toggle='tab' style='display:block; height: 220px; width:150px; float: left;text-align:center' class='thumbnail fancybox fox' rel='ligthbox'>
        <img id='menu".$row['id']."' onClick='onClickFunction(".$row['id'].")' class='img-responsive' height='100px' src='./assets/uploaded/".$row['imgUrl']."' style='text-align: center'>
        ".$row['name']."<br>
        ".$row['price']."
      </a>
    </div>";
  }
}


?>