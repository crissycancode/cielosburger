<?php
include_once('connect.php');
?>
<body onload="window.print();">
<!--onload="window.print();"-->
<style media="print">
    @page {
        size: auto;
        margin: 0;
    }
</style>

<?php if ($_GET['cat'] == 'Commission') {
    $str = "Commission Report";
    $groupBy = ' GROUP BY shiftCode';
} elseif ($_GET['cat'] == 'Sales') {
    $str = "Sales Invoice Report";
    $groupBy = ' GROUP BY invoiceNo';
}

if ($_GET['type'] == 'Weekly') {
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
    $where = " WHERE  p.dt BETWEEN '$d1' AND '$d2'";
    $dt=" From ".$d1." To ".$d2;
} else {
    $d1 = $_GET['d1'];
    $where = " WHERE  p.dt LIKE '%$d1%'";
    $dt=" Of ". $d1;
} ?>

<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>

                    <small class="pull-right">
                         <?=$str.' '.$dt;?>
                    </small>


                </h2>
            </div>
        </div>
        <!-- /.col -->
</div>


<style>
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
    }
</style>
<!-- Table row -->
<div class="row">
    <div class="col-xs-12 table-responsive">


        <table width="100%" class="table table-striped"  >
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


            $result = $db->prepare("SELECT *,SUM(sumTotal)xtotal,SUM(sumQTY)xqty FROM tbl_payment p  $where $groupBy ORDER BY p.id DESC");

            $result->execute();
            for ($i = 1; $row = $result->fetch(); $i++) {
                $id = $row['id']; ?>
                <tr>
                    <?php if ($_GET['cat'] == 'Sales') { ?>
                        <td> <?= $i; ?></td>
                        <td><?= $row['invoiceNo']; ?>  </td>
                        <td> <?= $row['xqty'];
                            $xtotalQty += $row['xqty']; ?>
                        </td>
                        <td> <?= $row['xtotal'];
                            $xtotalAmt += $row['xtotal']; ?>
                        </td>
                        <td> <?= $row['dt']; ?></td>

                    <?php } elseif ($_GET['cat'] == 'Commission') { ?>
                        <td> <?= $i; ?></td>
                        <td> <?= $row['shiftCode']; ?></td>
                        <td> <?= $row['xqty'];
                            $xtotalQty += $row['xqty']; ?>
                        </td>
                        <td> <?= $row['xtotal'];
                            $xtotalAmt += $row['xtotal']; ?>
                        </td>
                        <td><?= getCommission($row['xtotal']); ?>
                        <td> <?= $row['dt']; ?></td>
                    <?php } ?>


                </tr>
            <?php } ?>
            <tr>
              <td colspan="6">  . </td colspan="6">
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td><?= ($xtotalQty); ?></td>
                <td><?= number_format($xtotalAmt, 2); ?></td>
                <?php if ($_GET['cat'] == 'Commission') { ?>
                <td><?= number_format(getCommission($xtotalAmt), 2); ?></td>
                <?php }?>
                <td colspan="2"> </td>
            </tr>
            </tbody>
        </table>


    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


</section>
<!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html> 