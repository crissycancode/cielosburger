<?php 
include_once('../connect.php'); 

   if ($_GET['do']=='removeDis') { 
 unset($_SESSION['cusType']);
  unset($_SESSION['disNo']);
  unset($_SESSION['disName']);
  $_SESSION['cusType']='Walk-in';
  $message = "Discount successfully removed.";
      echo "<script type='text/javascript'>alert('$message');window.location.href='../pos.php';</script>";

}


if ($_GET['do']=='addtable') { //Insert  table 
	
	$code = $_POST['code'];  
	$result = $db->prepare("SELECT * FROM tbl_table WHERE code='$code' ");
	$result->execute(); 
	if($row = $result->fetch()) {
		$message = "Table is existed.";
		echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
		exit();
	} else {  
		$q = $db->prepare("INSERT INTO tbl_table(code) VALUES ('$code')");
		$q->execute(array());	
		header("location: ../menu.php?r=added");
		exit();
	} 
}

if ($_GET['do']=='addcategory') { //Insert  Category 
	$category = $_POST['category'];  
	$result = $db->prepare("SELECT * FROM tbl_category WHERE category='$category' ");
	$result->execute(); 
	if($row = $result->fetch()) {
		$message = "Category is existed.";
		echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
		exit();
	} else {  
		$q = $db->prepare("INSERT INTO tbl_category(category) VALUES ('$category')");
		$q->execute(array());	
		header("location: ../menu.php?r=added");
		exit();
	} 
}

if(isset($_POST['code'])) {
	$code = strtoupper($_POST['code']);
	$pname = strtoupper($_POST['pname']);
	$description = $_POST['description'];
	$price = $_POST['price'];
	$category = $_POST['category'];
	$imgUrl = $_FILES["imgUrl"]["name"]; 

	$temp = $_FILES["imgUrl"]["tmp_name"]; 
	$name = $_FILES["imgUrl"]["name"]; 
	move_uploaded_file($temp,"../assets/uploaded/".$name);

}

if ($_GET['do']=='add') { //Insert 

	$result = $db->prepare("SELECT * FROM tbl_menu WHERE code='$code' OR name='$pname' ");
	$result->execute(); 
	if($row = $result->fetch()) {
		$message = "Menu is existed.";
		echo "<script type='text/javascript'>alert('$message');window.location.href='../menu.php';</script>";
		exit();
	} else { 

		$sql = "INSERT INTO tbl_menu(code, name, description, price,  category, imgUrl) VALUES ('$code', '$pname', '$description', '$price', '$category', '$imgUrl')";
		$q = $db->prepare($sql);
		$q->execute(array());	
		header("location: ../menu.php?r=added");
		exit();
	}
} 

if (isset($_GET['id'])) {
	$id=$_GET['id'];  
	if ($_GET['do']=='edit') { //Edit  

		if ($imgUrl == ""){
			$imgUrl = $_POST['imgUrl1']; 
		}
		$sql = "UPDATE tbl_menu SET  code=?, name=?, description=?, price=?, category=?, imgUrl=? WHERE id=?";
		$q = $db->prepare($sql);
		$q->execute(array($code,$pname,$description,$price,$category,$imgUrl,$id));
		header("location: ../menu.php?r=updated");
	}
}



?>