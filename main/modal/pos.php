<?php 
include_once('../connect.php');
$time = time();
$time = date("Y-m-d H:i:s",$time);

// load the category and menu

if($_GET['do'] == 'category'){

  $result_menu = $db->prepare("SELECT tbl_category.id AS catID, tbl_category.category AS catName FROM tbl_category");
  $rows = array();
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    $rows[] = $row;
  }
  print json_encode($rows);
}

if($_GET['do'] == 'menu'){

  $result_menu = $db->prepare("SELECT tbl_category.id AS catID, tbl_menu.id AS menuID, tbl_menu.imgUrl AS menuImage, tbl_menu.name AS menuName, tbl_menu.price AS menuPrice, tbl_category.category AS catName FROM tbl_category INNER JOIN tbl_menu WHERE tbl_menu.code = tbl_category.id");
  $rows = array();
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    $rows[] = $row;
  }
  print json_encode($rows);
}

// check tbl_cart
if($_GET['do'] == 'cart'){
  $result_menu = $db->prepare("SELECT tbl_cart.menuId AS menuID, tbl_cart.menuQty AS menuQuantity, tbl_menu.name AS menuName, tbl_menu.price AS menuPrice,tbl_menu.price * tbl_cart.menuQty AS menuTotal FROM tbl_cart INNER JOIN tbl_menu WHERE tbl_menu.id = tbl_cart.menuId");
  $rows = array();
  $result_menu->execute();
  for ($i = 1; $row = $result_menu->fetch(); $i++) {
    $rows[] = $row;
  }
  print json_encode($rows);
}

if($_GET['do'] == 'updateCart'){
  $id = $_POST['id'];
  $op = $_POST['op'];
  $invoice = $_SESSION['invoiceNo'];
  $employee = $_SESSION['userID'];
  if($op == "minus"){
      $result_menu = $db->prepare("INSERT INTO tbl_cart (menuId, menuQty, discount, employeeId, invoiceId) VALUES ($id, 1, 0, '$employee', '$invoice') ON DUPLICATE KEY UPDATE menuQty = menuQty - 1");
  }
  
  if($op == "plus"){
      $result_menu = $db->prepare("INSERT INTO tbl_cart (menuId, menuQty, discount, employeeId, invoiceId) VALUES ($id, 1, 0, '$employee', '$invoice') ON DUPLICATE KEY UPDATE menuQty = menuQty + 1");
  }
  
  $result_menu->execute(array());
  exit();
}

if($_GET['do'] == 'checkCartForZeroQuantity'){
    $sql = "DELETE FROM  tbl_cart WHERE menuQty < 1";
    $q = $db->prepare($sql);
    $q->execute(array());
}

if($_GET['do'] == 'clearCart'){
    $sql = "DELETE FROM  tbl_cart";
    $q = $db->prepare($sql);
    $q->execute(array());
}

if($_GET['do'] == 'completeTransaction'){
  $invoice = $_SESSION['invoiceNo'];
  $employee = $_SESSION['userID'];
  $cart = $_POST['cart'];
  $cash = $_POST['cash'];
  $totalAmount = $_POST['total'];
  $vat = $_POST['vat'];
  $discount = $_POST['discount'];
  $nonvattotal = $_POST['nonvattotal'];
  
  $shiftCode = $_SESSION['shiftCode'];
  
  $c = ",";
  
  $sql = "INSERT INTO tbl_purchases (menuID, invoiceNo, xprice, xqty, xtotal) VALUES ";
    for ($i = 0; $i < count($cart); $i++){
        if($i == (count($cart)-1)){
          $c = ";";
        }
        $item_code = $cart[$i]['element']['item_code'];
        $price = $cart[$i]['element']['price'];
        $quantity = $cart[$i]['element']['qty'];
        $total = $cart[$i]['element']['total'];
        $sql = $sql . "($item_code, '$invoice', $price, $quantity , $total)" . $c;
    }

  $result_menu = $db->prepare($sql);
  $result_menu->execute(array());

  
  $sql = "INSERT INTO tbl_payment (invoiceNo, xtotal, cash, subtotal, salestax, disNo, staffid,shiftCode) VALUES ('$invoice', $nonvattotal, $cash, $totalAmount, $vat, '$discount', $employee, $shiftCode);";

  $result_menu = $db->prepare($sql);
  $result_menu->execute(array());
  
  
  $result_category = $db->prepare("SELECT * FROM tbl_payment ORDER BY ID DESC LIMIT 1");
  $result_category->execute();
  for ($i = 1; $row = $result_category->fetch(); $i++) {
    $_SESSION['invoiceNo'] = "";
    $_SESSION['invoiceNo'] = date('Ymd').$_SESSION['userID'].number_format(substr($row[1], -3)+1);
  }
  
  if($_SESSION['role'] == "staff"){
    $sql = "UPDATE `tbl_shift` SET `totalSales`= `totalSales` + $totalAmount,`totalTransactions`= `totalTransactions` + 1, `commission` = IF((`totalSales` + $totalAmount) > 7999 , .10, .07) WHERE `endShift` IS NULL AND employeeId = $employee";

    $result_menu = $db->prepare($sql);
    $result_menu->execute(array());
  }
  
  $sql = "DELETE FROM  tbl_cart";
  $q = $db->prepare($sql);
  $q->execute(array());
  
  exit();
//   print_r($sql);
}

?>