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

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <!--  //http://localhost/pos/main/generated-report.php?d1=2020-04-01&d2=2020-04-30&type=Daily&cat=Sales-->
                        <form action="generated-report.php" method="GET">


                            <input name="" value="<?php if (isset($_GET['type'])) {
                                echo $_GET['type'];
                            } ?>" type="hidden">
                            <div class="form-group">
                                <label>Report Type:</label>
                                <select class="form-control"
                                        onchange="if (this.value) window.location.href=this.value">
                                    <option>-Select Type-</option>
                                    <option <?php if (isset($_GET['type'])) {
                                        if ($_GET['type'] == 'Daily') {
                                            echo "selected";
                                        }
                                    } ?> value="generate-report.php?type=Daily">Daily
                                    </option>
                                    <option <?php if (isset($_GET['type'])) {
                                        if ($_GET['type'] == 'Weekly') {
                                            echo "selected";
                                        }
                                    } ?> value="generate-report.php?type=Weekly">Weekly
                                    </option>
                                    <option <?php if (isset($_GET['type'])) {
                                        if ($_GET['type'] == 'Monthly') {
                                            echo "selected";
                                        }
                                    } ?> value="generate-report.php?type=Monthly">Monthly
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Category:</label>
                                <select class="form-control" name="cat">
                                    <option>-Select Category-</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Commission">Commission</option>
                                </select>
                            </div>


                            <?php if (isset($_GET['type'])) { ?>


                                <div class="form-group">
                                    <label>Date From:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="d1" type="text" placeholder="YYYY/MM/DD"
                                               class="form-control pull-right" id="datepickerF">
                                    </div>
                                    <!-- /.input group -->
                                </div>


                                <?php if (($_GET['type'] == 'Weekly')) { ?>
                                    <div class="form-group">
                                        <label>Date To:</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="d2" type="text" placeholder="YYYY/MM/DD" class="form-control pull-right"
                                                   id="datepickerT">
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                <?php }
                            } ?>

                            <button type="submit" class="btn btn-primary pull-right btn-m "><i class="fa fa-plus"> </i>
                                Generate
                            </button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


</div>

<?php include_once('layout/footer.php');
include_once('layout/buttomscript.php');
?>

<script>
    <?php if (($_GET['type'] == 'Daily')) { ?>
    $('#datepickerF,#datepickerT').datepicker({
        placeholder: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom left",
        format: 'yyyy-mm-dd',
    });
    <?php }elseif (($_GET['type'] == 'Weekly')) { ?>
    $('#datepickerF,#datepickerT').datepicker({
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom left",
        format: 'yyyy-mm-dd',
    });
    <?php }elseif (($_GET['type'] == 'Monthly')) { ?>
    $('#datepickerF,#datepickerT').datepicker({
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom left",
        format: 'yyyy-mm',
    });
    <?php } ?>

</script>

