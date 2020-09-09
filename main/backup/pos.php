<?php
include_once('connect.php');
include_once('layout/head.php');
include_once('layout/header.php');
include_once('layout/sidebar.php');
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Point Of Sales - <?= $_SESSION['invoiceNo']; ?>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">


                    <!-- /.box -->

                    <div class="box box-warning">
                        <div class="box-header">
                        </div>


                        <!-- /.box-header -->
                        <div class="box-body pad">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>QTY</th>
                                                <th>Total</th>
                                                <!--                                        <th>Action</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $totalQty = 0;
                                            $totalPrice = 0;
                                            $invoiceNo = $_SESSION['invoiceNo'];
                                            $result = $db->prepare("select * from tbl_purchases p INNER JOIN tbl_menu m ON m.id=p.menuID where invoiceNo='$invoiceNo' AND xfinished<>1");
                                            $result->execute();
                                            for ($i = 0;
                                                 $row = $result->fetch();
                                                 $i++) { ?>

                                                <tr>
                                                    <td> <?= $orNo += 1; ?></td>
                                                    <td><img height="50" width="50"
                                                             src="assets/uploaded/<?= $row['imgUrl']; ?>">
                                                    </td>
                                                    <td><?= $row['name']; ?></td>
                                                    <td><?= $row['price']; ?></td>
                                                    <td>
                                                        <div id="item-add-3424329723" class="item-add">
                                                            <div style="left: -50%;">
                                                                <!-- <a title="Remove"  href="cart.php?cid=<?php echo $x;
                                                                $x = $x + 1; ?>" class="btn btn-danger rounded" >REMOVE </a><br/>  -->
                                                                <a href="modal/pos.php?do=menuPlus&menuID=<?= $row['id']; ?>&qty=<?= $row['xqty']; ?>&xprice=<?= $row['price']; ?>&xtotal=<?= $row['xtotal']; ?>"
                                                                   title="Add" class="btn btn-xs"> <img width="20px"
                                                                                                        height="20px"
                                                                                                        src="assets/images/plus.png"/> <?php echo $each_menu['quantity']; ?>
                                                                </a>
                                                                <?php echo $row['xqty'];
                                                                $totalQty += $row['xqty']; ?>
                                                                <?php if ($each_menu['quantity'] == '1') { ?>
                                                                <?php } else { ?>
                                                                    <a title="Minus"
                                                                    <a href="modal/pos.php?do=menuMinus&menuID=<?= $row['id']; ?>&qty=<?= $row['xqty']; ?>&xprice=<?= $row['price']; ?>&xtotal=<?= $row['xtotal']; ?>"
                                                                       class="btn btn-xs"> <img width="20px"
                                                                                                height="20px"
                                                                                                src="assets/images/minus.png"/></a>
                                                                    <!--        fa fa-minus-square    -->
                                                                <?php } ?>
                                                            </div>

                                                        </div>
                                                    </td>

                                                    <td><?php echo $row['xtotal'];
                                                        $totalPrice += $row['xtotal']; ?></td>
                                                    <!--                                            <td>-->
                                                    <!---->
                                                    <!--                                            </td>-->
                                                </tr>

                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="panel with-nav-tabs panel-warning panel-responsive">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">

                                                <?php
                                                $result = $db->prepare("SELECT * FROM tbl_category ");
                                                $result->execute();
                                                for ($i = 1; $row = $result->fetch(); $i++) {
                                                    $category = $row['category'];
                                                    $id = $row['id']; ?>
                                                    <li class="<?php if($i==1){ echo "active"; }?>"><a href="#<?= $id; ?>"
                                                                     data-toggle="tab"><?= $row['category']; ?>  </a>
                                                    </li>
                                                <?php } ?>
                                                <!--                                                --><?php //if($category=='Buy 1 Take 1'){ echo "active"; }?>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">

                                                <?php
                                                $result = $db->prepare("SELECT * FROM tbl_category ");
                                                $result->execute();
                                                for ($i = 1; $row = $result->fetch(); $i++) {
                                                    $category = $row['category'];
                                                    $id = $row['id']; ?>
                                                    <div class="tab-pane fade <?php if ($i == 1) {
                                                        echo "in active";
                                                    } ?>" id="<?= $id; ?>">
                                                        <!--                                                        TAB --><? //= $category; ?>

                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="list-group gallery">

                                                                    <?php
                                                                    $res = $db->prepare("SELECT * FROM tbl_menu WHERE category='$category' ORDER BY id DESC");
                                                                    $res->execute();
                                                                    for ($i = 1; $r = $res->fetch(); $i++) {
                                                                        $selected_id = $r['id']; ?>
                                                                        <div class="col-sm-4 col-xs-6 col-md-3 col-lg-3 ">
                                                                            <a href="modal/pos.php?do=addCart&menuid=<?= $r['id']; ?>&price=<?= $r['price']; ?>"
                                                                               class="thumbnail fancybox "
                                                                               rel="ligthbox"
                                                                            >
                                                                                <img class="img-responsive" alt=""
                                                                                     width="" height="100px"
                                                                                     src="assets/uploaded/<?= $r['imgUrl']; ?>">
                                                                                <div class="text-right">
                                                                                    <h4 class="text-muted"><?= $r['name']; ?></h4>
                                                                                </div> <!-- text-right / end -->
                                                                            </a>
                                                                        </div> <!-- col-6 / end -->
                                                                    <?php } ?>

                                                                </div> <!-- list-group / end -->
                                                            </div> <!-- row / end -->
                                                        </div>


                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!--                            <div class="box-body">-->
                            <!--                                <a class="btn btn-app">-->
                            <!--                                    <span class="badge bg-teal">67</span>-->
                            <!--                                    <i class="fa fa-shopping-cart"></i> Order(s)-->
                            <!--                                </a>-->
                            <!--                            </div>-->


                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- ./row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header">
                            <!--                        <a mycart="" data-toggle="modal" data-target="#addDis" type="submit"-->
                            <!--                           class="btn btn-primary pull-right btn-m "><i class="fa fa-plus"> </i> Discount</a>-->

                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">


                            <form action="modal/modals.php" target="_BLANK" method="POST">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Invoice # : <?= $_SESSION['invoiceNo']; ?> <br/>

                                        <th> # Item(s) : <?= $_SESSION['sumQTY'] = $totalQty; ?> <br/> Total Price
                                            : <?= number_format($totalPrice, 2); ?> <br/>
                                        </th>
                                        <?php $_SESSION['totalbills'] = $totalPrice; ?>

                                    </tr>
                                    </thead>


                                    <td colspan="3">
                                        <hr/>
                                    </td>
                                    <?php if (!isset($_SESSION['totalbills'])) {
                                        $_SESSION['totalbills'] = '0';
                                    } ?>
                                    <tr>
                                        <td colspan="2">Sub Total : <!--  <?= $_GET['cusType']; ?> -->
                                        <td><?= number_format($_SESSION['totalbills'], 2); ?></td>
                                        </td></tr>
                                    <tr>
                                        <td colspan="2">VAT 12% :</td>
                                        <td><?= $_SESSION['vat12'] = number_format(($_SESSION['totalbills'] / 1.12) * 0.12, 2); ?></td>
                                    </tr>
                                    <tr>

                                        <td colspan="2">VAT Sales :</td>
                                        <td><?= $_SESSION['vatsale'] = number_format($_SESSION['totalbills'] / 1.12, 2); ?></td>
                                    </tr>


                                    <?php if ($_SESSION['cusType'] == 'Walk-in') { ?>
                                        <td colspan="3">
                                            <hr/>
                                        </td>

                                        <tr>
                                            <td colspan="2">Total :</td>
                                            <td><?= $_SESSION['total'] = number_format($_SESSION['totalbills'], 2); ?></td>

                                        </tr>

                                    <?php } else { ?>

                                        <tr>
                                            <td colspan="2">VAT Exempt : <?php echo $_SESSION['cusType']; ?>
                                            <td><?= $_SESSION['vatdis'] = number_format($_SESSION['totalbills'] * .20, 2); ?></td>
                                            </td></tr>
                                        <td colspan="3">
                                            <hr/>
                                        </td>

                                        <tr>
                                            <td colspan="2">Total :</td>
                                            <td><?= $_SESSION['total'] = number_format($_SESSION['totalbills'], 2); ?></td>

                                        </tr>
                                    <?php } ?>
                                </table>


                                <br/>
                                Payment :
                                <input type="hidden" name="cusType"
                                       value="<?php if (isset($_SESSION['cusType'])) {
                                           echo $_SESSION['cusType'];
                                       } else echo 'Walk-in'; ?>">
                                <input type="hidden" name="disNo"
                                       value="<?php if (isset($_SESSION['disNo'])) {
                                           echo $_SESSION['disNo'];
                                       } ?>">
                                <input type="hidden" name="disName"
                                       value="<?php if (isset($_SESSION['disName'])) {
                                           echo $_SESSION['disName'];
                                       } ?>">

                                <input type="number" name="cash" min="<?= $_SESSION['total']; ?>">
                                <input type="hidden" name="do" value="savePayment">
                                <input type="submit" class="btn btn-success" name="submit">

                            </form>


                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </section>

    </div>
    <!-- /.content-wrapper -->


<?php include_once('layout/footer.php');
include_once('layout/buttomscript.php');
?>