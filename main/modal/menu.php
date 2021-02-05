<?php 
  include_once('../connect.php'); 

  if ($_GET['do']=='addcategory') { //add a new category
    $category = $_POST['category'];  
    $result = $db->prepare("SELECT * FROM tbl_category WHERE category='$category' ");
    $result->execute(); 
    if($row = $result->fetch()) {
      $message = "Category already exist.";
      echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
      exit();
    } else {  
      $q = $db->prepare("INSERT INTO tbl_category(category) VALUES ('$category')");
      $q->execute(array());	
      echo "<script type='text/javascript'>window.location.href='../menu.php';</script>";
    //   header("location: ../menu.php?r=added");
      exit();
    } 
  }

  if ($_GET['do']=='deletecategory') { // delete existing category
    $category = $_POST['category'];  

    $result = $db->prepare("SELECT * FROM tbl_menu WHERE category='".$category."'");
    $result->execute(); 
    if($row = $result->fetch()){
      $message = "please remove items from category before deleting";
      echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
      exit();
    }else{
      $sql = "DELETE FROM tbl_category WHERE category ='".$category."'";
      $q = $db->prepare($sql);
      $q->execute(array());
    //   header("location: ../menu.php?r=updated");
    echo "<script type='text/javascript'>window.location.href='../menu.php';</script>";
      exit();
      
    }
  }

  if(isset($_POST['pname'])) {  
    $pname = strtoupper($_POST['pname']);
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $imgUrl = $_FILES["imgUrl"]["name"]; 

    $temp = $_FILES["imgUrl"]["tmp_name"]; 
    $name = $_FILES["imgUrl"]["name"]; 
    move_uploaded_file($temp,"../assets/uploaded/".$name);
  }

  if ($_GET['do']=='add') { //add menu
    $result = $db->prepare("SELECT * FROM tbl_menu WHERE name='".$pname."'");
    $result->execute(); 
    if($row = $result->fetch()){
      $message = "This item already exist.";
      echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
      exit();
    }else{ 
      $result_menu = $db->prepare("SELECT * FROM tbl_category WHERE category='".$category."'");
      $result_menu->execute();
      $data;

      for ($i = 0; $row = $result_menu->fetch(); $i++) {
        $data = $row['id'];
      }

      $sql = "INSERT INTO tbl_menu(code, name, description, price,  category, imgUrl) VALUES ('$data', '$pname', '$description', '$price', '$category', '$imgUrl')";
      $q = $db->prepare($sql);
      $q->execute(array());	
    //   header("location: ../menu.php?r=added");
    echo "<script type='text/javascript'>window.location.href='../menu.php';</script>";
      exit();
      
    }
  } 

  if (isset($_GET['id'])) {
    $id=$_GET['id'];  
    if ($_GET['do']=='edit') { // edit existing item
      
      $result_menu = $db->prepare("SELECT * FROM tbl_category WHERE category='".$category."'");
      $result_menu->execute();
      $data;
      for ($i = 0; $row = $result_menu->fetch(); $i++) {
        $data = $row['id'];
      }

      if ($imgUrl == ""){
        $imgUrl = $_POST['imgUrl1']; 
      }
      $sql = "UPDATE tbl_menu SET  code=?, name=?, description=?, price=?, category=?, imgUrl=? WHERE id=?";
      $q = $db->prepare($sql);
      $q->execute(array($data,$pname,$description,$price,$category,$imgUrl,$id));
    //   header("location: ../menu.php?r=updated");
    echo "<script type='text/javascript'>window.location.href='../menu.php';</script>";
    }
    if ($_GET['do']=='delete') { // delete an existing item
      
      $sql = "DELETE FROM tbl_menu WHERE id ='".$id."'";
      $q = $db->prepare($sql);
      $q->execute(array());
    //   header("location: ../menu.php?r=updated");
      echo "<script type='text/javascript'>window.location.href='../menu.php';</script>";
      
    }
  }
?>