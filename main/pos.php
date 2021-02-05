<?php
  include_once('connect.php');
  include_once('layout/head.php');
  include_once('layout/header.php');
  include_once('layout/sidebar.php');
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Point Of Sale</h1>
    <h4>Invoice No.</h4><h4><?= $_SESSION['invoiceNo']; ?></h4>
    <p id="shiftCode" hidden><?= $_SESSION['timedin']; ?></p>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-warning">
          <div class="box-body pad">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <!--<th>#</th>-->
                        <th>item_code</th>
                        <th>image</th>
                        <th>name</th>
                        <th>price</th>
                        <th>qty</th>
                        <th>total</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div> <!-- /.table responsive -->
                <nav>
                  <div id = "menutable" class="panel with-nav-tabs panel-warning panel-responsive">
                    <div class="panel-heading">
                      <ul class="nav nav-tabs category" id="category">
                      </ul>
                    </div> <!-- /.panel-heading -->
                    <div class="panel-body tab-content" id="menu">
                    </div> <!-- /.panel-body -->
                  </div> <!-- /.panel with-nav-tabs panel-warning panel-responsive -->
                </nav>
              </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->
          </div> <!-- /.box-body pad -->
        </div> <!-- /.box box-warning -->
      </div><!-- /.col-md-12-->
    </div> <!-- /.row-->
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-warning">
          <div class="box-body">
            <!-- <form action="modal/modals.php"  method="POST"> -->
            <!--<form action=""  method="POST">-->
              <div class="table-responsive">
                <table class="table table-bordered ">
                  <thead>
                    <tr>
                      <th style="width: 50%">Invoice #:<?= $_SESSION['invoiceNo']; ?></th>
                      <th style="width: 50%">Item(s): <span id ="totalQty"></span></th>
                    </tr>
                  </thead
                  <tr>
                    <td style="width: 35%">Sales without VAT:</td>
                    <td id="nonVATSale"></td>
                  </tr>
                  <tr>
                    <td style="width: 35%">12% VAT:</td>
                    <td id="VAT"></td>
                  </tr>
                  <tr>
                    <td style="width: 35%">Sales with VAT:</td>
                    <td id="salesVAT"></td>
                  </tr>
                  <tr>
                    <td style="width: 35%">Senior/PWD Discount:</td>
                    <td>
                      <span id="discount"></span> 
                      &nbsp; &nbsp; &nbsp; 
                      <input type="checkbox" id="checkDiscount" />
                    </td>
                  </tr>
                  <tr>
                    <th>Total Due:</th>
                    <th id="totalDue"></th>
                  </tr>
                  <tr>
                    <th>Cash:</th>
                    <th>
                      <input type="number" id="cash">
                    </th>
                  </tr>
                  <tr>
                    <th>Change:</th>
                    <th id="change">00.00</th>
                  </tr>
                  <tr>
                    <th style="width: 35%"></th>
                    <th>
                      <button id="submit" class="btn btn-success">submit</button>
                      <button id="clear" class="btn btn-warning">clear</button>
                    </th>
                  </tr>
                </table>
              </div>
              <br/>
            <!--</form>-->
          </div><!-- /.box-body -->
        </div> <!-- /.box box-warning -->
      </div> <!-- /.col-xs-12 -->
    </div> <!-- /.row -->
  </section> 
</div> <!-- /.content-wrapper -->
<?php 
  include_once('layout/footer.php');
  include_once('layout/buttomscript.php');
?>

<script type="text/javascript" src="./pos.js"></script>