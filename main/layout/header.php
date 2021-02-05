<header class="main-header" id="mainHeader">
  <a href="#" class="logo">
    <span class="logo-mini"><b>CB</b></span>
    <span class="logo-lg"><b> Cielo's Burger</b></span>
  </a>
  <nav class="navbar">
    <a href="#" class="sidebar-toggle h4" data-toggle="push-menu" role="button" style="margin: 0px;">

    </a>
    <div class="navbar-custom-menu" >
      <ul class="nav navbar-nav" >
        <li class="dropdown user user-menu" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
            <p class="h4" style="padding:0px; margin:0px;">
            <b><?php echo $_SESSION['fullname'];?>&nbsp; &nbsp; </b>
            <i class="fa fa-caret-down fa-lg"></i>
            </p>
          </a>
          <ul class="dropdown-menu" style="width:220px;" >
            <li>
                <?php $id = $_SESSION['userID']; ?>
                <a style="height:35px; padding-bottom: 12px; padding-top:0px;"  data-toggle="modal" data-target="#userDetails<?php echo $id; ?>"  type="submit" class="btn btn-flat">
                  <h5 style="color:grey;"><b>User Details</b></h5>
                </a>
            </li>
            <li>
                <?php $id = $_SESSION['userID']; ?>
                <a style="height:35px; padding-bottom: 12px; padding-top:0px;"  data-toggle="modal" data-target="#updatePassword<?php echo $id; ?>" type="submit" class="btn btn-flat">
                  <h5 style="color:grey;"><b>Change Password</b></h5>
                </a>
            </li>
            <li>
                <a style="height:35px; padding-bottom: 12px; padding-top:0px;" href="modal/user.php?do=logout" onclick="return  confirm('Do you want to logout ?')" class="btn btn-flat bg-dark">
                  <h5 style="color:grey;"><b>Log Out</b></h5>
                </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- change password dialog box -->
<?php 
$result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC");
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
  $id = $row['id']; ?>
  <div class="modal fade" id="updatePassword<?php echo $id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Update Password</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="modal/user.php?do=changePasswordUser&id=<?php echo $id; ?>" method="post">
            <div class="box-body">
              <input value="<?php echo $row['id']; ?>" type="hidden" class="form-control" name="id">
              <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input value="<?php echo $row['username']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">New Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="newPassword" type="password" placeholder="new password" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Re-type Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="retypePassword" type="password" placeholder="retype password" required>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php $result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC");
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
  $id = $row['id']; ?>
  <div class="modal fade" id="userDetails<?php echo $id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">User Details:</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="modal/user.php?do=changePasswordUser&id=<?php echo $id; ?>" method="post">
            <div class="box-body">
              <input value="<?php echo $row['id']; ?>" type="hidden" class="form-control" name="id">
              <div class="form-group">
                <label class="col-sm-2 control-label">Full Name: </label>
                <div class="col-sm-10">
                  <input value="<?php echo $_SESSION['fullname']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Employee ID: </label>
                <div class="col-sm-10">
                  <input value="<?php echo $_SESSION['userNo']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Username:</label>
                <div class="col-sm-10">
                  <input value="<?php echo $row['username']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Role: </label>
                <div class="col-sm-10">
                  <input value="<?php echo $_SESSION['role']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
                </div>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>