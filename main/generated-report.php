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
                            <?php if ($_GET['type'] == 'Weekly') { ?>
                                <a href="reportPrint.php?d1=<?= $_GET['d1']; ?>&d2=<?= $_GET['d2']; ?>&type=<?= $_GET['type']; ?>&cat=<?= $_GET['cat']; ?>"
                                   target="_blank" type="submit" class="btn btn-primary pull-right btn-sm "><i
                                            class="fa fa-print"> </i> Print</a>
                            <?php } else { ?>
                                <a href="reportPrint.php?d1=<?= $_GET['d1']; ?>&type=<?= $_GET['type']; ?>&cat=<?= $_GET['cat']; ?>"
                                   target="_blank" type="submit" class="btn btn-primary pull-right btn-sm "><i
                                            class="fa fa-print"> </i> Print</a>
                            <?php } ?>

                        </div>



                        <?php
                        //http://localhost/pos/main/generated-report.php?d1=2020-04-01&d2=2020-04-30&type=Daily&cat=Sales
                        //http://localhost/pos/main/generated-report.php?d1=2019-04-01&d2=2020-04-30&type=Weekly&cat=Commission
                        if ($_GET['cat'] == 'Commission') {
                            $str = "Shift Code";
                            $groupBy = ' GROUP BY shiftCode';
                        } elseif ($_GET['cat'] == 'Sales') {
                            $str = "Invoice No.";
                            $groupBy = ' GROUP BY invoiceNo';
                        }
                        if ($_GET['type'] == 'Weekly') {
                            $d1 = $_GET['d1'];
                            $d2 = $_GET['d2'];
                            $where = " WHERE  p.dtNow BETWEEN '$d1' AND '$d2'";
                        } else {
                            $d1 = $_GET['d1'];
                            $where = " WHERE  p.dt LIKE '%$d1%'";
                        } ?>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= $str; ?></th>
                                    <th>QTY</th>
                                    <th>Total</th>
                                    <?php if ($_GET['cat'] == 'Commission') {
                                        echo "<td> Commission </td>";
                                    } ?>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                  $where;
                                  $groupBy;
                                $result = $db->prepare("SELECT *,SUM(sumTotal)xtotal,SUM(sumQTY)xqty FROM tbl_payment p  $where $groupBy ORDER BY p.id DESC");

                                $result->execute();
                                for ($i = 1; $row = $result->fetch(); $i++) {
                                    $id = $row['id']; ?>
                                    <tr>
                                        <?php if ($_GET['cat'] == 'Sales') { ?>
                                            <td> <?= $i; ?></td>
                                            <td><a target="_BLANK"
                                                   href="billing-print.php?invoiceNo=<?= $row['invoiceNo']; ?>&cat=1"> <?= $row['invoiceNo']; ?></a>
                                            </td>
                                            <td> <?= $row['xqty']; ?></td>
                                            <td> <?= $row['xtotal']; ?></td>
                                            <td> <?= $row['dt']; ?></td>

                                        <?php } elseif ($_GET['cat'] == 'Commission') { ?>
                                            <td> <?= $i; ?></td>
                                            <td> <?= $row['shiftCode']; ?></td>
                                            <td> <?= $row['xqty']; ?></td>
                                            <td> <?= $row['xtotal']; ?></td>
                                            <td><?= getCommission($row['xtotal']); ?>
                                            <td> <?= $row['dt']; ?></td>
                                        <?php } ?>


                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
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