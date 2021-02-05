<?php 
  include_once('../connect.php');
  if($_GET['do'] == 'id'){
    $to = $_POST['to']." 23:59:00";
    $from = $_POST['from']." 00:00:00";
    $staff = $_SESSION['userID'];
    $role = $_SESSION['role'];
    $data = array();
    $staffId = $_POST['id'];

    if($role == "admin"){
      if($staffId != "all"){
        $result_menu = $db->prepare("SELECT tbl_payment.dateTime AS purchasedate, tbl_payment.invoiceNo AS invoice, tbl_payment.subtotal AS total, tbl_payment.staffid AS employee, tbl_users.fname AS firstname, tbl_users.lname AS lastname, IF(ISNULL(tbl_shift.commission) = 1,0, tbl_shift.commission * tbl_payment.subtotal) AS comm, (SELECT COUNT(1) AS qty FROM tbl_purchases WHERE tbl_payment.invoiceNo=tbl_purchases.invoiceNo) AS qty FROM `tbl_payment` LEFT JOIN tbl_shift ON tbl_payment.shiftCode = tbl_shift.id LEFT JOIN tbl_users ON tbl_payment.staffid = tbl_users.id WHERE tbl_payment.staffid = ".$staffId." AND dateTime BETWEEN '".$from."' AND '".$to."' ORDER BY tbl_payment.dateTime DESC");
      }else{

        $result_menu = $db->prepare("SELECT tbl_payment.dateTime AS purchasedate, tbl_payment.invoiceNo AS invoice, tbl_payment.subtotal AS total, tbl_payment.staffid AS employee, tbl_users.fname AS firstname, tbl_users.lname AS lastname, IF(ISNULL(tbl_shift.commission) = 1,0, tbl_shift.commission * tbl_payment.subtotal) AS comm, (SELECT COUNT(1) AS qty FROM tbl_purchases WHERE tbl_payment.invoiceNo=tbl_purchases.invoiceNo) AS qty FROM `tbl_payment` LEFT JOIN tbl_shift ON tbl_payment.shiftCode = tbl_shift.id LEFT JOIN tbl_users ON tbl_payment.staffid = tbl_users.id WHERE dateTime BETWEEN '".$from."' AND '".$to."' ORDER BY tbl_payment.dateTime DESC");
      }
      
    }else{
        $result_menu = $db->prepare("SELECT tbl_payment.dateTime AS purchasedate, tbl_payment.invoiceNo AS invoice, tbl_payment.subtotal AS total, tbl_payment.staffid AS employee, tbl_users.fname AS firstname, tbl_users.lname AS lastname, IF(ISNULL(tbl_shift.commission) = 1,0, tbl_shift.commission * tbl_payment.subtotal) AS comm, (SELECT COUNT(1) AS qty FROM tbl_purchases WHERE tbl_payment.invoiceNo=tbl_purchases.invoiceNo) AS qty FROM `tbl_payment` LEFT JOIN tbl_shift ON tbl_payment.shiftCode = tbl_shift.id LEFT JOIN tbl_users ON tbl_payment.staffid = tbl_users.id WHERE tbl_payment.staffid = ".$staff." AND dateTime BETWEEN '".$from."' AND '".$to."' ORDER BY tbl_payment.dateTime DESC");
        
        
    }
    
    $rows = array();
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      $rows[] = $row;
    }
    print json_encode($rows);
  }
  
//   SELECT tbl_payment.dateTime AS purchasedate, tbl_payment.invoiceNo AS invoice, tbl_payment.subtotal AS total, tbl_payment.staffid AS employee, tbl_users.fname AS firstname, tbl_users.lname AS lastname, tbl_shift.commission AS comm, (SELECT COUNT(1) AS qty FROM tbl_purchases WHERE tbl_payment.invoiceNo=tbl_purchases.invoiceNo) AS qty FROM `tbl_payment` LEFT JOIN tbl_shift ON tbl_payment.staffid = tbl_shift.employeeId AND tbl_payment.dateTime BETWEEN tbl_shift.startShift AND tbl_shift.endShift INNER JOIN tbl_users ON tbl_payment.staffid = tbl_users.id WHERE tbl_payment.staffid = 30 AND dateTime BETWEEN '2021-01-05 23:36:13' AND '2021-01-10 22:27:03' ORDER BY tbl_payment.dateTime DESC
  
  if($_GET['do'] == 'invoice'){
    $invoice = $_POST['invoice'];
    $result_menu = $db->prepare("SELECT IF(tbl_menu.name IS NULL || tbl_menu.name = '','ITEM NO LONGER AVAILABLE', tbl_menu.name) AS item, tbl_purchases.menuID AS menuid, COUNT(tbl_purchases.menuID) AS count, IF (COUNT(tbl_purchases.menuID) > 1, SUM(tbl_purchases.xqty), tbl_purchases.xqty) AS qty, tbl_purchases.xprice AS price, tbl_purchases.dateTime AS date, tbl_purchases.xtotal AS total FROM tbl_purchases LEFT JOIN tbl_menu ON tbl_purchases.menuID = tbl_menu.id WHERE invoiceNo = '".$invoice."' GROUP BY tbl_purchases.menuID");
    $rows = array();
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      $rows[] = $row;
    }
    print json_encode($rows);
  }
  
  
  
  
//   SELECT IF(tbl_menu.name IS NULL || tbl_menu.name = '','ITEM NO LONGER AVAILABLE', tbl_menu.name) AS item, tbl_purchases.menuID AS menuid, COUNT(tbl_purchases.menuID) AS count, tbl_purchases.xqty AS qty, tbl_purchases.xprice AS price, tbl_purchases.dateTime AS date, tbl_purchases.xtotal AS total FROM tbl_purchases LEFT JOIN tbl_menu ON tbl_purchases.menuID = tbl_menu.id WHERE invoiceNo = '2021010667286' GROUP BY tbl_purchases.menuID

//   if($_GET['do'] == 'invoice'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       unset($_SESSION['orderInvoice']);
//       $_SESSION['orderInvoice'] = $row[1];
//       echo $row[1];
//     }
//   }
//   if($_GET['do'] == 'quantity'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT COUNT(*) as qty FROM tbl_purchases WHERE invoiceNo = ".$_SESSION['orderInvoice']."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//         if($row['qty'] == NULL){
//             $row['qty'] = 0;
//         }
//       echo $row['qty'];
//     }
//   }
//   if($_GET['do'] == 'total'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[6];
//     }
//   }
//   if($_GET['do'] == 'commission'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[3] * .10;
//     }
//   }
//   if($_GET['do'] == 'date'){
//     $id = $_POST['id'];
//     // $id = str_replace('%0D%0A275', '', $id);
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[4];
//     }
//   }
//   if($_GET['do'] == 'employee'){
//     $id = $_POST['id'];
//     $data;
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       $data = $row[10];
//     }
//     if($data != NULL){
//       $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$data."");
//       $result_menu->execute();
//       for ($i = 1; $row = $result_menu->fetch(); $i++) {
//         echo $row[2].", ".$row[1];
//       }
//     }else{
//       echo "--";
//     }
//   }

//   // show invoice details
//   if($_GET['do'] == 'orderDetails'){
//     $id = $_POST['id'];
//     $data = array();
//     $result_menu = $db->prepare("SELECT * FROM tbl_purchases WHERE invoiceNo = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       array_push($data,$row[1]."/");
//     }
//     echo implode($data);
//   }
//   if($_GET['do'] == 'orderDate'){
//     $invoice = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE invoiceNo = ".$invoice."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       unset($_SESSION['orderDate']);
//       $_SESSION['orderDate'] = $row[4];
//       echo $row[4];
//     }
//   }
//   if($_GET['do'] == 'orderCashier'){
    
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE invoiceNo = ".$id."");
//     $result_menu->execute();
//     $data;
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       $data = $row['staffid'];
//     }

//     if($_SESSION['role'] != "admin"){
//       $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$_SESSION['userID']."");
//     }else{
//       $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$data."");
//     }
    
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       $_SESSION['cashier'] ="";
//       $_SESSION['cashier'] = $row[2].", ".$row[1];
//       echo $row[2].", ".$row[1];
//     }

//   }
// // ORDER DETAILS: Menu Items

//   if($_GET['do'] == 'image'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[6];
//     }
//   }
//   if($_GET['do'] == 'name'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//         if($row[2] != ""){
//             echo $row[2];
//         }
      
//     }
//   }
//   if($_GET['do'] == 'price'){
//     $id = $_POST['id'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[4];
//     }
//   }
//   if($_GET['do'] == 'itemQty'){
//     $id = $_POST['id'];
//     $invoice = $_POST['invoice'];
//     $result_menu = $db->prepare("SELECT * FROM tbl_purchases WHERE menuId = ".$id." and invoiceNo=".$invoice."");
//     $result_menu->execute();
//     for ($i = 1; $row = $result_menu->fetch(); $i++) {
//       echo $row[4];
//     }
//   }
?>