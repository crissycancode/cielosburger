<?php include_once('../connect.php');


if (!empty($_GET['menuid'])) { //addCart
    if ($_GET['do'] == 'addCart') {
        $menuid = $_GET['menuid'];
        $qty = 1;
        $price = $_GET['price'];
        $invoiceNo = $_SESSION['invoiceNo'];


        $result = $db->prepare("SELECT *,p.id as purchId,p.xprice as price FROM tbl_menu m INNER JOIN tbl_purchases p ON m.id=p.menuid WHERE m.id='$menuid' AND p.invoiceNo='$invoiceNo'");
        $result->execute();
        if ($row = $result->fetch()) {
            $purchId = $row['purchId'];
            $price = $row['price'];
            $newqty = $qty + $row['xqty'];

            $sql = "UPDATE tbl_purchases  SET  xqty=?, xprice=?, xtotal=? WHERE id=?";
            $q = $db->prepare($sql);
            $q->execute(array($newqty, $price, $newqty * $price, $purchId));

           // $message = "Order successfully updated.";
            echo "<script type='text/javascript'>history.go(-1);</script>";
        } else {

            $sql = "INSERT INTO tbl_purchases(invoiceNo,menuid,xprice,xqty,xtotal) VALUES (?,?,?,?,?)";
            $q = $db->prepare($sql);
            $q->execute(array($invoiceNo, $menuid, $price, $qty, $price * $qty));


            //$message = "Order successfully submitted.";
            echo "<script type='text/javascript'>history.go(-1);</script>";

        }
    }
}



if ($_GET['do']=='menuPlus') { //Cashier Remove
    $invoiceNo=$_SESSION['invoiceNo'];
    $menuID=$_GET['menuID'];
    $xqty=$_GET['qty']+1;
    $xtotal=$_GET['xtotal']+$_GET['xprice'];

    $sql = "UPDATE  tbl_purchases  SET xqty='$xqty',xtotal='$xtotal' WHERE invoiceNo='$invoiceNo'  AND menuID='$menuID'";
    $q = $db->prepare($sql);
    $q->execute(array());
    header("location: ../pos.php");
}

if ($_GET['do']=='menuMinus') { //Cashier Remove
    $invoiceNo=$_SESSION['invoiceNo'];
    $menuID=$_GET['menuID'];
    $xqty=$_GET['qty']-1;
    $xtotal=$_GET['xtotal']-$_GET['xprice'];

    if($_GET['qty']=='1'){
        $sql = "DELETE FROM  tbl_purchases  WHERE invoiceNo='$invoiceNo'  AND menuID='$menuID'";
        $q = $db->prepare($sql);
        $q->execute(array());
    }else{
        $sql = "UPDATE  tbl_purchases  SET xqty='$xqty',xtotal='$xtotal' WHERE invoiceNo='$invoiceNo'  AND menuID='$menuID'";
        $q = $db->prepare($sql);
        $q->execute(array());
    }


    header("location: ../pos.php");
}

?>