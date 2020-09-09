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
    User
      <small>Activity Logs</small>
    </h1> 
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        <div class="box box-warning">
          <div class="box-header">
            <!-- /result -->
            <a class="box-title">  <?php if(isset($_GET['r'])): ?>
              <?php
              $r = $_GET['r'];
              if($r=='added'){
                $classs='success';   
              }else if($r=='updated'){
                $classs='info';   
              }else if($r=='deleted'){
                $classs='danger';   
              }else{
                $classs='hide';
              }
              ?>
              <div class="alert alert-<?php echo $classs?> <?php echo $classs; ?>">
                <strong>Successfully <?php echo $r; ?>!</strong>    
              </div>
            <?php endif; ?></a> 
             
          </div> 

          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th> 
                  <th>Role</th> 
                  <th>Date / Time</th>  
                  <th>Action</th>     
                </tr>
              </thead>
              <tbody> 
                <tr>     
                  <?php  
                  $result = $db->prepare("SELECT *,ua.id as uaid FROM tbl_users u INNER JOIN tbl_ualt ua ON u.id=ua.userID  ORDER BY ua.id DESC");
                  $result->execute();
                  for($i=1; $row = $result->fetch(); $i++){ 
                    $id = $row['uaid'];  ?> 
                    <td> <?php  echo $i; ?></td>   
                    <td> <?php  echo $row['lname']. ' '.$row['fname']; ?></td>  
                    <td> <?php  echo $row['role']; ?></td>       
                    <td> <?php  echo $row['dt']; ?></td>      
                    <td> <?php  echo $row['action']; ?></td>    
                    
                  </tr>

                </tfoot>   <?php } ?>
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
  
</div>
 

<?php include_once('layout/footer.php');  
include_once('layout/buttomscript.php');  
?>