<?php
  include_once('connect.php');
  include_once('layout/head.php');
  include_once('layout/header.php');
  include_once('layout/sidebar.php');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Report</h1>
    <span id="role" hidden><?php echo $_SESSION['role']; ?></span>
    <span id="userid" hidden><?php echo $_SESSION['userID']; ?></span>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-warning">
          <div class="box-header">
            <!--<form >-->
              <strong>
                <div class="form-group" >
                  <span>From : </span>
                  <input type="date" id= "d1" name="d1" class="tcal" value="<?php if (isset($_GET['d1'])) { echo $_GET['d1']; } ?>"/> 
                  <span>&nbsp; &nbsp;To : </span> 
                  <input type="date" id= "d2" name="d2" class="tcal" value="<?php if (isset($_GET['d2'])) { echo $_GET['d2']; } ?>"/>
                  <span>&nbsp; &nbsp; &nbsp;</span>
                <?php 
                  if($_SESSION['role'] == 'admin'){ ?>
                    <span>Employee: </span> 
                    <!-- <input type="hidden" id="thisUser" name= "thisUser"></input>  -->
                    <select name="user" id="employee" required>
                    <option value="all">--ALL--</option>
                    <?php
                    $result = $db->prepare("SELECT * FROM tbl_users");
                    $result->execute();
                    for ($i = 0; $rows = $result->fetch(); $i++) { ?>
                      <option value="<?php echo $rows['id']; ?>"><?php echo $rows['lname'].", ".$rows['fname']; ?></option>
                    <?php } ?>
                    </select>
                  <?php } ?>
                    <span>&nbsp; &nbsp; &nbsp;</span>
                    <span>&nbsp;</span>
                  <?php if ($_SESSION['role'] == 'admin') { ?>
                    <button class="btn btn-primary  btn-sm" id ="btnPrint">
                      <i class="fa fa-print"></i>
                      Print
                    </button>
                    <?php }?>
                  
                </div>
                <div class="form-group">
                  <span>Total: </span> 
                  <input type="number" id= "totalSales" value="" name="" readonly />
                  <span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Commission: </span> 
                  <input type="number" id= "totalCommission" value="" name="" readonly/>
                </div>
              </strong>
            <!--</form>-->
          </div>
          <div class="box-body" id ="printableArea">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Employee</th>
                    <th>Commission</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- invoice details -->
<div class="modal fade" id="invoiceDetail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <div class="box-body">
          <form class="form-horizontal" action="" method="get" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-2 control-label">Invoice:</label>
              <div class="col-sm-10">
                <input value="" type="text" class="form-control" id="invoice-number" name="invoice-number" placeholder="invoice number" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Date:</label>
              <div class="col-sm-10">
                <input value="" type="text" class="form-control" id ="invoice-date" name="invoice-date" placeholder="date" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Cashier:</label>
              <div class="col-sm-10">
                <input value="" id ="invoice-cashier" type="text" class="form-control" name="invoice-cashier" placeholder="cashier" readonly>
              </div>
            </div>
            <div class="form-group">
              <table id="modalTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <!--<th>code</th>-->
                  <th>name</th>
                  <th>price</th>
                  <th>qty</th>
                  <th>total</th>
                </tr>
              </thead>
              <tbody id="orderbody">
              </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<?php 
  include_once('layout/footer.php');
  include_once('layout/buttomscript.php');
?>

<script type="text/javascript" src="./report.js"></script>