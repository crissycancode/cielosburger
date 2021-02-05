<?php
  include_once('connect.php');
  include_once('layout/head.php');
  include_once('layout/header.php');
  include_once('layout/sidebar.php');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Employee Accounts</h1>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-warning">
          <div class="box-header">
            <a mycart="" data-toggle="modal" data-target="#add" type="submit" class="btn btn-primary pull-right btn-m ">
              <i class="fa fa-plus"></i> 
              Add Account 
            </a>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC");
                  $result->execute();
                  for ($i = 1; $row = $result->fetch(); $i++) {
                    $id = $row['id']; ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['userNo']; ?></td>
                      <td><?php echo $row['lname']; ?></td>
                      <td><?php echo $row['fname']; ?></td>
                      <td><?php echo $row['role']; ?></td>
                      <td><?php echo $row['username']; ?></td>
                      <!-- <td><?php echo $row['active']; ?></td> -->
              <?php if($row['active']=="active"){?>
                      <td style="color:green; font-weight: bold"><?php echo $row['active']; ?></td>
              <?php }else{?> 
                      <td style="color:red; font-weight: bold"><?php echo $row['active']; ?></td>
              <?php } ?>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-fw fa-gear"></i>
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="#edit<?php echo $id; ?>" data-toggle="modal">
                                <i class="fa fa-fw fa-pencil"> Edit</i>
                              </a>
                            </li>
                            <li>
                              <a href="#updatePassword<?php echo $id; ?>" data-toggle="modal">
                                <i class="fa fa-fw fa-user"> Change Password</i>
                              </a>
                            </li>
                            <li>
                              <a href="modal/user.php?do=delete&id=<?php echo $id; ?>" onclick="return  confirm('would you like to delete this user?')">
                                <i class="fa fa-fw fa-trash">Delete</i>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- /.Add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Fill Employee Details</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="modal/user.php?do=add" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <?php $result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC LIMIT 1");
            // <?php $result = $db->prepare("SELECT COUNT(*) FROM tbl_users ORDER BY id DESC LIMIT 1");
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $dateToday = date('ymd');
                $generateId = $row['0'] + 1; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Employee ID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo 'CB-' . $dateToday . '-' . $generateId; ?>" name="userNo" placeholder="Employee ID" readonly required>
              </div>
            </div>
            <?php } ?>
            <!-- <div class="form-group">
              <label class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="<?php echo 'CB-' . $dateToday . '-' . $generateId; ?>" name="userNo" placeholder="Employee ID" readonly required>
              </div>
            </div> -->
            <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Role</label>
              <div class="col-sm-10">
                <select name="role" class="form-control" required>
                  <option>staff</option>
                  <option>admin</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">First Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="firstname" placeholder="Firstname" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Last Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="lastname" placeholder="Lastname" autofocus required>
              </div>
            </div>
            <!-- <div class="form-group"><label class="col-sm-2 control-label">User Status</label>
              <div class="col-sm-10">
              <select name="active" class="form-control" required >
                  <option>active</option>
                  <option>inactive</option>
                </select>
              </div>
            </div> -->
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

<?php $result = $db->prepare("SELECT * FROM tbl_users ORDER BY id DESC");
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
$id = $row['id']; ?>
<!-- /.Edit -->
<div class="modal fade" id="edit<?php echo $id; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Edit</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="modal/user.php?do=edit&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
          <!-- <input type="hidden" name="pic1" value="<?php echo $row['pic']; ?>" class="form-control">
          <div class="form-group">
            <label class="col-sm-2 control-label">Employee Picture</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="pic" required>
            </div>
          </div> -->
          <div class="box-body">
            <input value="<?php echo $row['id']; ?>" type="hidden" class="form-control" name="id">
            <div class="form-group">
              <label class="col-sm-2 control-label">ID</label>
              <div class="col-sm-10">
                  <input value="<?php echo $row['userNo']; ?>" type="text" class="form-control" name="userID" placeholder="Employee ID" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Lastname</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['lname']; ?>" type="text" class="form-control" name="lastname" placeholder="Lastname" autofocus required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Firstname</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['fname']; ?>" type="text" class="form-control" name="firstname" placeholder="Firstname" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Role</label>
              <div class="col-sm-10">
                <select name="role" class="form-control" required>
                  <option><?php echo $row['role']; ?></option>
                  <option>admin</option>
                  <option>staff</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['username']; ?>" type="text" class="form-control" name="username" placeholder="Username" required readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['password']; ?>" type="password" class="form-control" name="password" placeholder="Password" required readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">User Status</label>
              <div class="col-sm-10">
                <select name="active" class="form-control" required>
                  <option><?php echo $row['active']; ?></option>
                  <option>active</option>
                  <option>inactive</option>
                </select>
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

<?php 
  include_once('layout/footer.php');
  include_once('layout/buttomscript.php');
?>