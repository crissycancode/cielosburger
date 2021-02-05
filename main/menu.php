<?php
  include_once('connect.php');
  include_once('layout/head.php');
  include_once('layout/header.php');
  include_once('layout/sidebar.php');
?>
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-warning">
          <div class="box-header">
            <a mycart="" data-toggle="modal" data-target="#addcat" type="submit" class="btn btn-success pull-right btn-m ">
              <i class="fa fa-plus"></i>
              Category
            </a>
            <a mycart="" data-toggle="modal" data-target="#add" type="submit" class="btn btn-primary pull-right btn-m ">
              <i class="fa fa-plus"></i> 
              Menu
            </a>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="test">
                  <?php
                  $result = $db->prepare("SELECT * FROM tbl_menu ORDER BY id DESC");
                  $result->execute();
                  for ($i = 1; $row = $result->fetch(); $i++) {
                      $id = $row['id']; ?>
                  <tr>
                    <td> <?php echo $i; ?></td>
                    <td>
                      <img height="50" width="50" src="assets/uploaded/<?= $row['imgUrl']; ?>">
                    </td>
                    <td> <?= $row['code']; ?></td>
                    <td> <?= $row['name']; ?></td>
                    <td> <?= $row['category']; ?></td>
                    <td> <?= $row['price']; ?></td>
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
                            <a href="modal/menu.php?do=delete&id=<?php echo $id; ?>" onclick="return  confirm('are you sure you want to delete this item?')" method="post">
                              <i class="fa fa-fw fa-trash"> Delete</i>
                            </a>
                          </li>
                        </ul>
                      </div><br/>
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

<!-- /.Add Menu Item-->
<div class="modal fade" id="add" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Add</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="modal/menu.php?do=add" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="pname" placeholder="Name" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="description" placeholder="Description (optional)" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10">
                <input type="number" step="0.01" class="form-control" name="price" placeholder="Price" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Category</label>
              <div class="col-sm-10">
                <select name="category" class="form-control" required>
                    <?php
                    $result = $db->prepare("SELECT * FROM tbl_category");
                    $result->execute();
                    for ($i = 0; $rows = $result->fetch(); $i++) { ?>
                        <option value="<?php echo $rows['category']; ?>"><?php echo $rows['category']; ?></option>
                    <?php } ?>
                </select><br>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Upload Image</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" name="imgUrl" placeholder="Choose Image" required>
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

<?php $result = $db->prepare("SELECT * FROM tbl_menu ORDER BY id DESC");
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
$id = $row['id']; ?>
<!-- /.Edit Item -->
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
        <form class="form-horizontal" action="modal/menu.php?do=edit&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Code</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['code']; ?>" type="text" class="form-control code" name="code" placeholder="Code" autofocus  readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['name']; ?>" type="text" class="form-control" name="pname" placeholder="Name" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['description']; ?>" type="text" class="form-control" name="description" placeholder="Description">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10">
                <input value="<?php echo $row['price']; ?>" type="number" step="0.01" class="form-control" name="price" placeholder="Price" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Category</label>
              <div class="col-sm-10">
                <select  name="category" class="form-control catergory" required>
                  <option selected><?php echo $row['category']; ?></option>
                    <?php
                    $r = $db->prepare("SELECT * FROM tbl_category");
                    $r->execute();
                    for ($i = 0; $rows = $r->fetch(); $i++) { ?>
                      <option><?php echo $rows['category']; ?></option>
                    <?php } ?>
                </select><br>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Upload Image</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" name="imgUrl" placeholder="Choose Image">
                <input value="<?php echo $row['imgUrl']; ?>" type="hidden" class="form-control" name="imgUrl1">
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


<!-- /.Add Category-->
<div class="modal fade" id="addcat" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Add Category</h4>
      </div> 
      <div class="modal-body">
      <div class="box-body">
        <form class="form-horizontal" action="modal/menu.php?do=deletecategory" method="post" enctype="multipart/form-data"> 
            <div class="form-group"><label class="col-sm-2 control-label">Categories</label>
              <div class="col-sm-10">
                <select name="category" class="form-control" required>
                  <?php
                  $result = $db->prepare("SELECT * FROM tbl_category");
                  $result->execute();
                  for ($i = 0; $rows = $result->fetch(); $i++) { ?>
                    <option><?php echo $rows['category']; ?></option>
                  <?php } ?>
                </select><br>
                <div class="modal-footer">
                  <button type="submit" onclick="return  confirm('are you sure you want to delete this item?')" class="btn btn-primary pull-right">delete category</button>
                </div>
              </div>
            </div>
        </form>
        <form class="form-horizontal" action="modal/menu.php?do=addcategory" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-2 control-label">Add New Category</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="category" placeholder="New Category" autofocus required>
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

<?php 
  include_once('layout/footer.php');
  include_once('layout/buttomscript.php'); 
?>