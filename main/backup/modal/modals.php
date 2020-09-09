<?php
include_once('../connect.php');

if ($_POST['do'] == 'addDiscount') {
    $_SESSION['cusType'] = $_POST['cusType'];
    $_SESSION['disNo'] = $_POST['disNo'];
    $_SESSION['disName'] = $_POST['disName'];
    $message = "Discount successfully submitted.";
    echo "<script type='text/javascript'>alert('$message');window.location.href='../pos.php';</script>";
}


if ($_POST['do'] == 'savePayment') { //Save Payment
    $cartTotal = 0;
    $invoiceNo = $_SESSION['invoiceNo'];
    $totalbills = $_SESSION['totalbills'];
    $subtotal = number_format($_SESSION['totalbills'] / 1.12, 2);
    $salestax = number_format(($_SESSION['totalbills'] / 1.12) * 0.12, 2);

    $zero = '0';
    $cusType = $_POST['cusType'];
    if ($cusType == "Walk-in") {
        $sumDiscount = $zero;
    } else {
        $sumDiscount = $_SESSION['vatdis'];
        $totalbills = $totalbills - $_SESSION['vatdis'];
    }

    $cash = $_POST['cash'];
    $xtotal = $totalbills;
    $change = $cash - $xtotal;


    $disCat = $_POST['cusType'];
    $staffid = $_SESSION['userID'];
    $sql = "INSERT INTO tbl_payment( invoiceNo, sumTotal,sumDiscount, xtotal,cash, dt, received,subtotal,salestax,cusType,staffid,dtNow,sumQTY,shiftCode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($invoiceNo, $subtotal, $sumDiscount, $xtotal, $cash, $dt, '1', $subtotal, $salestax, $disCat, $staffid, $dtNow,$_SESSION['sumQTY'],$_SESSION['shiftCode']));


    $q = $db->prepare("UPDATE tbl_purchases set xfinished='1' WHERE invoiceNo='$invoiceNo'");
    $q->execute(array());
//New Customer -> Gen new invoice
    $oldinvoice=$_SESSION['invoiceNo'];
    $count=0;
    $d = date('Ymd');
    $result = $db->prepare("SELECT COALESCE(COUNT(*),0)  FROM tbl_payment  GROUP by invoiceNo"); //WHERE invoiceNo LIKE '%$table%'
    $result->execute();
    for($i=1; $row = $result->fetch(); $i++){
        $count=$i+1;
    }
    $invoiceNo=$d.$count ;
    $_SESSION['invoiceNo']=$invoiceNo;


    if ($change <> '0') {
        $message = "Change is : ";
        $message = $message . number_format($change, 2);
    } else {
        $message = "Thank you.";
    }
    $message;


    header("Location: ../billing-print.php?invoiceNo=" . $oldinvoice . "&cat=" . '1');
    exit();
}


?>