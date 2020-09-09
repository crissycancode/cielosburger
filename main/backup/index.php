<?php
include_once('connect.php');
include_once('layout/head.php');
include_once('layout/header.php');
include_once('layout/sidebar.php');
include_once('modal/content.php');

$count=1;
$d = date('Ymd');
$result = $db->prepare("SELECT COALESCE(COUNT(*),0)  FROM tbl_payment  GROUP by invoiceNo"); //WHERE invoiceNo LIKE '%$table%'
$result->execute();
for($i=1; $row = $result->fetch(); $i++){
    $count=$i+1;
}
$invoiceNo=$d.$count.$_SESSION['userID'] ;
$_SESSION['invoiceNo']=$invoiceNo;

$shiftCode=$_SESSION['shiftCode'];

$result = $db->prepare("SELECT 
 (SELECT COUNT(*) FROM tbl_menu) AS totalMenu, 
  (SELECT COUNT(*) FROM tbl_users) AS totalUser  ,
  (SELECT COUNT(*) FROM tbl_users ) AS totalPurchases  ,
    (SELECT COUNT(*)c FROM tbl_payment WHERE shiftCode='$shiftCode') AS totalC  ,
  (SELECT SUM(xtotal)total FROM tbl_payment WHERE shiftCode='$shiftCode') AS totalPayment");
$result->execute();
if ($row = $result->fetch()) { ?>


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard <?=$invoiceNo.' - '.$shiftCode;?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
    <div class="col-xs-12">

    <div class="box box-warning">
    <div class="box-header">

    </div>
    <!-- /.box-header -->
    <div class="box-body">


    <?php if ($_SESSION['role'] == 'Admin') { ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $row['totalUser']; ?></h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="user.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $row['totalMenu']; ?></h3>
                    <p>Menu</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
                <a href="menu.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $row['totalPurchases']; ?></h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $row['totalC'].'/'.number_format($row['totalPayment'],2); ?></h3>

                    <p>Payment Received</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <a href="report.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    <?php }else{ ?>
<!--        P1000-P8800 = 7% total daily sales-->
<!--        plus 160 allowance-->
<!---->
<!--        P8801 and above = 10%-->
<!--        plus 160 allowance-->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                      <?=getCommission($row['totalPayment']);?>
                    </h3>
                    <p>Commission</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
                <a href="report.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $row['totalC'].'/'.number_format($row['totalPayment'],2); ?></h3>
                    <p>Daily Sales</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <a href="report.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


    <?php } ?>

<?php } ?>


    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->

    </div>



<?php include_once('layout/footer.php');
include_once('layout/buttomscript.php');
?>