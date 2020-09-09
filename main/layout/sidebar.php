<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/images/<?php echo $_SESSION['pic']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> <?php echo $_SESSION['fullname']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <hr/>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <?php if ($_SESSION['role'] == 'Admin') { ?>
                <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


                <li><a href="user.php"><i class="fa fa-user"></i> <span>Accounts</span></a></li>
                <li><a href="menu.php"><i class="fa fa-file-text"></i> <span>Menu</span></a></li>
                <li><a href="pos.php"><i class="fa fa-shopping-cart"></i><span>POS   </span></a></li>

                <li><a href="ualt.php"><i class="fa fa-group "></i> <span>User Logs</span></a></li>

                <li><a href="generate-report.php"><i class="fa fa-print"></i><span>Report   </span></a></li>

            <?php } else { ?>
                <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="menu.php"><i class="fa fa-file-text"></i> <span>Menu</span></a></li>
                <li><a href="pos.php"><i class="fa fa-shopping-cart"></i><span>POS   </span></a></li>
            <?php } ?>


            <li><a href="modal/user.php?do=logout" onclick="return  confirm('Do you want to logout ?')"><i
                            class="fa fa-sign-out"></i> <span>Log Out</span></a></li>

        </ul>


    </section>
    <!-- /.sidebar -->
</aside>