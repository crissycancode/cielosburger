<?php
  include_once('connect.php');
  include_once('layout/head.php');
  include_once('layout/header.php');
  include_once('layout/sidebar.php');

  $dateFrom = date('Y-m-d');
  $dateTo = date('Y-m-d', strtotime("+1 day"));

  if(isset($_SESSION['timedin'])){
    $dateFrom = date('Y-m-d', strtotime($_SESSION['timedin']));
    $dateTo = date('Y-m-d', strtotime("+1 day"));
  }

  $firstDayMonth = date('Y-m-01');
  $firstDayOfNextMonth= date('Y-m-01',strtotime("+1 month"));
  $result = $db->prepare("SELECT * FROM tbl_payment ORDER BY ID DESC LIMIT 1"); 
  $result->execute();

  for($i=0; $row = $result->fetch(); $i++){
    if(isset($_SESSION['userID'])){
        $_SESSION['invoiceNo'] = date('Ymd').$_SESSION['userID'].number_format($row[0]+1);
    }else{
        echo "<script type='text/javascript'>window.location.replace('http://www.cielosburger.online');</script>";
    }
    
  }

  $myId = $_SESSION['userID'];
  $result = $db->prepare("SELECT 
  (SELECT COUNT(*) FROM tbl_menu) AS totalMenu, 
  (SELECT COUNT(*) FROM tbl_users) AS totalUser  ,
  (SELECT COUNT(*) FROM tbl_users ) AS totalPurchases  ,
  (SELECT totalTransactions FROM tbl_shift WHERE employeeId='$myId' AND endShift IS NULL) AS totalC,
  (SELECT totalSales FROM tbl_shift WHERE employeeId='$myId' AND endShift IS NULL) AS totalPayment,
  (SELECT commission FROM tbl_shift WHERE employeeId='$myId' AND endShift IS NULL) AS totalCommission");
  $result->execute();
  if ($row = $result->fetch()) { 
?>

<div class="content-wrapper">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-warning">
        <div class="box-header"></div>
        <div class="box-body">
        <span id= "role" hidden><?php echo $_SESSION['role']; ?> </span>
    <?php if ($_SESSION['role'] == 'admin') { ?>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>Users (<?php echo $row['totalUser']; ?>)</h3>
                <p>User Accounts</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
              <a href="user.php" class="small-box-footer">
                More info 
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>Logs</h3>
                <p>User Logs</p>
              </div>
              <div class="icon">
                <i class="fa fa-clock-o"></i>
              </div>
              <a href="ualt.php" class="small-box-footer">
                More info 
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>Menu (<?php echo $row['totalMenu'];?>)</h3>
                <p>Menu List</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-basket"></i>
              </div>
              <a href="menu.php" class="small-box-footer">
                More info 
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>Sales</h3>
                <p>Sales Reports</p>
              </div>
              <div class="icon">
                <i class="fa fa-file-text"></i>
              </div>
              <a id = "salesreport" href="report.php?d1=<?=$firstDayMonth; ?>&d2=<?=$firstDayOfNextMonth; ?>&user=all" class="small-box-footer">
              <?php 
                echo date('Y-m-d');
               ?>
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
    <?php }else{ ?>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>Daily Shift</h3>
                <p>Time-in and Time-out</p>
              </div>
              <div class="icon">
                <i class="fa fa-clock-o"></i>
              </div>
              <a href="#" id ="myShift" class="small-box-footer" method="post">
              <?php if(isset($_SESSION['timedin']) && $_SESSION['timedin'] !="" ){
                echo date('Y-m-d h:i:s A', strtotime($_SESSION['timedin']));
                }else{
                    echo "Please time in.";
                } ?>
              <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>POS</h3>
                <p>Point of Sale</p>
              </div>
              <div class="icon">
                <i class="fa fa-cart-plus"></i>
              </div>
              <a href="pos.php" class="small-box-footer" on>
                More info 
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 id ="commission">
                <?php 
                  echo number_format(($row['totalPayment']*$row['totalCommission']),2).' ('.($row['totalCommission'] * 100).'%)';
                ?></h3>
                <p>Commission</p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              <a href="#" class="small-box-footer">
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo number_format($row['totalPayment'],2).'  ('.(0 + $row['totalC']).')'; ?></h3>
                <p>Daily Sales Report</p>
              </div>
              <div class="icon">
                <i class="fa fa-file-text"></i>
              </div>
              <a id = "reportLink" href="report.php?d1=<?=$dateFrom; ?>&d2=<?=$dateTo; ?>&user=<?=$_SESSION['userID']; ?>" class="small-box-footer">
              <?php if(isset($_SESSION['timedin'])){
                echo date('Y-m-d', strtotime($_SESSION['timedin']));
              } ?>
                <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
</div>
<?php 
  include_once('layout/footer.php');
  include_once('layout/buttomscript.php');
?>

<script type="text/javascript" src="./index2.js"></script>
