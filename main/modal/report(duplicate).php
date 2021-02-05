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
        $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE staffid = ".$staffId." AND dateTime BETWEEN '" .$from. "' AND '" .$to. "' ORDER BY dateTime DESC");
       
      }else{
        $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE dateTime BETWEEN '" .$from. "' AND '" .$to. "' ORDER BY dateTime DESC");
      }
      
    }else{
      $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE staffid = ".$staff." AND dateTime BETWEEN '" .$from. "' AND '" .$to. "' ORDER BY dateTime DESC");
    }
    
    $result_menu->execute();
    
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      array_push($data,$row[0]."/");
      
    }
    echo implode($data);
  }


  if($_GET['do'] == 'invoice'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      unset($_SESSION['orderInvoice']);
      $_SESSION['orderInvoice'] = $row[1];
      echo $row[1];
    }
  }
  if($_GET['do'] == 'quantity'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT COUNT(*) as qty FROM tbl_purchases WHERE invoiceNo = ".$_SESSION['orderInvoice']."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
        if($row['qty'] == NULL){
            $row['qty'] = 0;
        }
      echo $row['qty'];
    }
  }
  if($_GET['do'] == 'total'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[6];
    }
  }
  if($_GET['do'] == 'commission'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[3] * .10;
    }
  }
  if($_GET['do'] == 'date'){
    $id = $_POST['id'];
    // $id = str_replace('%0D%0A275', '', $id);
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[4];
    }
  }
  if($_GET['do'] == 'employee'){
    $id = $_POST['id'];
    $data;
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      $data = $row[10];
    }
    if($data != NULL){
      $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$data."");
      $result_menu->execute();
      for ($i = 1; $row = $result_menu->fetch(); $i++) {
        echo $row[2].", ".$row[1];
      }
    }else{
      echo "--";
    }
  }

  // show invoice details
  if($_GET['do'] == 'orderDetails'){
    $id = $_POST['id'];
    $data = array();
    $result_menu = $db->prepare("SELECT * FROM tbl_purchases WHERE invoiceNo = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      array_push($data,$row[1]."/");
    }
    echo implode($data);
  }
  if($_GET['do'] == 'orderDate'){
    $invoice = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE invoiceNo = ".$invoice."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      unset($_SESSION['orderDate']);
      $_SESSION['orderDate'] = $row[4];
      echo $row[4];
    }
  }
  if($_GET['do'] == 'orderCashier'){
    
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_payment WHERE invoiceNo = ".$id."");
    $result_menu->execute();
    $data;
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      $data = $row['staffid'];
    }

    if($_SESSION['role'] != "admin"){
      $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$_SESSION['userID']."");
    }else{
      $result_menu = $db->prepare("SELECT * FROM tbl_users WHERE id = ".$data."");
    }
    
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      $_SESSION['cashier'] ="";
      $_SESSION['cashier'] = $row[2].", ".$row[1];
      echo $row[2].", ".$row[1];
    }

  }
// ORDER DETAILS: Menu Items

  if($_GET['do'] == 'image'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[6];
    }
  }
  if($_GET['do'] == 'name'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
        if($row[2] != ""){
            echo $row[2];
        }
      
    }
  }
  if($_GET['do'] == 'price'){
    $id = $_POST['id'];
    $result_menu = $db->prepare("SELECT * FROM tbl_menu WHERE id = ".$id."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[4];
    }
  }
  if($_GET['do'] == 'itemQty'){
    $id = $_POST['id'];
    $invoice = $_POST['invoice'];
    $result_menu = $db->prepare("SELECT * FROM tbl_purchases WHERE menuId = ".$id." and invoiceNo=".$invoice."");
    $result_menu->execute();
    for ($i = 1; $row = $result_menu->fetch(); $i++) {
      echo $row[4];
    }
  }
?>