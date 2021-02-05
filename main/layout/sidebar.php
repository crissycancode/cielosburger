<aside class="main-sidebar">
  <section class="sidebar">
    <hr style="margin:0px;" />
    <ul class="sidebar-menu">
      <?php if ($_SESSION['role'] == 'admin') { ?>
      <li><a href="index.php"><i class="fa fa-dashboard"></i><span>DASHBOARD</span></a></li>
      <li><a href="user.php"><i class="fa fa-user"></i><span>USERS</span></a></li>
      <li><a href="ualt.php"><i class="fa fa-group "></i><span>LOGS</span></a></li>
      <li><a href="menu.php"><i class="fa fa-file-text"></i><span>MENU</span></a></li>
      <li><a href="report.php"><i class="fa fa-print"></i><span>REPORT</span></a></li>
      <li><a href="pos.php"><i class="fa fa-shopping-cart"></i><span>POS</span></a></li>
      <?php } else { ?>
      <li><a href="index.php"><i class="fa fa-dashboard"></i><span>DASHBOARD</span></a></li>
      <li><a href="pos.php"><i class="fa fa-shopping-cart"></i><span>POS</span></a></li>
      <li><a href="report.php"><i class="fa fa-shopping-cart"></i><span>REPORT</span></a></li>
      <?php } ?>
      <li>
        <a href="modal/user.php?do=logout" onclick="return  confirm('Do you want to logout ?')">
          <i class="fa fa-sign-out"></i> 
          <span>LOGOUT</span>
        </a>
      </li>
    </ul>
  </section>
</aside>