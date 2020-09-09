<?php
include_once('connect.php');
include_once('layout/head.php');
include_once('layout/header.php');
include_once('layout/sidebar.php');
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Report
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header">
                            <!-- /result -->
                            <a class="box-title">  <?php if (isset($_GET['r'])): ?>
                                    <?php
                                    $r = $_GET['r'];
                                    if ($r == 'added') {
                                        $classs = 'success';
                                    } else if ($r == 'updated') {
                                        $classs = 'info';
                                    } else if ($r == 'deleted') {
                                        $classs = 'danger';
                                    } else {
                                        $classs = 'hide';
                                    }
                                    ?>
                                    <div class="alert alert-<?php echo $classs ?> <?php echo $classs; ?>">
                                        <strong>Successfully <?php echo $r; ?>!</strong>
                                    </div>
                                <?php endif; ?></a>

                            <form action="report.php" method="get">
                                <center><strong>From : <input type="date" name="d1" class="tcal"
                                                              value="<?php if (isset($_GET['d1'])) {
                                                                  echo $_GET['d1'];
                                                              } ?>"/> To: <input type="date" name="d2" class="tcal"
                                                                                 value="<?php if (isset($_GET['d2'])) {
                                                                                     echo $_GET['d2'];
                                                                                 } ?>"/>
                                        <?php if ($_SESSION['role'] == 'Admin') { ?>
                                            <input value="<?= $_SESSION['shiftCode']; ?>" type="text" name="shiftCode"
                                                   readonly>
                                            <a href="reportPrint.php?d1=<?php echo $_GET['d1']; ?>&d2=<?php echo $_GET['d2']; ?>"
                                               target="_blank" type="submit" class="btn btn-primary pull-right btn-sm "><i
                                                        class="fa fa-print"> </i> Print</a>
                                        <?php } else { ?>

                                        <?php } ?>
                                        <button mycart="" data-toggle="modal" type="submit"
                                                class="btn btn-primary pull-right btn-sm "><i class="fa fa-user"> </i>
                                            Show
                                        </button>
                                    </strong></center>
                            </form>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice #</th>
                                    <th>QTY</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                
                                if (isset($_GET['d1'])) {
                                    $d1 = $_GET['d1'];
                                    $d2 = $_GET['d2'];
                                    $result = $db->prepare("SELECT *,SUM(xprice)xprice,SUM(xqty)xqty,SUM(xtotal)xtotal,p.dt as dt FROM tbl_purchases p INNER JOIN tbl_menu m ON m.id=p.menuID WHERE xfinished='1' AND p.dt BETWEEN '$d1' AND '$d2' GROUP BY invoiceNo ORDER BY p.id DESC");
                                } else {
                                    $result = $db->prepare("SELECT *,SUM(xprice)xprice,SUM(xqty)xqty,SUM(xtotal)xtotal,p.dt as dt FROM tbl_purchases  p INNER JOIN tbl_menu m ON m.id=p.menuID WHERE xfinished='1' GROUP BY invoiceNo ORDER BY p.id DESC");
                                }
                                $result->execute();
                                for ($i = 1; $row = $result->fetch(); $i++) {
                                    $id = $row['id']; ?>
                                    <tr>
                                        <td> <?php echo $i; ?></td>
                                        <td><a target="_BLANK"
                                               href="billing-print.php?invoiceNo=<?php echo $row['invoiceNo']; ?>&cat=1"> <?php echo $row['invoiceNo']; ?></a>
                                        </td>
                                        <td> <?php echo $row['xqty']; ?></td>
                                        <td> <?php echo $row['xtotal']; ?></td>
                                        <td> <?php echo $row['dt']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
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