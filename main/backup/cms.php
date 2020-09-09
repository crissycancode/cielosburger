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
            CMS
        </h1>
    </section>

    <!--  ``aboutIntro`, `profile`, `name`, ``, `bannerImg`, `mapFrame` -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <?php
                        $result = $db->prepare("SELECT * from tbl_companyinfo");
                        $result->execute();
                        if ($row = $result->fetch()) { ?>
                            <form action="modal/content.php?do=update" method="post">
                                <button type="submit" name="submit3" class="btn btn-primary pull-right btn-m"><i
                                            class="icon icon-save icon-large fa fa-pencil"></i> Update
                                </button>
                                <br/>
                                <label style="color: red;font-size:20px;">Mission</label>
                                <textarea required class="textarea" name="mission"
                                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $row['mission']; ?></textarea>

                                <label style="color: red;font-size:20px;">Vision</label>
                                <textarea required class="textarea" name="vision"
                                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $row['vision']; ?></textarea>
                                <label style="color: red;font-size:20px;">Terms and Condition</label>
                                <textarea required class="textarea" name="termsCondi" placeholder="Terms and Condition"
                                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $row['termsCondi']; ?></textarea>

                                <label style="color: red;font-size:20px;">About Us</label>
                                <textarea required class="textarea" name="aboutUs" placeholder="About Us"
                                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $row['aboutUs']; ?></textarea>

                                <div class="form-group"><label style="color: red;font-size:20px;">Address</label>
                                    <input required value="<?php echo $row['address']; ?>" type="text"
                                           class="form-control" name="address" placeholder="Address" required>
                                </div>
                                <div class="form-group"><label style="color: red;font-size:20px;">Contact</label>
                                    <input required value="<?php echo $row['contact']; ?>" type="text"
                                           class="form-control" name="contact" placeholder="Contact #" required>
                                </div>
                                <div class="form-group"><label style="color: red;font-size:20px;">Quotation</label>
                                    <input required value="<?php echo $row['quotation']; ?>" type="text"
                                           class="form-control" name="quotation" placeholder="Quotation" required>
                                </div>
                                <div class="form-group"><label style="color: red;font-size:20px;">Email</label>
                                    <input required value="<?php echo $row['email']; ?>" type="text"
                                           class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </form>
                        <?php } ?>
                        <div class="hidden">

                            <input type="hidden" value="<?php echo $row['email']; ?>" type="text" class="form-control"
                                   name="editor1">
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include_once('layout/footer.php');
include_once('layout/buttomscript.php');
?>